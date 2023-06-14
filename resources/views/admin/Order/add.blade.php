@extends('admin.master')

@section('title')
Order
@endsection 


@section('sideMenuTitle')
Order Medicine

@endsection

@section('pageTitle')

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
            {!! Form::open(['url' => 'order/', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data',  'role' => 'form']) !!}
            @endif
           
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Search by product name</label>
                  {{-- <input type="text" class="form-control" name="name" placeholder="Product Name" value=""> --}}
                  <select name="name" class="form-control select2">
                    <option value="">Select Products</option>
                    @foreach($all_products as $each_product)
                    <option value="{{$each_product->name}}">{{$each_product->name}}</option>
                    @endforeach
                  </select>
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



 
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cart">Cart (<span class="total-count"></span>)</button><button class="clear-cart btn btn-danger">Clear Cart</button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th> 
                  <th>Name</th>
                  <th>Image</th>
                  <th>Price({{$settings->currency_symbol}})</th>
                  <th>QTY</th>
                  <th>Discount</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  @foreach($products as $val)
                  <tr>
                   <td>{{ $i++ }}</td>  
                    <td>{{$val->name}}</td>
                    <td><img src="{{ asset($val->image) }}" width="80" height="80" alt="no image"></td>
                    <td>{{$val->sellingPrice}}</td>
                    <td><input type="number" name="qty" value="1" readonly=""></td>
                    @if(!empty($val->discount))
                    <td>{{$val->discount->type == "fixed" ? $settings->currency_symbol : ""}}{{$val->discount->amount}}{{$val->discount->type == "percentage" ? "%" : ""}}</td>
                    @endif
                    @if (empty($val->discount))
                    <td>0</td>
                    @endif
                    <td>
                       <a class="btn bg-green add-to-cart" href="#" data-name="{{$val->name}}" data-price="{{$val->sellingPrice}}" data-discount="{{(!empty($val->discount)) ? $val->discount : 0}}" data-id="{{$val->id}}" >
                          <i class="fa fa-plus"></i> Add To Cart
                       </a>

                        

                    </td>
                  </tr>
                @endforeach

                </tbody>
               
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
         
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>


      <!-- Modal -->
    <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="show-cart table">
              
            </table>
            <div>Total price: $<span class="total-cart"></span></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a class="btn btn-primary" id="link">Order now</a>
          </div>
        </div>
      </div>
    </div> 
</section>             
  
@endsection 