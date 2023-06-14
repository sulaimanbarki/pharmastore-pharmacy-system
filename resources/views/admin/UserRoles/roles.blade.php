@extends('admin.master')

@section('title')
  Users Role Add
@endsection 


@section('sideMenuTitle')
  Users Role Add
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
            {!! Form::open(['url' => 'useroles/add', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data',  'role' => 'form']) !!}
            @endif
            @if (isset($editData))
            {!! Form::open(['url' => 'useroles/update', 'method' => 'post','name' => 'form', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
            <input type="hidden" class="form-control" name="id" value="{{$editData->id}}">
            @endif
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Users Role Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Name" value="{{isset($editData) ? $editData->name: old('name')}}" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Slug</label>
                  <input type="text" class="form-control" name="slug" placeholder="Slug" value="{{isset($editData) ? $editData->slug: old('slug')}}" required>
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
              <h3 class="box-title">Now showing {{ $listData->count() * $listData->currentPage() }} out of {{ $listData->total() }} User-roles</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th> 
                  <th>Name</th>
                  <th>Slug</th>
                  @if (Auth::user()->user_role->slug == "superadmin")
                  <th>Action</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  @foreach($listData as $val)
                  <tr>
                   <td>{{ $i++ }}</td>  
                    <td>{{$val->name}}</td>
                    <td>{{$val->slug}}</td>
                    <td>
                       @if (Auth::user()->user_role->slug == "superadmin")

                           <a class="btn btn-app  bg-blue" href="{{url('useroles/edit/'.$val->id)}}">
                          <i class="fa fa-edit"></i> Edit
                       </a>

                       <a class="btn btn-app bg-red" href="#" onclick="delete_item('{{url('useroles/delete/'.$val->id)}}');">
                          <i class="fa fa-trash"></i> Delete
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