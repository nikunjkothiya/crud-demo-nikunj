<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Gate;
use DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\UserRecords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = UserRecords::all();
        return view('user_records.index', compact('records'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Also we can use server side validation from this code but right now I am not use
       /*  $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:user_records',
            'avatar'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:512',
            'date_joining' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), $this->statusArr['validation']);
        } */

        $file = $request->file('avatar');
        $destinationPath = public_path() . '/avatar/';
        $image = time() . $file->getClientOriginalName();
        $file->move($destinationPath, $image);
        $imgpath = 'avatar/' . $image;

        $add_user = new UserRecords();
        $add_user->name = $request->name;
        $add_user->avatar =  $imgpath;
        $add_user->email = $request->email;
        $add_user->date_joining = $request->date_joining;
        if (isset($request->date_leaving)) {
            $add_user->date_leaving = $request->date_leaving;
        } else {
            $add_user->date_leaving = '';
        }
        $add_user->save();

        return redirect()->back()->with('message', 'User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function editProfile(Request $request)
    {
    
        $details = UserRecords::find($request->id);
        return response()->json(['success' => 'Get profile successfully', 'detail' => $details]);
    }


    public function updateProfile(Request $request)
    {
        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $destinationPath = public_path() . '/avatar/';
            $image = time() . $file->getClientOriginalName();
            $file->move($destinationPath, $image);
            $imgpath = 'avatar/' . $image;
        } else {
            $imgpath = $request->avatar_old;
        }

        $add_user = UserRecords::find($request->user_id);
        
        $add_user->name = $request->name;
        $add_user->avatar =  $imgpath;
        $add_user->email = $request->email;
        $add_user->date_joining = $request->date_joining;
        if (isset($request->date_leaving)) {
            $add_user->date_leaving = $request->date_leaving;
        } else {
            $add_user->date_leaving = '';
        }
        $add_user->save();

        return back()->with('message', 'User Updated Successfully');
    }

    public function delete(Request $request)
    {
        $user = UserRecords::findOrFail($request->user_id);
        $user->delete();
        return back()->with('message', 'User Deleted Successfully');
    }
}
