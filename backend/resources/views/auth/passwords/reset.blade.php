@extends('layouts.master')
@section('content')
<div class="container-fluid">
          <div class="row">
            <form class="company-creation-form" action="{{ URL::to('/') }}/update-password" method="post">
               
                <div class="form-group">
                  <label for="exampleInputEmail1">Old Password</label>
                  <input type="password" class="form-control"  name="current_password" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Old Password">
                  <span style="color:red;">{{ $errors->first('current_password') }}</span>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="password" class="form-control"  name="new_password" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Password">
                  <span style="color:red;">{{ $errors->first('new_password') }}</span>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Confim Password</label>
                  <input type="password" class="form-control" name="confirm_password" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Confirm Password">
                  <span style="color:red;">{{ $errors->first('confirm_password') }}</span>
                </div>
               
                @csrf
                @method('post')
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
@endsection