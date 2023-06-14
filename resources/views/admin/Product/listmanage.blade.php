@extends('admin.master')

@section('title')
	Medicine List
@endsection	


@section('sideMenuTitle')
  Medicine List
@endsection

@section('pageTitle')
<a href="{{url('product/add')}}"><i class="fa fa-dashboard"></i>Medicine Add</a>
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
              <h3 class="box-title">Now showing {{ $listData->count() * $listData->currentPage() }} out of {{ $listData->total() }} Medicines</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>	
                  <th>Name</th>
                  <th>Image</th>
                  <th>Generic Name</th>
                  <th>Purchase Price({{($settings) ? $settings->currency_symbol : 0}})</th>
                  <th>Selling Price({{($settings) ? $settings->currency_symbol : 0}})</th>
                  <th>Total Item</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                	@foreach($listData as $val)
	                <tr>
	                 <td>{{ $i++ }}</td>	
                    <td>{{$val->name}}</td>
                    <td><img src="{{ asset($val->image) }}" width="50" height="50" alt="no image"></td>
                    <td>{{isset($val->generic->name) ? $val->generic->name : ''}}</td>
                    <td>{{$val->purchasePrice}}</td>
                    <td>{{$val->sellingPrice}}</td>
                    <td>{{$val->totalPurchedItem}}</td>
	                  <td>{{$val->status == 1 ? "Published" : "Unpublished"}}</td>
	                  <td>
	                  	 <a class="btn btn-app  bg-blue" href="{{url('product/edit/'.$val->id)}}">
    			                <i class="fa fa-edit"></i> Edit
    			             </a>

                        <a class="btn btn-app  bg-blue" href="{{url('product/restock/'.$val->id)}}">
                          <i class="fa fa-plus"></i> Restock
                       </a>

    			             <a class="btn btn-app bg-red" href="#" onclick="delete_item('{{url('product/delete/'.$val->id)}}');">
    			                <i class="fa fa-trash"></i> Delete
    			             </a>

                       <a class="btn btn-app" href="{{url('product/details/'.$val->id)}}">
                          <i class="fa fa-book"></i> Details
                       </a>

    			             @if ($val->status == 2)
    			             <a class="btn btn-app bg-green" href="{{url('product/publishStatus/publish/'.$val->id)}}">
    			                <i class="fa fa-file-o"></i>Publish?
    			             </a>
    			             @endif

    			             @if ($val->status == 1)
    			             <a class="btn btn-app bg-yellow" href="{{url('product/publishStatus/unpublish/'.$val->id)}}">
    			                <i class="fa fa-file-archive-o"></i> Unpublish?
    			             </a>
			             @endif


			          </td>
	                </tr>
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