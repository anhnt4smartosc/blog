@extends('admin.layouts.app')

@section('content')
<!-- /.row -->
<!-- DataTables CSS -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <!-- /.panel-heading -->
            <div class="panel-body">
                {!! $previewMenu !!}
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<!-- jQuery -->
<script src="{{ $base_skin_url }}/bower_components/jquery/dist/jquery.min.js"></script>

<!-- DataTables JavaScript -->
<script src="{{ $base_skin_url }}/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{{ $base_skin_url }}/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ $base_skin_url }}/dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
@endsection