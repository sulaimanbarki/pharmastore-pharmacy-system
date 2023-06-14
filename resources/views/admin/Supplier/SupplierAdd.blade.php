@extends('admin.master')

@section('title')
  Supplier Add
@endsection 


@section('sideMenuTitle')
  Supplier Add
@endsection

@section('pageTitle')
<a href="{{url('supplier/list')}}"><i class="fa fa-dashboard"></i>Supplier List</a>
@endsection



@section('bodyContent')

 <section class="content">
  @if(Session::has('message'))
  <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i>
                {{Session::get('message')}}</h4>
     </div>
     @endif

      @if(Session::has('error'))
      <div class="alert alert-danger alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i>
                    {{Session::get('error')}}</h4>
         </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      <div class="row">
        <!-- left column -->
        <div class="col-lg-12 centerDiv">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            @if (!isset($editData))
            {!! Form::open(['url' => 'supplier/add', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data',  'role' => 'form']) !!}
            @endif
            @if (isset($editData))
            {!! Form::open(['url' => 'supplier/update', 'method' => 'post','name' => 'form', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
            <input type="hidden" class="form-control" name="id" value="{{$editData->id}}">
            @endif
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Supplier Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Name" value="{{isset($editData) ? $editData->name:old('name')}}" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Supplier Phone Number</label>
                  <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="{{isset($editData) ? $editData->phone:old('phone')}}" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Supplier Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{isset($editData) ? $editData->email:old('email')}}" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Supplier Address</label>
                  <input type="text" class="form-control" name="address" placeholder="Address" value="{{isset($editData) ? $editData->address:old('address')}}" required>
                </div>


                <div class="form-group">
                  <label>Select Publis Status</label>
                  <select class="form-control" name="status">
                        @foreach ($publish as $pub)
                            <option value="{{ $pub->id }}" {{ (isset($editData) ? ($editData->status == $pub->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{ $pub->name }}</option>
                        @endforeach 
                  </select>
                </div>
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
      {!! Form::close() !!}
           
          </div>
          <!-- /.box -->

         
    </div> 
  </div>
</section>             
  
@endsection 