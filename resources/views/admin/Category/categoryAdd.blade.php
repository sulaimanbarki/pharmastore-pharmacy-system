@extends('admin.master')

@section('title')
Category Add
@endsection


@section('sideMenuTitle')
Category Add
@endsection

@section('pageTitle')
<a href="{{url('category/list')}}"><i class="fa fa-dashboard"></i>Category List</a>
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
                @if (!isset($category))
                {!! Form::open(['url' => 'category/add', 'method' => 'post', 'name' => 'catForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
                @endif
                @if (isset($category))
                {!! Form::open(['url' => 'category/update', 'method' => 'post','name' => 'catForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
                <input type="hidden" class="form-control" name="catID" value="{{$category->id}}">
                @endif
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{isset($category) ? $category->name:old('name')}}" required>
                    </div>
                    <div class="form-group">
                        <label>Select Publis Status</label>
                        <select class="form-control" name="status" required>
                            @foreach ($publish as $pub)
                            <option value="{{ $pub->id }}" {{ (isset($category) ? ($category->status == $pub->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }}>{{ $pub->name }}</option>
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
</section>

@endsection