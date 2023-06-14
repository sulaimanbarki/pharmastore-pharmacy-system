@extends('admin.master')

@section('title')
Medicines Group Add
@endsection


@section('sideMenuTitle')
Medicines Group Add
@endsection

@section('pageTitle')
<a href="{{url('groups/list')}}"><i class="fa fa-dashboard"></i>Group list</a>

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
                @if (!isset($group))
                {!! Form::open(['url' => 'groups/add', 'method' => 'post', 'name' => 'groupForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
                @endif
                @if (isset($group))
                {!! Form::open(['url' => 'groups/update', 'method' => 'post','name' => 'groupForm', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
                <input type="hidden" class="form-control" name="groupID" value="{{$group->id}}">
                @endif
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Group Name</label>
                        <input type="text" class="form-control" name="name" required placeholder="Name" value="{{isset($group) ? $group->name: old('name') }}">
                    </div>
                    
                    <div class="form-group">
                        <label>Select Publis Status</label>
                        <select class="form-control" name="status">
                             @foreach ($publish as $pub)
                            <option value="{{ $pub->id }}" {{ (isset($group) ? ($group->status == $pub->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{ $pub->name }}</option>
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