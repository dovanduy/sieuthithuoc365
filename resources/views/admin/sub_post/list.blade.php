@extends('admin.layout.admin')

@section('title', 'Danh sách '.$typePost )

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $typePost }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách {{ $typePost }}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('sub-posts.create', ['typePost' => $typePost]) }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="subPosts" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Hình ảnh</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection
@push('scripts')
<script>
    $(function() {
        $('#subPosts').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable_sub_posts', ['typePost' => $typePost]) !!}',
            columns: [
                { data: 'post_id', name: 'post_id' },
                { data: 'title', name: 'title' },
                { data: 'image', name: 'image', orderable: false,
                    render: function ( data, type, row, meta ) {
                        if (data == null) {
                            return 'Không có ảnh mô tả';
                        }
                        return '<img src="'+data+'" width="100" />';
                    },
                    searchable: false  },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush
