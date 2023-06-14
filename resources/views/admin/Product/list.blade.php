@extends('admin.master')

@section('title')
	Medicine List
@endsection	


@section('sideMenuTitle')
  Medicine
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
                  <th>Purchase Price({{ $settings == NULL ? 'Currency Not Set' : $settings->currency_symbol ?? 'Currency Not Set' }})</th>
                  <th>Selling Price({{ $settings == NULL ? 'Currency Not Set' : $settings->currency_symbol ?? 'Currency Not Set' }})</th>
                  <th>Total Item</th>
                  <th>Expire Date</th>
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
                    <td>{{$val->expireDate}}</td>
	                  <td>{{$val->status == 1 ? "Published" : "Unpublished"}}</td>
	                  <td>
	                  	 
                   <a class="btn btn-app" href="{{url('product/details/'.$val->id)}}">
                      <i class="fa fa-book"></i> Details
                   </a>

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