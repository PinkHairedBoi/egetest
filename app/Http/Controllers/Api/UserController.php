<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Test;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $u = new User;
        $u->name = $request->name;
        $u->password = Hash::make($request->name);
        $u->test_id = Test::find(Test::min('id'))->id;
        $u->save();
    }

    public function index()
    {
        return User::all('id','name','test_id');
    }

    public function getUsers()
    {
        return User::select('id', 'name')->get()->toArray();
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();;
    }

    public function me()
    {
        return Auth::user();
    }

    public function update(Request $request, $id)
    {
        $u = User::find($id);
        $u->test_id = $request->test_id;
        $u->save();
    }
}
