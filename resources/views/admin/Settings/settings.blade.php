@extends('admin.master')

@section('title')
	Settings
@endsection	


@section('sideMenuTitle')
  Settings
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
            
            {!! Form::open(['url' => 'settings/update', 'method' => 'post','name' => 'medForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
            <input type="hidden" class="form-control" name="id" value="{{isset($info) ? $info->id: 0}}">

              <div class="box-body">
                 

                <div class="form-group">
                  <label for="exampleInputEmail1">Company Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Name" value="{{isset($info) ? $info->name:old('name')}}">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Company Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Email" value="{{isset($info) ? $info->email :old('email')}}">
                </div> 
                <div class="form-group">
                  <label for="exampleInputEmail1">Company Phone</label>
                  <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="{{isset($info) ? $info->phone :old('phone')}}">
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Company Webasite</label>
                  <input type="text" class="form-control" name="website" placeholder="Website" value="{{isset($info) ? $info->website :old('website')}}">
                </div>

               <div class="form-group">
                  <label for="exampleInputEmail1">Company Address</label>
                  <textarea class="form-control" rows="3" name="address" placeholder="Address">{{isset($info) ? $info->address:old('address')}}</textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Company Delivery Charge</label>
                  <input type="number" class="form-control" name="delivery_charge" placeholder="Delivery Charge" value="{{isset($info) ? $info->delivery_charge :''}}">
                </div> 
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Currency Name</label>
                  <input type="text" class="form-control" name="currency_name" placeholder="Currency Name" value="{{isset($info) ? $info->currency_name :''}}">
                </div> 
                
                 <div class="form-group">
                  <label for="exampleInputEmail1">Currency Symbol</label>
                  <input type="text" class="form-control" name="currency_symbol" placeholder="Delivery Symbol" value="{{isset($info) ? $info->currency_symbol :''}}">
                </div> 

                {{-- company logo --}}
                <div class="form-group">
                  <label for="exampleInputFile">Company Logo</label>
                  <input type="file" id="exampleInputFile" name="logo">
                  <p class="help-block">Upload Company Logo</p>
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
