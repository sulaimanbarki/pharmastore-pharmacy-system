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
                  <th>Invoice #</th>	
                  <th>Company</th>
                  <th>Subtotal</th>
                  <th>Discount</th>
                  <th>Tax</th>
                  <th>Grandtotal</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                	<?php $i = 1; ?>
                	@foreach($listData as $val)
	                <tr>
                   <td>{{ $i++ }}</td>  
	                  <td>{{ $val->invoice_no}}</td>	
                    <td>{{$val->company_id}}</td>
                    <td>{{$val->sum_subtotal}}</td>
                    <td>{{$val->sum_discount}}</td>
                    <td>{{$val->tax_amount}}</td>
                    <td>{{$val->sum_grandtotal}}</td>
	                  <td>
                      <a class="btn btn-app" href="{{url('supplier/details/'.$val->invoice_no.'/'.$val->company_id)}}">
                        <i class="fa fa-book"></i> Details
                     </a>
                      <a class="btn btn-app bg-red" href="#" onclick="delete_item('{{url('supplier/deleteinvoice/'.$val->id)}}')">
                          <i class="fa fa-trash"></i> Delete
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