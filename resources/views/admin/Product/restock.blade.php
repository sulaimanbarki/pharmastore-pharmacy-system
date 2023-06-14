@extends('admin.master')

@section('title')
	Medicines Restock
@endsection	


@section('sideMenuTitle')
  Medicines Restock
@endsection

@section('pageTitle')
  <a href="{{url('product/list')}}"><i class="fa fa-dashboard"></i>Medicine List</a>
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
        <div class="col-lg-6 centerDiv">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <a class="btn btn-app bg-blue" href="{{url('category/add')}}">
              <i class="fa fa-plus"></i> Add Category
            </a>

            <a class="btn btn-app bg-blue" href="{{url('groups/add')}}">
              <i class="fa fa-plus"></i> Add Medicine Groups
            </a>

            <a class="btn btn-app bg-blue" href="{{url('genericnames/add')}}">
              <i class="fa fa-plus"></i> Add Generic Names
            </a>

            <a class="btn btn-app bg-blue" href="{{url('companynames/add')}}">
              <i class="fa fa-plus"></i> Add Company Names
            </a>
            <!-- /.box-header -->
            <!-- form start -->
           
            @if (isset($medicine))
            {!! Form::open(['url' => 'product/updateStock', 'method' => 'post','name' => 'medForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
            <input type="hidden" class="form-control" name="id" value="{{$medicine->id}}">
            <input type="hidden" class="form-control" name="type" value="restock">
            @endif
              <div class="box-body">


                <div class="form-group">
                  <label for="exampleInputEmail1">Medicine Name *</label>
                  <input type="text" class="form-control" name="name" placeholder="Name" value="{{isset($medicine) ? $medicine->name:''}}" readonly="">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Purchase Price({{ $settings == NULL ? 'Currency Not Set' : $settings->currency_symbol ?? 'Currency Not Set' }}) Per Piece *</label>
                  <input type="text" readonly class="form-control" name="purchasePrice" placeholder="Purchase Price" value="{{isset($medicine) ? $medicine->purchasePrice :''}}">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Selling Price({{ $settings == NULL ? 'Currency Not Set' : $settings->currency_symbol ?? 'Currency Not Set' }}) Per Piece *</label>
                  <input type="text" readonly class="form-control" name="sellingPrice" placeholder="Selling Price" value="{{isset($medicine) ? $medicine->sellingPrice :''}}">
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Number of Store Box of Medicine *</label>
                  <input type="number" class="form-control" name="storeBox" placeholder="Store Box" value="{{ old('storeBox') }}">
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Items Each Box *</label>
                    <input type="number" class="form-control" name="itemsNumber" placeholder="Items Each Box" value="{{ old('itemsNumber') }}">
                </div>


                

                <div class="form-group">
                <label>Medicine Expire Date</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right datepicker" id="datepicker" name="expireDate" data-date-format="yyyy-mm-dd" value="">
                </div>
                <!-- /.input group -->
              </div>

                <div class="form-group">
                  <label for="exampleInputFile">File input (Optional)</label>
                  <input type="file" id="exampleInputFile" name="image">

                  <p class="help-block"></p>
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