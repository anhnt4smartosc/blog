@extends('admin.layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <form role="form" action="" method="POST">
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
@endsection