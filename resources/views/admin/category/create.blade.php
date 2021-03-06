@extends('admin.layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">
            @include('common.errors')

            @if(Session::has('success_message'))
                <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success_message') !!}</em></div>
            @endif
            <form role="form" method="POST" id="create-form">
                {!! csrf_field() !!}
                @foreach ($fields as $field)
                <div class="form-group">
                    {!! $viewHelper->render($field) !!}
                </div>
                @endforeach
                <button type="submit" class="btn btn-default">Submit Button</button>
                <button type="reset" class="btn btn-default">Reset Button</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#create-form').validate({
        errorClass : 'form-validation-error'
    });
</script>
@endsection