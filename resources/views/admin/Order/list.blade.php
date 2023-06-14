@extends('admin.master')

@section('title')
	Order List
@endsection	


@section('sideMenuTitle')
  Order
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
              <h3 class="box-title">Now showing {{ $orders->count() * $orders->currentPage() }} out of {{ $orders->total() }} Order</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>	
                  <th>Order No #</th>
                  <th>Payment Type</th>
                  <th>Payment Status</th>
                  <th>Grand Total({{ $settings ? $settings->currency_symbol ?? "Currency" : "Currency" }})</th>
                  <th>Update Order Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                	@foreach($orders as $val)
                  <?php 
                      $status = "";
                      if($val->status == 1){
                          $status = "Pending";
                      }else if($val->status == 2){
                          $status = "Delivered";
                      }if($val->status == 3){
                          $status = "Rejected";
                      }

                  ?>
	                <tr>
	                 <td>{{ $i++ }}</td>	
                    <td>{{$val->order_number}}</td>
                    <td>{{$val->payment->type ?? $val->payment_type }}</td>
                    <td>{{$status}}</td>
                    <td>{{$val->grandtotal}}</td>
                    <td>
                        <a class="btn btn-block btn-warning btn-sm" href="{{url('order/updateOrderStatus/'.$val->order_id.'/pending')}}">
                          <i class="fa fa-book"></i> Pending
                       </a>
                       <a class="btn btn-block btn-success btn-sm" href="{{url('order/updateOrderStatus/'.$val->order_id.'/delivered')}}">
                          <i class="fa fa-book"></i> Delivered
                       </a>
                       <a class="btn btn-block btn-danger btn-sm" href="{{url('order/updateOrderStatus/'.$val->order_id.'/reject')}}">
                          <i class="fa fa-book"></i> Reject
                       </a>
                    </td>
	                  <td>
                       <a class="btn btn-app" href="{{url('order/details/'.$val->order_id)}}">
                          <i class="fa fa-book"></i> Details
                       </a>

    			          </td>
	                </tr>
                @endforeach

                </tbody>
               
              </table>

              {{ $orders->links() }}
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