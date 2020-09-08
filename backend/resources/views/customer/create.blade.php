@extends('layouts.master')
@section('content')
<div class="container-fluid">
      <h5 class="text-center">New Entry </h5> 
      <div class="stock">
            <p>Available Stock </p>
            <ul>
            @foreach($data as $va=>$key)
                <li>{{ $key->product->name }} <span class="my-2">:</span><span>{{ $key->avilable_qty }} @if($key->product->unit->name != 'Number') {{ $key->product->unit->name }} @endif</span> </li>
            @endforeach
            <!-- <li>Red 20mm <span class="my-2">:</span><span>0.00 Mtrs</span> </li>
            <li>Red 20mm <span class="my-2">:</span><span>0.00 Mtrs</span> </li>
            <li>Red 20mm <span class="my-2">:</span><span>0.00 Mtrs</span> </li>
            <li>Red 20mm <span class="my-2">:</span><span>0.00 Mtrs</span> </li>
            <li>Red 20mm <span class="my-2">:</span><span>0.00 Mtrs</span> </li>
            <li>Red 20mm <span class="my-2">:</span><span>0.00 Mtrs</span> </li> -->
      </div>
          <div class="row">
         
            <form class="company-creation-form" action="{{ URL::route('customer.store') }}" method="post" enctype="multipart/form-data">
            <div class="form-group">
                  <label for="exampleInputEmail1">Date</label>
                  <input type="text" class="form-control datepick" id="exampleCompanyName1" autocomplete="off" name="date" aria-describedby="emailHelp">
                  <span style="color:red">{{ $errors->first('date') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Vehicle RegNo:</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" name="vehicle_no" aria-describedby="emailHelp" placeholder="Enter Vehicle Number">
                  <span style="color:red">{{ $errors->first('vehicle_no') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"> Vehicle Manufacturing Year:</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" name="vehicle_year" aria-describedby="emailHelp" placeholder="">
                  <span style="color:red">{{ $errors->first('vehicle_year') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Classis No:</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" name="class_no" aria-describedby="emailHelp" placeholder="Enter Vehicle Number">
                  <span style="color:red">{{ $errors->first('class_no') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"> Engine No:</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" name="engine_no" aria-describedby="emailHelp" placeholder="Enter Vehicle Number">
                  <span style="color:red">{{ $errors->first('engine_no') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"> Vechicle Make:</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" name="vehicle_make" aria-describedby="emailHelp" placeholder="Enter Vehicle Number">
                  <span style="color:red">{{ $errors->first('vehicle_make') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Vechicle Model:</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" name="vehicle_model" aria-describedby="emailHelp" placeholder="Enter Vehicle Number">
                  <span style="color:red">{{ $errors->first('vehicle_model') }} </span>
                </div>
              
                <div class="form-group">
                  <label for="exampleInputEmail1"> Owner Name</label>
                  <input type="text" class="form-control" id="exampleCompanyName1" name="owner_name" aria-describedby="emailHelp" placeholder="Enter Name">
                  <span style="color:red">{{ $errors->first('owner_name') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Phone</label>
                  <input type="number" class="form-control" id="exampleCompanyName1" name="phone" aria-describedby="emailHelp" placeholder="Enter Mobile number">
                  <span style="color:red">{{ $errors->first('phone') }} </span>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Address</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address"></textarea>
                  <span style="color:red">{{ $errors->first('address') }} </span>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">RTO</label>
                    <input type="text" class="form-control"  value="{{ $rto->rto->email }}" id="exampleFormControlInput1" placeholder="" readonly>
                    <input type="hidden" class="form-control" name="rto_id" value="{{ $rto->rto->id }}" id="exampleFormControlInput1" placeholder="" readonly>
                </div>
                
            <div class="border-bottom mb-3">
               <h6 class="text-center"> Reflective Tape details </h6>
            </div>
            @foreach($data as $va=>$key)
                <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">{{ $key->product->name }}:</label>
                <div class="col-sm-8 parentclass">
                    <input type="text" class="form-control" id="" placeholder="" autocomplete="off" name="quantity[]" onkeyup="qtyCheck(this, 0 , {{ $key->avilable_qty }})">
                    <input type="hidden" class="form-control" name="product[]" value="{{ $key->product->id }}" placeholder="" value="{{ $key->avilable_qty }}">
                    <span style="color:green" >Avilable count: <span class="availability">{{ $key->avilable_qty }}</span></span>
                </div>
                </div>
            @endforeach
          
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Class 3:</label>
              <div class="col-sm-8">
                <input type="" class="form-control" id="" placeholder="" name="class_3">
                <span style="color:red">{{ $errors->first('class_3') }} </span>
              </div>
            </div>
            <div class="form-group row">
              <label for="" class="col-sm-4 col-form-label">Class 4:</label>
              <div class="col-sm-8">
                <input type="" class="form-control" id="" placeholder="" name="class_4">
                <span style="color:red">{{ $errors->first('class_4') }} </span>
              </div>
            </div>
            <div class="border-bottom mb-3">
               <h6 class="text-center"> Images</h6>
            </div>
            <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Front Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="front_image">
                    <span style="color:red">{{ $errors->first('front_image') }} </span> 
            </div>
            <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Left Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="left_image">
                    <span style="color:red">{{ $errors->first('left_image') }} </span>
            </div>
            <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Right  Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="right_image">
                    <span style="color:red">{{ $errors->first('right_image') }} </span>
            </div>
            <div class="form-group choose-image">
                    <label for="exampleFormControlFile1">Back Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="back_image">
                    <span style="color:red">{{ $errors->first('back_image') }} </span>
            </div>    
            <div class="text-center">
            <button type="submit" class="btn btn-primary w-50">Save</button>
            </div>
            @csrf
            @method('POST')
              
              </form>
          </div>
      </div>
      <script>

function qtyCheck(obj, enteredQty, avilableQty) {
          var val = $(obj).val();
          if(val > enteredQty + avilableQty) {
              swal('Alert', 'Quantity Exceeds');
              $(obj).val(enteredQty);
              $(obj).parents('div.parentclass').find('.availability').html(avilableQty); 
          } else {
            var minus = val - enteredQty;
            $(obj).parents('div.parentclass').find('.availability').html(avilableQty-minus); 
          }
      }


      $('.datepick').datepicker({
	language: 'en',
    dateFormat: "yyyy-mm-dd"
	})
      </script>
@endsection