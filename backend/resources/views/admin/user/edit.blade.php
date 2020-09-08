@extends('layouts.master')
@section('content')
<div class="container-fluid">
          <div class="row">
            <form class="company-creation-form" method="post" action="{{ URL::route('users.update', $data['id']) }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Role</label>
                    <select class="form-control" name="role" id="exampleFormControlSelect1">
                        <option value="">Select Role</option>
                        <option value="2" @if($data['role'] == 2) selected @endif>Distributor</option>
                        <option value="3" @if($data['role'] == 3) selected @endif >Dealer</option>
                    </select>
                    <span style="color:red;">{{ $errors->first('role') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" name="name" value="{{ $data['name'] }}" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter your Name">
                  <span style="color:red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile</label>
                  <input type="number" class="form-control" value="{{ $data['details']['mobile_no'] }}" name="mobile_no" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Mobile number">
                  <span style="color:red;">{{ $errors->first('mobile_no') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email</label>
                    <input type="email" class="form-control" value="{{  $data['email'] }}" name="email"  autocomplete="off" id="exampleFormControlInput1" placeholder="name@example.com">
                    <span style="color:red;">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control"  autocomplete="off" name="password" id="exampleInputPassword1" placeholder="Password">
                    <span style="color:red;">{{ $errors->first('password') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control"  autocomplete="off" name="confirm_password" id="exampleInputPassword1" placeholder="Confirm Password">
                    <span style="color:red;">{{ $errors->first('confirm_password') }}</span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Address</label>
                    <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3">{{ $data['details']['address'] }}</textarea>
                    <span style="color:red;">{{ $errors->first('address') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">RTO</label>
                  <select class="form-control" name="rto_id[]" id="rto_id" multiple>
                    @foreach($rto as $va=>$key)
                        <option value="{{ $key->id }}" @if(in_array($key->id, array_pluck($data->tnrto,'rto_id')))  selected @endif>{{ $key->email }}</option>
                    @endforeach
                   
                    </select>
                    <span style="color:red;">{{ $errors->first('rto_id') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Company Name</label>
                  <input type="text" class="form-control"  value="{{ $data['details']['company_name'] }}" name="company_name" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Company Name">
                  <span style="color:red;">{{ $errors->first('company_name') }}</span>
                </div>
                <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Choose Logo</label>
                    <input type="file" class="form-control-file"  name="company_logo" onchange="$('#companyEdit').remove()" id="exampleFormControlFile1">
                    <span style="color:red;">{{ $errors->first('company_logo') }}</span>
                    @if(!$errors->first('company_logo'))
                        <div id="companyEdit">
                            <input type="hidden" value="{{ $data['details']['company_logo'] }}" name="uploadedName">
                            <img width="100px"  height="70px;" src="{{ URL::to('uploads') }}/{{ $data['details']['company_logo'] }}"><i onclick="editDelete('companyEdit')" class="fas fa-trash-alt"></i>
                        </div>
                    @endif
                  </div> 
                         @csrf 
                         @method('PUT')
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>

      <script>
      $('#rto_id').multiselect({
        buttonWidth: '249px',
            buttonText: function(options, select) {
                if (options.length === 0) {
                    return 'Select';
                }
                 else {
                     var labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + '';
                 }
            }
    });
      </script>
@endsection