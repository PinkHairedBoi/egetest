<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Image;
use App\Question;
use App\Test;
use Auth;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function index()
    {
        return Question::with('images')->get();
    }

    public function getQuestions(Request $request)
    {
        $test_id = $request->test_id;
        if ($test_id != -1) {
            return Question::select('id', 'question', 'answer')->where('test_id', $test_id)->with('images')->get()->toArray();
        } else {
            return Question::select('id', 'question', 'answer')->with('images')->get()->toArray();
        }

    }

    public function getRawQuestions(Request $request)
    {
        $test_id = $request->test_id;
        return Question::select('id', 'question', 'answer')->where('test_id', $test_id)->get()->toArray();
    }

    public function store(Request $request)
    {
        $q = Question::create($request->all());

        $this->validate($request, [
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif',
        ]);

        if ($request->has('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path() . '/images/', $name);
                $q->images()->create([
                    'src' => '/images/' . $name,
                    'question_id' => $q->id,
                ]);
            }
        }
    }
    public function show($id)
    {
        return Question::with('images')->find($id) ?? response()->json(['error' => 'Такого вопроса не существует.']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif',
        ]);

        $q = Question::findOrFail($id);

        $q->fill($request->all());

        if ($request->has('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path() . '/images/', $name);
                $q->images()->create([
                    'src' => '/images/' . $name,
                    'question_id' => $q->id,
                ]);
            }
        }
        $q->save();
    }

    public function copy(Request $request)
    {
        $test_id = $request->test_id;
        $q = Question::findOrFail($request->id);
        $newq = $q->replicate();
        $newq->test_id = $test_id;
        $newq->save();
        foreach ($q->images as $img) {
            $newimg = $img->replicate();
            $newimg->question_id = $newq->id;
            $newimg->save();
        }
    }

    public function destroy($id)
    {
        $q = Question::findOrFail($id);
        $q->users = null;
        $q->delete();
    }

    public function removeImage($id)
    {
        Image::findOrFail($id)->delete();
    }

    public function get()
    {
        $u = Auth::user();
        if ($u->test == null) {
            if (Test::all()->min('id') == null) {
                return response()->json(['finished' => true]);
            }

            Test::find(Test::all()->min('id'))->users()->save($u);
            $u->refresh();
        }

        $qlist = Question::with('images')->where('test_id', '=', $u->test->id)->get()->makeHidden('answer');
        $answeredqlist = $u->answers()->with('question')->where('this_attempt', '=', 1)->get()->pluck('question');
        $nonanswered = $qlist->toBase()->diff($answeredqlist->toBase())->all();
        if (count($nonanswered) == 0) {
            $testpassed = true;

            foreach ($u->answers->where('this_attempt') as $a) {
                if (!$a->is_right) {
                    $testpassed = false;
                    break;
                }
            }
            if ($testpassed) {
                if (Test::where('id', '>', $u->test->id)->min('id') == null) {
                    return response()->json(['finished' => true]);
                }

                $newtest = Test::findOrFail(Test::where('id', '>', $u->test->id)->min('id'))->users()->save($u);
                return response()->json(['passed' => true]);
            } else {

                foreach ($u->answers->where('this_attempt') as $a) {
                    $a->this_attempt = false;
                    $a->save();
                }
                $u->attempt++;
                $u->save();
                return response()->json(['passed' => false]);
            }
        } else {
            $q = $nonanswered[array_rand($nonanswered)];
            $q->users()->save($u);
            return response()->json(['q' => $q, 'qnum' => count($answeredqlist) + 1, 'qtotal' => $u->test->questions->count()]);
        }

    }

    public function answer(Request $request)
    {
        $answer = $request->answer;
        $u = Auth::user();
        $q = $u->question;
        if (!$q) {
            return response()->json(['error' => 'Не был запрошен вопрос']);
        } else {
            $u->answers()->create([
                'question_id' => $q->id,
                'is_right' => $q->answer == $answer,
                'attempt' => $u->attempt,
            ]);
            $u->question_id = null;
            $u->save();
            return json_encode($q->answer == $answer);
        }
    }
}
