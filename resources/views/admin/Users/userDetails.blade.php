@extends('admin.master')

@section('title')
	User Profile
@endsection	


@section('sideMenuTitle')
  User Profile
@endsection

@section('pageTitle')
  <a href="{{url('users/list')}}"><i class="fa fa-dashboard"></i>User List</a>
@endsection



@section('bodyContent')

 <section class="content">
 
      <div class="row">
        <!-- left column -->
        <div class="col-lg-6 centerDiv">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
              <div class="box-body">
                @if (isset($editprofile))
                <div class="attachment-pushed box-header with-border">
                    <a class="btn btn-app bg-green" href="{{url('users/editProfile')}}">
                      <i class="fa fa-plus"></i> Edit Profile
                    </a>
                </div>
                @endif
               <div class="attachment-pushed box-header with-border">
                  <div class="attachment-text"><img class="img-responsive pad" src="{{asset($data->image)}}" alt="Photo"></div>
                </div> 


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Role</a></h4>
                  <div class="attachment-text">{{$role->name}}</div>
                </div>


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Full Name</a></h4>
                  <div class="attachment-text">{{$data->name}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>First Name</a></h4>
                  <div class="attachment-text">{{$data->firstname}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Last Name</a></h4>
                  <div class="attachment-text">{{$data->lastname}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Email</a></h4>
                  <div class="attachment-text">{{$data->email}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Phone Number</a></h4>
                  <div class="attachment-text">{{$data->phone}}</div>
                </div>

                 <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Date Of Birth</a></h4>
                  <div class="attachment-text">{{ date('j F, Y', strtotime($data->dob)) }}</div>
                </div>
                
                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Postcode</a></h4>
                  <div class="attachment-text">{{$data->postcode}}</div>
                </div>

                 <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Address</a></h4>
                  <div class="attachment-text">{{$data->address}}</div>
                </div>

                 <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>City</a></h4>
                  <div class="attachment-text">{{$data->city}}</div>
                </div>

                 <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Country</a></h4>
                  <div class="attachment-text">{{$data->country}}</div>
                </div>


               
                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Active Status</a></h4>
                  <div class="attachment-text">{{$data->status == "1" ? "Active" : "Inactive"}}</div>
                </div>

              </div>
              <!-- /.box-body -->

     
          </div>
          <!-- /.box -->

         
		</div> 
	</div>
</section>		         
	
@endsection	