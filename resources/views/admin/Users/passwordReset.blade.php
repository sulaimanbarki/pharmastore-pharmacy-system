@extends('admin.master')

@section('title')
	Reset Password
@endsection	


@section('sideMenuTitle')
  Reset Password
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
           
            {!! Form::open(['url' => 'users/resetpassword', 'method' => 'post','name' => 'form', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
              <div class="box-body">
              	
               <div class="form-group">
                  <label for="exampleInputEmail1">New Password *</label>
                  <input type="password" class="form-control" name="newpassword" placeholder="New Password" value="">
                </div> 

                <div class="form-group">
                  <label for="exampleInputEmail1">Confirm New Password *</label>
                  <input type="password" class="form-control" name="password" placeholder="Confirm New Password" value="">
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