@extends('layouts.master')
@section('content')
<div class="container-fluid">
          <div class="row">
            <form class="company-creation-form">
                <div class="form-group">
                  <label for="exampleInputEmail1"> Name</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter your Name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile</label>
                  <input type="number" class="form-control" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Mobile number">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Address</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Company Name</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="Enter Company Name">
                 
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">RTO</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" aria-describedby="emailHelp" placeholder="" Readonly>
                 
                </div>
                <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Choose Logo</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1">
                  </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Dealer are Distributor</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                    <option>Dealer</option>
                    <option>Distributor</option>
                   
                    </select>
                </div>
            
                
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
@endsection