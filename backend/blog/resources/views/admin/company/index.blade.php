@extends('layouts.master')
@section('content')  
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Company</h1>
      

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
                      <th>Name</th>
                      <th>Logo</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $va=>$key)
                    <tr>
                      <td>{{ $key['name'] }}</td>
                      <td><img width="100px" height="70px;" src="{{ URL::to('uploads') }}/{{ $key['logo']}}"></td>
                      <td>
                          <a href="{{ URL::route('company.edit',$key['id']) }}"><i class='fas fa-edit' style='font-size:24px;color:green'></i></a>
                          <form action="{{ URL::route('company.destroy',$key['id'])}}" method="post" id="company_delete_{{ $key['id'] }}">
                            <a onclick="companyDelete('company_delete_{{ $key['id'] }}')"><i class="fas fa-trash-alt" style='font-size:24px;color:red'></i></a>
                            @csrf()
                            @method('DELETE')
                          </form> 
                      </td>
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