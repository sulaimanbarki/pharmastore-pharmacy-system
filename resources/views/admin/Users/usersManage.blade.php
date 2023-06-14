@extends('admin.master')

@section('title')
	Users List
@endsection	


@section('sideMenuTitle')
  Users
@endsection

@section('pageTitle')
<a href="{{url('users/add')}}"><i class="fa fa-dashboard"></i>User Add</a>
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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Now showing {{ $listData->count() * $listData->currentPage() }} out of {{ $listData->total() }} User</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>	
                  <th>Role</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                	@foreach($listData as $val)
                  @if($val->id != Auth::user()->id)

	                <tr>
	                 <td>{{ $i++ }}</td>	
                    <td>{{$val->roleName}}</td>
                    <td>{{$val->firstname . " " . $val->lastname}}</td>
                    <td>{{$val->phone}}</td>
	                  <td>{{$val->status == 1 ? "Active" : "Inactive"}}</td>
	                  <td>
                      @if (Auth::user()->user_role->slug == "superadmin" || Auth::user()->user_role->slug == "admin")    
                        <a class="btn btn-app  bg-blue" href="{{url('users/edit/'.$val->id)}}">
                              <i class="fa fa-edit"></i> Edit
                           </a>

                          
                             @if ($val->status == 2)
                             <a class="btn btn-app bg-green" href="{{url('users/activeStatus/publish/'.$val->id)}}">
                                <i class="fa fa-file-o"></i>Active?
                             </a>
                             @endif

                             @if ($val->status == 1)
                             <a class="btn btn-app bg-yellow" href="{{url('users/activeStatus/unpublish/'.$val->id)}}">
                                <i class="fa fa-file-archive-o"></i> Inactive?
                             </a>
                             @endif
                        @endif   

                        @if (Auth::user()->user_role->slug == "superadmin")
                        
                           <a class="btn btn-app bg-red" href="#" onclick="delete_item('{{url('users/delete/'.$val->id)}}');">
                              <i class="fa fa-trash"></i> Delete
                           </a>

                         @endif
                       

                       <a class="btn btn-app" href="{{url('users/details/'.$val->id)}}">
                          <i class="fa fa-book"></i> Details
                       </a>
			              </td>
	                </tr>

                  @endif
                @endforeach

                </tbody>
               
              </table>

              {{ $listData->links() }}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
         
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

</section>		         
	
@endsection			