@extends('layouts.app')

@section('htmlheader_title', 'Edit User')
@section('contentheader_title', 'Edit')
@section('css')
    {!! Html::style('css/parsley.min.css') !!}
@endsection
@section('main-content')
    <div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit User</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        {!! Form::model($user,['method'=>'PATCH', 'action'=>['AdminUsersController@update', $user->id], 'files'=>true]) !!}


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
                {!! Form::select('role_id', $roles ,null, ['class'=>'form-control'])!!}
            </div>
            <div class="form-group">
                {!! Form::label('photo_id', ucfirst('photo:')) !!}
                {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('is_active', ucfirst('status:')) !!}
                {!! Form::select('is_active', array(1=>'Active', 0=>'Not Active'),null, ['class'=>'form-control'])!!}
            </div>

        </div><!-- /.box-body -->

        <div class="box-footer">
            <div class="box-footer">
                {!! Form::submit('Edit Users ', ['class'=>'btn btn-info pull-right']) !!}
            </div><!-- /.box-footer -->
        </div>
        {!! Form::close() !!}
    </div><!-- /.box -->
    </div>
    @include('partial.error')

@endsection

{{--'name', 'email', 'password','role_id','photo_id', 'is_active',--}}