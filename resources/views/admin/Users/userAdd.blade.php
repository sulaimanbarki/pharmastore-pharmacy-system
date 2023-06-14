@extends('admin.master')

@section('title')
	User {{(!isset($editData)?'Add':'Update') }}
@endsection	


@section('sideMenuTitle')
  User {{(!isset($editData)?'Add':'Update') }}
@endsection


@section('pageTitle')
  <a href="{{url('users/list')}}"><i class="fa fa-dashboard"></i>User List</a>
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
            {!! Form::open(['url' => 'users/add', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data',  'role' => 'form']) !!}
            @endif
            @if (isset($editData))
            {!! Form::open(['url' => 'users/update', 'method' => 'post','name' => 'form', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
            <input type="hidden" class="form-control" name="id" value="{{$editData->id}}">
            @endif
              <div class="box-body">
                @if (!isset($editData) || Auth::user()->user_role->id == 1)
              	 <div class="form-group">
                  <label>Select Role Type *</label>
                    <select class="form-control" name="role" required>
                         @foreach ($roles as $role)
                           <option value="{{$role->id}}"  {{ (isset($editData) ? ($editData->users_role_id == $role->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }}  >{{$role->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  @if (Auth::user()->user_role->slug == "superadmin")
                   <div class="checkbox">
                    <label>
                      <input type="checkbox" name="isAdmin" value="1" <?php isset($editData) ? ($editData->isAdmin == 1 ? "Checked" : ""):"Checked" ?> > isAdmin
                    </label>
                  </div>
                  @endif
                  @endif

                <div class="form-group">
                  <label for="exampleInputEmail1">First Name *</label>
                  <input type="text" class="form-control" name="firstname" placeholder="First Name" value="{{isset($editData) ? $editData->firstname:old('firstname')}}" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Last Name *</label>
                  <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="{{isset($editData) ? $editData->lastname:old('lastname')}}" required>
                </div>
                 @if (!isset($editData))
                 <div class="form-group">
                  <label for="exampleInputEmail1">User Email *</label>
                  <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') ?? '' }}" required>
                </div> 

                 <div class="form-group">
                  <label for="exampleInputEmail1">User Password *</label>
                  <input type="password" class="form-control" name="password" placeholder="Password" value="">
                </div> 
                @endif
                <div class="form-group">
                  <label for="exampleInputEmail1">User Phone *</label>
                  <input type="phone" class="form-control" name="phone" placeholder="Phone" value="{{isset($editData) ? $editData->phone : old('phone')}}" required>
                </div> 
                
                <div class="form-group">
                <label>User Date Of Birth</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="dob" data-date-format="yyyy-mm-dd" value="{{isset($editData) ? $editData->dob : old('dob')}}">
                </div>
                <!-- /.input group -->
              </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">User Address</label>
                  <textarea class="form-control" rows="3" name="address" placeholder="Address">{{isset($editData) ? $editData->address: old('address')}}</textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Postcode</label>
                  <input type="text" class="form-control" name="postcode" placeholder="Postcode" value="{{isset($editData) ? $editData->postcode: old('postcode')}}">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">City</label>
                  <input type="text" class="form-control" name="city" placeholder="City" value="{{isset($editData) ? $editData->city:old('city')}}">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Country</label>
                  <input type="text" class="form-control" name="country" placeholder="Country" value="{{isset($editData) ? $editData->country:old('country')}}">
                </div>

               @if (!isset($editData) || Auth::user()->user_role->id == 1)
                <div class="form-group">
                  <label>Select Active Status *</label>
                  <select class="form-control" name="status">
                    @foreach ($publish as $pub)
                          <option value="{{ $pub->id }}" {{ (isset($editData) ? ($editData->status == $pub->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{ $pub->name }}</option>
                      @endforeach 
                  </select>
                </div>
                @endif
                <div class="form-group">
                  <label for="exampleInputFile">User Image (Optional)</label>
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