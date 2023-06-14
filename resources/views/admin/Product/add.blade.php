@extends('admin.master')

@section('title')
Medicines @if(isset($medicine)) Edit @else Add @endif
@endsection


@section('sideMenuTitle')
Medicines @if(isset($medicine)) Edit @else Add @endif
@endsection

@section('pageTitle')
<a href="{{url('product/list')}}"><i class="fa fa-dashboard"></i>Medicine List</a>
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
        <a class="btn btn-app bg-blue" href="{{url('category/add')}}">
          <i class="fa fa-plus"></i> Add Category
        </a>

        <a class="btn btn-app bg-blue" href="{{url('groups/add')}}">
          <i class="fa fa-plus"></i> Add Medicine Groups
        </a>

        <a class="btn btn-app bg-blue" href="{{url('genericnames/add')}}">
          <i class="fa fa-plus"></i> Add Generic Names
        </a>

        <a class="btn btn-app bg-blue" href="{{url('supplier/add')}}">
          <i class="fa fa-plus"></i> Add Supplier
        </a>
        <!-- /.box-header -->
        <!-- form start -->
        @if (!isset($medicine))
        {!! Form::open(['url' => 'product/add', 'method' => 'post', 'name' => 'medForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
        @endif
        @if (isset($medicine))
        {!! Form::open(['url' => 'product/update', 'method' => 'post','name' => 'medForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
        <input type="hidden" class="form-control" name="id" value="{{$medicine->id}}">
        <input type="hidden" class="form-control" name="type" value="edit">

        @endif

        <div class="box-body">
          <p>Please add category, group, generic name, company name before adding medicine.</p>

          <div class="form-group">
            <label>Select Category *</label>
            <select class="form-control select2 category" name="category">
              <option value="" selected>Select Category</option>
              @foreach ($categories as $category)
                <option value="{{$category->id}}" {{ (isset($medicine) ? ($medicine->category_id == $category->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }}>{{$category->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Select Medicine Group *</label>
            <select class="form-control medicine_group" name="groupName" required>
              @foreach ($groups as $group)
                <option value="{{$group->id}}" {{ (isset($medicine) ? ($medicine->group_id == $group->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{$group->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Medicine Name *</label>
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{isset($medicine) ? $medicine->name:old('name')}}" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Purchase Price({{($settings) ? $settings->currency_symbol : 0}}) Per Piece *</label>
            <input type="text" class="form-control" name="purchasePrice" placeholder="Purchase Price" value="{{isset($medicine) ? $medicine->purchasePrice :old('purchasePrice')}}" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Selling Price({{($settings) ? $settings->currency_symbol : 0}}) Per Piece *</label>
            <input type="text" class="form-control" name="sellingPrice" placeholder="Selling Price" value="{{isset($medicine) ? $medicine->sellingPrice :old('sellingPrice')}}" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Number of Boxes In Stock *</label>
            <input type="number" class="form-control" name="storeBox" placeholder="Store Box" value="{{isset($medicine) ? $medicine->storeBox :old('storeBox')}}" <?php echo isset($medicine) ? 'readonly' : '' ?> required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Items Each Box *</label>
            <input type="number" class="form-control" name="itemsNumber" placeholder="Items Each Box" value="{{isset($medicine) ? $medicine->itemsNumber :old('itemsNumber')}}" <?php echo isset($medicine) ? 'readonly' : '' ?> required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Generic Name *</label>
            <select class="form-control" name="genericName" required>
              @if (!empty($genericNames))
              @foreach ($genericNames as $name)
              <option value="{{$name->id}}"  {{ (isset($medicine) ? ($medicine->generic_id == $name->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }}  >{{$name->name}}</option>
              @endforeach
              @endif

            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Supplier/ Company Name *</label>
            <select class="form-control" name="companyName" required>
              @if (!empty($companyNames))
                @foreach ($companyNames as $name)
                  <option value="{{$name->id}}" {{ (isset($medicine) ? ($medicine->supplier_id == $name->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{$name->name}}</option>
                @endforeach
              @endif
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Medicine Description (Optional)</label>
            <textarea class="form-control" rows="3" name="description" placeholder="Description">{{isset($medicine) ? $medicine->description:old('description')}}</textarea>
          </div>

          <div class="form-group">
            <label>Medicine Expire Date *</label>

            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker" name="expireDate" data-date-format="yyyy-mm-dd" value="{{isset($medicine) ? $medicine->expireDate :old('expiredDate')}}" required>
            </div>
            <!-- /.input group -->
          </div>

          <div class="form-group">
            <label>Select Publish Status *</label>
            <select class="form-control" name="status" required>
                @foreach ($publish as $pub)
                    <option value="{{ $pub->id }}" {{ (isset($medicine) ? ($medicine->status == $pub->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{ $pub->name }}</option>
                @endforeach 
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">File input *</label>
            <input type="file" id="exampleInputFile" name="image" @if(!isset($medicine)) required @endif>

            <p class="help-block"></p>
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
</section>

@endsection