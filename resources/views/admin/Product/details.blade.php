@extends('admin.master')

@section('title')
	Medicines Details
@endsection	


@section('sideMenuTitle')
  Medicines Details
@endsection

@section('pageTitle')
  <a href="{{url('product/list')}}"><i class="fa fa-dashboard"></i>Medicine List</a>
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

               <div class="attachment-pushed box-header with-border">
                  <div class="attachment-text"><img class="img-responsive pad" src="{{asset($medicine->image)}}" alt="Photo"></div>
                </div> 

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Category</a></h4>
                  <div class="attachment-text">{{isset($medicine->category->name) ? $medicine->category->name : ''}}</div>
                </div>


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Group Name</a></h4>
                  <div class="attachment-text">{{isset($medicine->group->name) ? $medicine->group->name : ''}}</div>
                </div>


                 <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Medicine Name</a></h4>
                  <div class="attachment-text">{{$medicine->name}}</div>
                </div>


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Purchase Price({{ $settings->currency_symbol ?? "Currency Not Set" }})</a></h4>
                  <div class="attachment-text">${{$medicine->purchasePrice}}</div>
                </div>


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Selling Price({{ $settings->currency_symbol ?? "Currency Not Set" }})</a></h4>
                  <div class="attachment-text">${{$medicine->sellingPrice}}</div>
                </div>


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Number of Store Box of Medicine</a></h4>
                  <div class="attachment-text">{{$medicine->storeBox}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Items Each Box</a></h4>
                  <div class="attachment-text">{{$medicine->itemsNumber}}</div>
                </div>


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Generic Name</a></h4>
                  <div class="attachment-text">{{isset($medicine->generic->name) ? $medicine->generic->name : ''}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Company Name</a></h4>
                  <div class="attachment-text">{{isset($medicine->supplier->name) ? $medicine->supplier->name : ''}}</div>
                </div>


                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Medicine Description</a></h4>
                  <div class="attachment-text">{{$medicine->description}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Medicine Expire Date</a></h4>
                  <div class="attachment-text">{{$medicine->expireDate}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Publish Status</a></h4>
                  <div class="attachment-text">{{$medicine->status == 1 ? "Published" : "Unpublish"}}</div>
                </div>

                <div class="attachment-pushed box-header with-border">
                  <h4 class="attachment-heading"><a>Total Purchased Item</a></h4>
                  <div class="attachment-text">{{$medicine->totalPurchedItem}}</div>
                </div>


              </div>
              <!-- /.box-body -->

     
          </div>
          <!-- /.box -->

         
		</div> 
	</div>
</section>		         
	
@endsection	