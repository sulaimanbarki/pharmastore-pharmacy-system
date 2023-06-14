@extends('admin.master')

@section('title')
	Medicine Group List
@endsection	


@section('sideMenuTitle')
  Medicine Group List
@endsection

@section('pageTitle')
<a href="{{url('groups/add')}}"><i class="fa fa-dashboard"></i>Group Add</a>
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
              <h3 class="box-title">Now showing {{ $groups->count() * $groups->currentPage() }} out of {{ $groups->total() }} Groups</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>	
                  <th>Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                	@foreach($groups as $val)
	                <tr>
	                 <td>{{ $i++ }}</td>	
                    <td>{{$val->name}}</td>
	                  <td>{{$val->status == 1 ? "Published" : "Unpublished"}}</td>
	                  <td>
	                  	 <a class="btn btn-app  bg-blue" href="{{url('groups/edit/'.$val->id)}}">
			                <i class="fa fa-edit"></i> Edit
			             </a>
                   @if (Auth::user()->user_role->slug == "superadmin" || Auth::user()->user_role->slug == "admin")
			             <a class="btn btn-app bg-red" href="#" onclick="delete_item('{{url('groups/delete/'.$val->id)}}')">
			                <i class="fa fa-trash"></i> Delete
			             </a>
                   @endif
			             @if ($val->status == 2)
			             <a class="btn btn-app bg-green" href="{{url('groups/publishStatus/publish/'.$val->id)}}">
			                <i class="fa fa-file-o"></i>Publish?
			             </a>
			             @endif

			             @if ($val->status == 1)
			             <a class="btn btn-app bg-yellow" href="{{url('groups/publishStatus/unpublish/'.$val->id)}}">
			                <i class="fa fa-file-archive-o"></i> Unpublish?
			             </a>
			             @endif


			          </td>
	                </tr>
                @endforeach

                </tbody>
               
              </table>

              {{ $groups->links() }}
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