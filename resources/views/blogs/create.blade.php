<!-- resources/views/tasks.blade.php -->

@extends('layouts.app')

@section('content')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- New Task Form -->
    <form action="{{ url('blog') }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}

        <!-- Task Name -->
        <div class="form-group">
            <label for="task" class="col-sm-3 control-label">Task</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="title" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="task" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="description" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="task" class="col-sm-3 control-label">Content</label>

            <div class="col-sm-6">
                <input type="text" name="content" id="content" class="form-control">
            </div>
        </div>

        <!-- Add Task Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Blog
                </button>
            </div>
        </div>
    </form>
</div>

<!-- TODO: Current Tasks -->
@endsection