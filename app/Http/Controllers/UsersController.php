<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Redirect,Response;

class UsersController extends Controller
{
    public function index()
	{
	    if(request()->ajax()) {
	        return datatables()->of(User::select('*'))
						       ->addColumn('action', 'action_button')
						       ->rawColumns(['action'])
						       ->addIndexColumn()
						       ->make(true);
	    }
	    return view('list');
	}

	public function store(Request $request)
	{
	    $userId = $request->user_id;
	    $user   =   User::updateOrCreate(['id' => $userId],
	                ['name' => $request->name, 'email' => $request->email]);
	    return Response::json($user);
	}

	public function edit($id)
	{
	    $where = array('id' => $id);
	    $user  = User::where($where)->first();

	    return Response::json($user);
	}

	public function destroy($id)
	{
	    $user = User::where('id',$id)->delete();

	    return Response::json($user);
	}
}
