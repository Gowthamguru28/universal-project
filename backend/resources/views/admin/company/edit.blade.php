@extends('layouts.master')
@section('content')
    <div class="container-fluid">
          <div class="row">
            <form class="company-creation-form" method="post" action="{{URL::route('company.update', $data->id)}}" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputEmail1">Company Name</label>
                  <input type="text" name="name" class="form-control" value="{{ $data->name }}" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Company Name">
                  <span style="color:red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group choose-image" >
                    <label for="exampleFormControlFile1">Choose Logo</label>
                    <input type="file" name="logo" class="form-control-file" id="exampleFormControlFile1"  accept="image/png, image/jpeg" onchange="$('#companyEdit').remove()">
                    <span style="color:red;">{{ $errors->first('logo') }}</span>
                    @if(!$errors->first('logo'))
                        <div id="companyEdit">
                            <input type="hidden" value="{{ $data->logo }}" name="uploadedName">
                            <img width="100px"  height="70px;" src="{{ URL::to('uploads') }}/{{ $data->logo }}"><i onclick="editDelete('companyEdit')" class="fas fa-trash-alt"></i>
                        </div>
                    @endif
                </div>
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
      
@endsection