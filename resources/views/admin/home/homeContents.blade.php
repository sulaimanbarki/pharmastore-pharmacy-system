@extends('admin.master')

@section('title')
Dashboard
@endsection

@section('sideMenuTitle')
Dashboard
@endsection

@section('pageTitle')
Dashboard
@endsection


@section('bodyContent')
<!-- INDIVIDUAL CSS -->
<link rel="stylesheet" href="{{ asset('view_css/admin/home.css') }}">

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$orders}}</h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('order/list')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$categories}}</h3>

                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('category/list')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$products}}</h3>

                    <p>Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{url('product/list')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$users}}</h3>

                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{url('users/list')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->

            <!-- /.nav-tabs-custom -->
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Monthly Sales (6 Months)</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="areaChart"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

            <!-- Map box -->


            <!-- solid sales graph -->
            <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                    <i class="fa fa-th"></i>

                    <h3 class="box-title">Today Top 10 Sales</h3>

                </div>
                <div class="box-body border-radius-none">
                    <div class="chart" id="topTenSales">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice No #</th>
                                    <th>Grand Total ({{isset($settings) ? $settings->currency_symbol ?? "Currency Not Set" : "Currency Not Set"}})</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($orderList as $val)

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$val->order_number}}</td>
                                    <td>{{$val->grandtotal}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.box -->

            <!-- Calendar -->

            <!-- /.box -->

        </section>
        <!-- right col -->
    </div>

    <!-- /.row (main row) -->

    <div class="row">
        <div class="col-md-6">
            <!-- Chat box -->
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-hospital-o"></i>

                    <h3 class="box-title">Latest Medicine</h3>
                </div>
                <div class="chart tab-pane active" id="revenue-chart">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Purchase Price({{isset($settings->currency_symbol) ? $settings->currency_symbol : 0}})</th>
                                <th>Selling Price({{isset($settings->currency_symbol) ? $settings->currency_symbol : 0}})</th>
                                <th>Total Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($newProducts as $val)
                            <tr>
                                <td>{{$val->name}}</td>
                                <td>{{$val->purchasePrice}}</td>
                                <td>{{$val->sellingPrice}}</td>
                                <td>{{$val->totalPurchedItem}}</td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>


                </div>
            </div>
            <!-- /.box (chat box) -->
        </div>
    </div>
    <!-- /.row (main row) -->

</section>
@endsection

@section('page_script')

<script>
    "use strict";
    var monthlySales = @json($monthlysales);
</script>
<script src="{{ asset('view_js/admin/dashboard.js') }}"></script>
@endsection