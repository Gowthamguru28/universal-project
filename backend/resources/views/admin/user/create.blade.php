@extends('layouts.master')
@section('content')
<div class="container-fluid">
          <div class="row">
            <form class="company-creation-form" method="post" action="{{ URL::route('users.store') }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Role</label>
                    <select class="form-control" name="role" id="exampleFormControlSelect1">
                        <option value="">Select Role</option>
                        @if(!Auth::user()->isDistributor())
                        <option value="2" @if(old('role') == 2) selected @endif>Distributor</option>
                        @endif
                            <option value="3" @if(old('role') == 3) selected @endif >Dealer</option>
                    </select>
                    <span style="color:red;">{{ $errors->first('role') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter your Name">
                  <span style="color:red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile</label>
                  <input type="number" class="form-control" value="{{ old('mobile_no') }}" name="mobile_no" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Mobile number">
                  <span style="color:red;">{{ $errors->first('mobile_no') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email</label>
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
                    <span style="color:red;">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control"  name="password" id="exampleInputPassword1" placeholder="Password">
                    <span style="color:red;">{{ $errors->first('password') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="exampleInputPassword1" placeholder="Password">
                    <span style="color:red;">{{ $errors->first('confirm_password') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Address</label>
                    <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3">{{ old('address') }}</textarea>
                    <span style="color:red;">{{ $errors->first('address') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">RTO</label>
                  <select class="form-control" name="rto_id" id="exampleFormControlSelect1">
                    <option>Select RTO</option>
                    @foreach($rto as $va=>$key)
                        <option value="{{ $key->id }}" @if(old('rto_id') == $key->id) selected @endif>{{ $key->email }}</option>
                    @endforeach
                   
                    </select>
                    <span style="color:red;">{{ $errors->first('rto_id') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Company Name</label>
                  <input type="text" class="form-control"  value="{{ old('company_name') }}" name="company_name" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Company Name">
                  <span style="color:red;">{{ $errors->first('company_name') }}</span>
                </div>
                <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Choose Logo</label>
                    <input type="file" class="form-control-file"  name="company_logo" id="exampleFormControlFile1">
                    <span style="color:red;">{{ $errors->first('company_logo') }}</span>
                  </div> 
                         @csrf 
                         @method('post')
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
@endsection