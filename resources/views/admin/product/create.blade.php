@extends('admin.layouts.app')

@section('content')
<!-- Drop Zone -->
<link href="{{ $base_skin_url }}/dist/css/uploadify.css" rel="stylesheet">
<script src="{{ $base_skin_url }}/js/jquery.uploadify.js"></script>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @include('common.errors')

            @if(Session::has('success_message'))
            <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success_message') !!}</em></div>
            @endif
            <form role="form" method="POST" id="create-form">
                <div class="col-lg-6">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label>Product Name</label>
                        <input class="form-control" type="text" required="1">
                    </div>
                    <div class="form-group">
                        <label>Cost</label>
                        <input class="form-control" type="text" required="1">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control" type="text" required="1">
                    </div>
                    <div class="form-group">
                        <label>Special Price</label>
                        <input class="form-control" type="text" required="1">
                    </div>
                    <div class="form-group">
                        <label>Special Price To</label>
                        <input class="form-control" type="date" required="1">
                    </div>
                    <div class="form-group">
                        <label>Special Price From</label>
                        <input class="form-control" type="date" required="1">
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control">
                            <option value="1">Type 1</option>
                            <option value="0">Type 1</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h4>Media and galleries</h4>
                    <div id="image-container" class="form-group">
                        <label>File Input</label>
                        <input type="hidden" type="text" id="image-path" name="image-path">
                        <input type="file" id="image-file" name="image">
                    </div>
                </div>
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-default">Submit Button</button>
                    <button type="reset" class="btn btn-default">Reset Button</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#create-form').validate({
        errorClass : 'form-validation-error'
    });

    $('#image-file').uploadify({
        'enctype'   : 'multipart/form-data',
        'formData' : {'_token' : '{{csrf_token()}}' },
        'swf'      : '{{ $base_skin_url }}/js/uploadify.swf',
        'uploader' : "{{ url('admin/product/upload')}}",
        'onUploadStart' : function() {
            $('#image-path').val('');
            if($('#image-info').length > 0) {
                $('#image-info').remove();
            }
        },
        'onUploadSuccess' : function(file, data, response) {
            var result = JSON.parse(data);
            if(result.code == 200) {
                var thumbnail = "<img src=' " + result.data.image_url + "' height='50'/>";
                var imageInfo = "<div id='image-info' class='form-group'> " + thumbnail + "</div>";
                $(imageInfo).insertAfter('#image-path');
                $('#image-path').val(result.data.image_url);
            }
        }
    });

</script>
@endsection