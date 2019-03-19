<?php

namespace App\Http\Controllers\Api;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Test;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Answer::with('question.test', 'user')->get();
    }

    public function getAttempts(Request $request)
    {
        $test_id = $request->test_id;
        $user_id = $request->user_id;
        $q_ids = Test::find($test_id)->questions()->pluck('id')->toArray();
        return Answer::where('user_id', $user_id)->whereIn('question_id', $q_ids)->max('attempt');
    }

    public function getAnswers(Request $request)
    {
        $question_id = $request->question_id;
        $test_id = !empty($question_id) ? null : $request->test_id;
        $user_id = $request->user_id;
        $attempt = $request->attempt;
        $query = Answer::with(['question:id,question', 'user:id,name'])->limit(60)->orderBy('created_at','desc');
        if (!empty($question_id)) {
            $query->where('question_id', $question_id);
        }

        if (!empty($user_id)) {
            $query->where('user_id', $user_id);
        }

        if (!empty($attempt)) {
            $query->where('attempt', $attempt);
        }

        if (!empty($test_id)) {
            $q_ids = Test::find($test_id)->questions()->pluck('id')->toArray();
            $query->whereIn('question_id', $q_ids);
        }
        return $query->get(['id', 'is_right', 'attempt', 'question_id', 'user_id', 'created_at']);
    }
}
