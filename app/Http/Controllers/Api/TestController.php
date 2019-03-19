<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Test::with('questions')->orderBy('order')->get();
    }

    public function getTests()
    {
        return Test::all('id', 'order', 'name')->sortBy('order');
    }

    public function move(Request $request)
    {
        $oldorder = $request->oldorder;
        $neworder = $request->neworder;
        $this->swap($oldorder, $neworder);
    }

    public function swap($oldorder, $neworder)
    {
        $test = Test::where('order', $oldorder)->first();
        $changetest = Test::where('order', $neworder)->first();
        if (!$changetest || !$test) {
            return response()->json([
                'error' => 'Не с кем меняться... Возможно кто-то ещё в админке? Просто обнови страницу.',
            ], 422);
        }
        $test->order = $neworder;
        $changetest->order = $oldorder;
        $test->save();
        $changetest->save();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $test = new Test;
        $test->name = $request->name;
        if (Test::orderBy('order', 'desc')->first()) {
            $test->order = Test::orderBy('order', 'desc')->first()->order + 1;
        } else {
            $test->order = 1;
        }
        $test->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Test::find($id) ?? response()->json(['error' => 'Такого теста не существует.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        if ($request->order < 0 || $request->order > Test::max('order')) {
            return response()->json(['error' => 'Недопустимый порядок'], 422);
        }

        $this->swap($test->order, $request->order);
        $test->name = $request->name;
        $test->save();
        return $test;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testtodel = Test::find($id);
        foreach (Test::where('order', '>', $testtodel->order)->cursor() as $test) {
            $test->order--;
            $test->save();
        }
        $testtodel->delete();
    }
}
