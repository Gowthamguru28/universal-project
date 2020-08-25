@extends('layouts.master')
@section('content')
<div class="container-fluid">
          <div class="row">
            <form class="company-creation-form" action="{{ route('rto.update', $user->id) }}" method="post">
               
                <div class="form-group">
                  <label for="exampleInputEmail1">RTO code</label>
                  <input type="text" class="form-control" value="{{ $user->email }}" name="email" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter RTO code">
                  <span style="color:red;">{{ $errors->first('name') }}</span>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="password" class="form-control" value="" name="password" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Password">
                  <span style="color:red;">{{ $errors->first('password') }}</span>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Confim Password</label>
                  <input type="password" class="form-control" value="" name="confirm_password" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Confirm Password">
                  <span style="color:red;">{{ $errors->first('confirm_password') }}</span>
                </div>
               
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
@endsection