@extends('layouts.master')
@section('content')
    <div class="container-fluid">
          <div class="row">
            <form class="company-creation-form" method="post" action="{{URL::route('company.store')}}" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputEmail1">Company Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Company Name">
                  <span style="color:red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Choose Logo</label>
                    <input type="file" name="logo" class="form-control-file" id="exampleFormControlFile1"  accept="image/png, image/jpeg">
                    <span style="color:red;">{{ $errors->first('logo') }}</span>
                  </div>
                  @csrf
                  @method('post')
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
      
@endsection