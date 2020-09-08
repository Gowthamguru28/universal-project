<?php

namespace App\Http\Controllers\admin\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\UserManagement;
use Auth;
use App\UserRto;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        if(Auth::user()->isDistributor()) {
            $distributorRto = UserRto::where('user_id', Auth::user()->id)->pluck('rto_id');
            $data =  User::whereHas('tnrto' , function($query) use($distributorRto) {
                        $query->whereIn('rto_id', $distributorRto);
            })->whereIn('role', [3])->with('details')->get();
         } else { 
            $data =  User::whereIn('role', [2,3])->with('details')->get();
         }
        
        return view('admin.user.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->isDistributor()) {
            $rto = UserRto::with('rto')->where('user_id', Auth::user()->id)->get();
            // $data =  User::with(['tnrto' => function($query) use($distributorRto) {
            //             $query->whereIn('rto_id', $distributorRto);
            // }])->whereIn('role', [3])->with('details')->with('details.rto')->get();
             $rto = array_pluck($rto, 'rto');
        } else {
            $rto =  User::where('role', 4)->get();
        }
        
        return view('admin.user.create')->with(compact('rto'));
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
            'name' => 'required',
            'mobile_no' => 'integer|required',
            'address' => 'required',
            'rto_id' =>  'required',
            'company_name' =>  'required',
            'company_logo' =>  'required',
            'role' =>  'required'
        ]); 
         
        $user = array();
        $user['email'] = $request->email;
        $user['password'] = Hash::make($request->password);
        $user['name'] = $request->name;
        $user['role'] = $request->role;
        
        $insertId = User::create($user);

        $details = array();
        //$details['rto_id'] = $request->rto_id;
        $details['mobile_no'] = $request->mobile_no;
        $details['address'] = $request->address;
        $details['company_name'] = $request->company_name;
        $details['user_id'] = $insertId->id;
        $fileName = time().'.'.$request->company_logo->extension();  
        $request->company_logo->move(public_path('uploads'), $fileName);
        $details['company_logo'] = $fileName;

        UserManagement::create($details);

        foreach($request->rto_id as $va=>$key) {
            UserRto::insert(['user_id'=> $insertId->id, 'rto_id'=>$key]);
        }

        return redirect('users');
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
       
        if(Auth::user()->isDistributor()) {
            $rto = UserRto::with('rto')->where('user_id', Auth::user()->id)->get();
            // $data =  User::with(['tnrto' => function($query) use($distributorRto) {
            //             $query->whereIn('rto_id', $distributorRto);
            // }])->whereIn('role', [3])->with('details')->with('details.rto')->get();
             $rto = array_pluck($rto, 'rto');
        } else {
            $rto =  User::where('role', 4)->get();
        }
        $data =  User::where('id', $id)->with(['details', 'tnrto.rto'])->first(); 
        return view('admin.user.edit')->with(compact('data', 'rto'));
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
            //'email' => 'required|unique:users,email,'.$id,
            'email' => 'required|unique:users,email,'.$id,
            'name' => 'required',
            'mobile_no' => 'integer|required',
            'address' => 'required',
            'rto_id' =>  'required',
            'company_name' =>  'required',
            'role' =>  'required'
        ]); 
        $user = array();
        $details = array();
        if(!isset($request->uploadedName )) {
            $validatedData = $request->validate([
                'company_logo' => 'required',
            ]); 
           // return $request;
            $fileName = time().'.'.$request->company_logo->extension();  
            $request->company_logo->move(public_path('uploads'), $fileName);
            $details['company_logo'] =  $fileName;
        }
        if($request->password != '' || $request->confirm_password != '') {
            $validatedData = $request->validate([
                'password' => ['required'],
                'confirm_password' => ['required','same:password'],
            ]); 
            $user['password'] = Hash::make($request->password);
        }
        $user['email'] = $request->email;
        $user['name'] = $request->name;
        $user['role'] = $request->role;
        User::where('id', $id)->update($user);

        //$details['rto_id'] = 2;
        $details['mobile_no'] = $request->mobile_no;
        $details['address'] = $request->address;
        $details['company_name'] = $request->company_name;
        UserManagement::where('user_id', $id)->update($details);

        UserRto::where('user_id', $id)->delete();
        
        foreach($request->rto_id as $va=>$key) {
            UserRto::insert(['user_id'=>$id, 'rto_id'=>$key]);
        }
        
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect('users');
    }
}
