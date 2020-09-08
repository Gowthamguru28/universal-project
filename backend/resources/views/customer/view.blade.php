@extends('layouts.master')
@section('content')
<div class="container-fluid">
    <form method="post" action="{{ URL::to('/') }}/status/update" id="statusForm">
      <h5 class="text-center">View </h5> 
     
          <div class="row company-creation-form shadow">
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Date</h6>
                <p>{{ $data->date }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vehicle RegNo:</h6>
                <p>{{ $data->vehicle_no }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vehicle Manufacturing Year:</h6>
                <p>{{ $data->vehicle_year }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Classis No:</h6>
                <p>{{ $data->class_no }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Engine No:</h6>
                <p>{{ $data->engine_no }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vechicle Make:  </h6>
                <p>{{ $data->vehicle_make }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Vechicle Model:</h6>
                <p>{{ $data->vehicle_model }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Owner Name</h6>
                <p>{{ $data->owner_name }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Phone</h6>
                <p>{{ $data->phone }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>Address</h6>
                <p>{{ $data->address }}</p>
            </div>
            <div class="company-data-list d-flex justify-content-between w-100">
                <h6>RTO</h6>
                <p>{{ $data->rto->email }}</p>
            </div>

            <div class="border-bottom mb-3 w-100">
               <h6 class="text-center"> Reflective Tape details </h6>
            </div>

            @foreach($data->tapes as $va=>$key)
                <div class="company-data-list d-flex justify-content-between w-100">
                    <h6>{{ $key->product->name }}:</h6>
                    <p>{{ $key->qty }} {{ $key->product->unit->name }}</p>
                </div>  
            @endforeach
            <div class="border-bottom mb-5 w-100">
               <h6 class="text-center"> Images </h6>
            </div>

            <div class="row">
                <div class="col-lg-4  mb-3"> 
                <p class="text-center">Front Image</p>
                    <img src="{{ URL::to('uploads/customer') }}/{{ $data->images->front_image }}" class="w-50" alt="images" value=""/>
                </div>
                <div class="col-lg-4  mb-3"> 
                <p class="text-center">Left Image</p>
                    <img src="{{ URL::to('uploads/customer') }}/{{ $data->images->left_image }}" class="w-50" alt="images"/>
                </div>
                <div class="col-lg-4  mb-3"> 
                <p class="text-center">Right Image</p>
                    <img src="{{ URL::to('uploads/customer') }}/{{ $data->images->right_image }}" class="w-50" alt="images"/>
                </div>
                <div class="col-lg-4  mb-3"> 
                <p class="text-center">Back Image</p>
                    <img src="{{ URL::to('uploads/customer') }}/{{ $data->images->back_image }}" class="w-50" alt="images"/>
                </div>
            </div>
            <input type="hidden" value="" name="status" id="status">
            <input type="hidden" name="customer_id" value="{{ $data->id }}">
            <div class=" d-flex justify-content-center w-100">
                    @if($data->status == 0)
                        <button type="button" class="btn btn-success mr-2" onclick="statusChange(1)"> Accept </button>
                        <button type="button" class="btn btn-danger" onclick="statusChange(2)"> Reject </button>
                    @endif
                @csrf
                @method('POST')
            </div>

            
          </div>
      </div>
      <script>
      function statusChange(id) {
            $('#status').val(id);
            $('#statusForm').submit();
      }
      </script>
@endsection