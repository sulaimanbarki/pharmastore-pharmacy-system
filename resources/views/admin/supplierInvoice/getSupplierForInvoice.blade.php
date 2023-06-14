@extends('admin.master')

@section('title')
  Supplier Invoice Create
@endsection 


@section('sideMenuTitle')
  Supplier Invoice
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
            {!! Form::open(['url' => 'supplier/invoice', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data',  'role' => 'form']) !!}
            @endif
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Choose Supplier Name For Invoice</label>
                   <select class="form-control" name="supplier" id="supplier">
                      @foreach ($suppliers as $supplier)
                         <option value="{{$supplier->id}}">{{$supplier->name}}</option>
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