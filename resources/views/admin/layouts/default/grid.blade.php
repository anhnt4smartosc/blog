@extends('admin.layouts.app')

@section('content')
<!-- /.row -->
<!-- DataTables CSS -->
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
<!-- /.panel-heading -->
<div class="panel-body">
<div class="dataTable_wrapper">
    @include('common.errors')

    @if(Session::has('success_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success_message') !!}</em></div>
    @endif
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
<tr>
    @foreach($fieldSources as $key => $field)
        <th>{{ $viewHelper->renderGridHeader($field) }}</th>
    @endforeach
    <td>Edit</td>
    <td>Delete</td>
</tr>
</thead>
<tbody>
@foreach($list as $item)
    <tr>
    @foreach($fieldSources as $key => $field)
        <td>{{ $viewHelper->getValue($field, $item->$key)}}</td>
    @endforeach
        <td><button type="button" class="btn btn-primary btn-update" data-link="{{ url('admin/category/update/'.$item->id)}}">Update</button></td>
        <td><button type="button" class="btn btn-danger btn-delete" data-link="{{ url('admin/category/delete/'.$item->id)}}">Delete</button></td>
    </tr>
@endforeach
</tbody>
</table>
</div>
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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        $('.btn-delete').on('click', function(event) {
            var check = confirm('Sure ?');
            if(!check) {
                return false;
            }

            window.location = $(this).data('link');
        });

        $('.btn-update').on('click', function(event) {
            window.location = $(this).data('link');
        });
    });
</script>
@endsection