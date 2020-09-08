@extends('layouts.master')
@section('content')  
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Customer</h1>
      

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <!-- <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List</h6>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Owner name</th>
                      <th>Vehicle Number</th>
                      <th>Phone</th>
                      <th>Vehicle Modal</th>
                   
                        <th>Status</th>

                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $va=>$key)
                    <tr>
                      <td>{{ $key['owner_name'] }}</td>
                      <td>{{ $key['vehicle_no'] }}</td>
                      <td>{{ $key['phone'] }}</td>
                      <td>{{ $key['vehicle_model'] }}</td>
                       
                         <td>
                            @if($key['status'] == 0 )
                              Pending
                            @elseif($key['status'] == 1)
                              Accepted
                            @else
                              Rejected
                            @endif
                          </td>

                      @if(!Auth::user()->isRto())
                      <td>
                         @if($key['status'] == 0 )
                              <a href="{{ URL::route('customer.edit',$key['id']) }}"> <button type="button" class="btn btn-success" >Edit</button></a>
                                <form action="{{ URL::route('customer.destroy',$key['id'])}}" class="d-inline-block" method="post" id="company_delete_{{ $key['id'] }}">
                                <button type="button" class="btn btn-danger" onclick="companyDelete('company_delete_{{ $key['id'] }}')">Delete</button>
                                  @csrf()
                                  @method('DELETE')
                                </form> 
                          @else

                          <a href="{{ URL::route('customer.show',$key['id']) }}"> <button type="button" class="btn btn-success" >View</button></a>

                           @endif
                      </td>
                        @else
                          <td>
                          <a href="{{ URL::route('customer.show',$key['id']) }}"> <button type="button" class="btn btn-success" >View</button></a>
                        </td>
                        @endif
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
@endsection