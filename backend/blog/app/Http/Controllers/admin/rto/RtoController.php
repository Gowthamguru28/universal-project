<?php

namespace App\Http\Controllers\admin\rto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class RtoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  User::where('role', 4)->get();
        return view('admin.rto.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|unique:users',
            'password' => ['required'],
            'confirm_password' => ['required','same:password'],
        ]); 
        $data = request()->except(['_token','_method', 'confirm_password']);
        $data['role'] = 4;
        $data['password'] = Hash::make('password');
       // return $data;
        User::insert($data);
        return redirect('admin/rto');
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
        $user = User::where('id', $id)->first();
        return view('admin.rto.edit')->with(compact('user'));
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
        $validatedData = $request->validate([
            'email' => 'required|unique:users,email,'.$id
        ]); 
        if ($request->password !='' || $request->confirm_password != '') {
            $validatedData = $request->validate([
                'password' => ['required'],
                'confirm_password' => ['required','same:password'],
            ]); 
            //$data = request()->except(['_token','_method', 'confirm_password']);
            $data['password'] = Hash::make($request['password']);
        } else {
            unset($request['password']);
            
        }
        unset($data['_token']);
        unset($data['_method']);
        unset($data['confirm_password']);
        //return $data;
        User::where('id', $id)->update($data);
        return redirect('admin/rto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
