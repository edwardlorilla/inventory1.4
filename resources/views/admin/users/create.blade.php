@extends('layouts.app')

@section('htmlheader_title', 'Create User')
@section('css')
    {!! Html::style('css/parsley.min.css') !!}
@endsection
@section('contentheader_title', 'Create')

@section('main-content')


<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Create User</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    {!! Form::open(['method'=>'POST', 'action'=>'AdminUsersController@store' , 'files'=>true] ) !!}


        <div class="box-body">
            <div class="form-group">
                {!! Form::label('name', ucfirst('name:')) !!}
                {!! Form::text('name', null, ['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', ucfirst('email:')) !!}
                {!! Form::text('email', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', ucfirst('password:')) !!}
                {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password'])!!}
            </div>
            <div class="form-group">
                {!! Form::label('role_id', ucfirst('role:')) !!}
                {!! Form::select('role_id', [''=>'Choose options']+ $roles ,null, ['class'=>'form-control'])!!}
            </div>
            <div class="form-group">
                {!! Form::label('photo_id', ucfirst('photo:')) !!}
                {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('is_active', ucfirst('status:')) !!}
                {!! Form::select('is_active', array(1=>'Active', 0=>'Not Active'),0, ['class'=>'form-control'])!!}
            </div>

        </div><!-- /.box-body -->
        @include('partial.error')
        <div class="box-footer">
            <div class="box-footer">
                {!! Form::submit('Create Users ',    ['class'=>'btn btn-info pull-right']) !!}
            </div><!-- /.box-footer -->

        </div>
    {!! Form::close() !!}
</div><!-- /.box -->

@endsection
@section('sc')
    {!! Html::script('js/parsley.min.js') !!}
@endsection
{{--'name', 'email', 'password','role_id','photo_id', 'is_active',--}}