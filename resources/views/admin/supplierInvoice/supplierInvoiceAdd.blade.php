@extends('admin.master')

@section('title')
  Supplier Invoice Create
@endsection 


@section('sideMenuTitle')
  Supplier Invoice
@endsection

@section('pageTitle')
<a href="{{url('supplier/list')}}"><i class="fa fa-dashboard"></i> Go To Supplier Invoice List</a>
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
            {!! Form::open(['url' => 'supplier/invoiceCreate', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data',  'role' => 'form']) !!}
            @endif
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Supplier Name</label>
                   <select class="form-control" name="supplier" id="supplier">
                      @foreach ($suppliers as $supplier)
                         <option value="{{$supplier->id}}" {{ (isset($supplierId) ? ($supplierId == $supplier->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{$supplier->name}}</option>
                      @endforeach
                    </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Supplier Invoice Number</label>
                  <input type="text" class="form-control" name="phone" placeholder="Invoice Number" value="{{isset($invoice_number) ? $invoice_number:''}}">
                </div>

                 <div class="form-group">
                    <label>Invoice Date</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker" name="invoiceDate" data-date-format="yyyy-mm-dd">
                    </div>
                  <!-- /.input group -->
                </div>
               
              </div>
              <!-- /.box-body -->
              <div class="clearfix">
               <div class="col-md-12">
                  <table class="table table-bordered table-hover" id="tab_logic">
                    <thead>
                      <tr>
                        <th class="text-center"> # </th>
                        <th class="text-center"> Product </th>
                        <th class="text-center"> Qty </th>
                        <th class="text-center"> Price ({{$settings->currency_symbol}})</th>
                        <th class="text-center"> Discount </th>
                        <th class="text-center"> Total </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr id='addr0'>
                        <td>1</td>
                        <td><select class="form-control" name="product[]" id="product">
                            <option selected="">Enter Product Name</option>
                            @foreach ($medicines as $medicine)
                               <option value="{{$medicine->id}}">{{$medicine->name}}</option>
                            @endforeach
                          </select>
                        <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0"/></td>
                        <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/></td>

                        <td><input type="number" name='discount[]' placeholder='Enter Discount Price' class="form-control discount" placeholder='0.00'></td>

                        <td><input type="number" name='grandtotal[]' placeholder='0.00' class="form-control grandtotal" readonly/></td>
                        <td><input type="hidden" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
                      </tr>
                      <tr id='addr1'></tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="clearfix">
                <div class="col-md-12">
                  <button id="add_row" class="btn bg-green pull-left"> + Add More</button>
                  <button id="delete_row" class="btn bg-red pull-right"> <i class="fa fa-trash"></i> Delete</button>

                </div>
              </div>
              <div class="clearfix" style="margin-top:20px">
                <div class="pull-right col-md-6">
                  <table class="table table-bordered table-hover" id="tab_logic_total">
                    <tbody>
                      <tr>
                        <th class="text-center">Sub Total</th>
                        <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                      </tr>
                      <tr>
                        <th class="text-center">Discount</th>
                        <td class="text-center"><input type="number" name='discount_amount' placeholder='0.00' class="form-control" id="discount_amount" readonly/></td>
                      </tr>
                      <tr>
                        <th class="text-center">Tax</th>
                        <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                            <input type="number" class="form-control" id="tax" placeholder="0">
                            <div class="input-group-addon">%</div>
                          </div></td>
                      </tr>
                      <tr>
                        <th class="text-center">Tax Amount</th>
                        <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/></td>
                      </tr>
                      <tr>
                        <th class="text-center">Grand Total</th>
                        <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Generate Invoice</button>
              </div>
      {!! Form::close() !!}
          
          </div>
          <!-- /.box -->

         
    </div> 
  </div>
</section>             
  
@endsection 