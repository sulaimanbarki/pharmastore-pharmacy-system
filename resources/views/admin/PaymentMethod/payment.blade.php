@extends('admin.master')

@section('title')
  Payment Method Add
@endsection 


@section('sideMenuTitle')
  Payment Method Add
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
            {!! Form::open(['url' => 'paymentmethods/add', 'method' => 'post', 'name' => 'form', 'enctype' => 'multipart/form-data',  'role' => 'form']) !!}
            @endif
            @if (isset($editData))
            {!! Form::open(['url' => 'paymentmethods/update', 'method' => 'post','name' => 'form', 'enctype' => 'multipart/form-data', 'role' => 'form']) !!}
            <input type="hidden" class="form-control" name="id" value="{{$editData->id}}">
            @endif
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Payment Type</label>
                  <input type="text" class="form-control" name="type" placeholder="Type" value="{{isset($editData) ? $editData->type:''}}">
                </div>
                <div class="form-group">
                      <label>Select Publis Status</label>
                      <select class="form-control" name="status">
                         @foreach ($publish as $pub)
                            <option value="{{ $pub->id }}" {{ (isset($editData) ? ($editData->status == $pub->id ? 'selected="selected"' : '') : ($loop->first ? 'selected="selected"' : '' ) ) }} >{{ $pub->name }}</option>
                        @endforeach 
                      </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" id="exampleInputFile" name="image">

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


  <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Now showing {{ $listData->count() * $listData->currentPage() }} out of {{ $listData->total() }} Names</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th> 
                  <th>Type</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  @foreach($listData as $val)
                  <tr>
                   <td>{{ $i++ }}</td>  
                    <td>{{$val->type}}</td>
                    <td><img src="{{ asset($val->image) }}" width="50" height="50" alt="no image"></td>
                    <td>{{$val->status == 1 ? "Published" : "Unpublished"}}</td>
                    <td>
                       <a class="btn btn-app  bg-blue" href="{{url('paymentmethods/edit/'.$val->id)}}">
                      <i class="fa fa-edit"></i> Edit
                   </a>
                   @if (Auth::user()->user_role->slug == "superadmin" || Auth::user()->user_role->slug == "admin")
                   <a class="btn btn-app bg-red" href="#" onclick="delete_item('{{url('paymentmethods/delete/'.$val->id)}}');">
                      <i class="fa fa-trash"></i> Delete
                   </a>
                   @endif
                   @if ($val->status == 2)
                   <a class="btn btn-app bg-green" href="{{url('paymentmethods/publishStatus/publish/'.$val->id)}}">
                      <i class="fa fa-file-o"></i>Publish?
                   </a>
                   @endif

                   @if ($val->status == 1)
                   <a class="btn btn-app bg-yellow" href="{{url('paymentmethods/publishStatus/unpublish/'.$val->id)}}">
                      <i class="fa fa-file-archive-o"></i> Unpublish?
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