@extends('admin.layout.admin')

@section('title', 'Quản trị website')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $countPost }}</h3>

                        <p>Bài viết</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    </div>
                    <a href="{{ route('posts.index') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $countProduct }}</h3>

                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-product-hunt" aria-hidden="true"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $countUser }}</h3>

                        <p>Người dùng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="https://sieuthithuoc365.com/admin/users" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $countOrder }}</h3>

                        <p>Đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="https://sieuthithuoc365.com/admin/don-hang" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- quick email widget -->
                <!-- solid sales graph -->
                <div class="box box-solid bg-teal-gradient">
                    <div class="box-header">
                        <i class="fa fa-th"></i>

                        <h3 class="box-title">Sales Graph</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body border-radius-none">
                        <div class="chart" id="line-chart" style="height: 250px;"></div>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

                <!-- Calendar -->
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header">
                        <i class="fa fa-calendar"></i>

                        <h3 class="box-title">Lịch</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <!-- button with a dropdown -->
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <!--The calendar -->
                        <div id="calendar" style="width: 100%"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                
                <!-- Map box -->
                <div class="box box-solid bg-light-blue-gradient">
                    <div class="box-header">
                        
                        <!-- /. tools -->

                        <i class="fa fa-map-marker"></i>

                        <h3 class="box-title">
                            Bản đồ
                        </h3>
                    </div>
                    <div class="box-body">
                        <div id="world-map" style="height: 250px; width: 100%;"></div>
                    </div>
                </div>
                <!-- /.box -->

            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>

    <script>
        var line = new Morris.Line({
            element          : 'line-chart',
            resize           : true,
            data             : [
                @foreach($orders as $order)
                    @if ( !empty($order->year))
                        { y:  '{!! $order->year.' Q'.$order->quarter !!}', item1: {!! $order->total_sum !!} },
                    @endif
                @endforeach
            ],
            xkey             : 'y',
            ykeys            : ['item1'],
            labels           : ['Item 1'],
            lineColors       : ['#efefef'],
            lineWidth        : 2,
            hideHover        : 'auto',
            gridTextColor    : '#fff',
            gridStrokeWidth  : 0.4,
            pointSize        : 4,
            pointStrokeColors: ['#efefef'],
            gridLineColor    : '#efefef',
            gridTextFamily   : 'Open Sans',
            gridTextSize     : 10
        });
    </script>
@endsection

