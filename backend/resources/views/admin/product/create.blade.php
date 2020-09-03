@extends('layouts.master')
@section('content')
<div class="container-fluid">
          <div class="row">
            <form class="company-creation-form" action="{{ route('product.store') }}" method="post">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Company</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="company_id">
                    <option value="">Select Company</option>
                    @foreach($company as $va=>$key)
                    <option @if(old('company_id') == $key->id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                    @endforeach
                    </select>
                    <span style="color:red;">{{ $errors->first('company_id') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Product Name</label>
                  <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Product Name">
                  <span style="color:red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Unit</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="unit_id">
                    <option value="">Select Unit</option>
                    @foreach($unit as $va=>$key)
                        <option @if(old('unit_id') == $key->id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                    @endforeach
                    </select>
                    <span style="color:red;">{{ $errors->first('unit_id') }}</span>
                </div>
            
                @csrf
                @method('post')
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
@endsection