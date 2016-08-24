@extends('layouts.app')

@section('htmlheader_title', 'Create Equipment')
@section('css')
    {!! Html::style('css/parsley.min.css') !!}
@endsection
@section('contentheader_title', 'Create')

@section('main-content')


    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Create Equipment</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        {!! Form::model($equipments, ['method'=>'PATCH', 'action'=>['AdminEquipmentController@update', $equipments->id] , 'files'=>true, 'data-parsley-validate' => ''] ) !!}
        {{--'title', 'body','category_id', 'photo_id'--}}

        <div class="box-body">
            <div class="form-group">
                {!! Form::label('item', ucfirst('title:')) !!}
                {!! Form::text('item', null, ['class'=>'form-control', 'required' => '']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('category_id', ucfirst('Categories:')) !!}
                {!! Form::select('category_id', $categories,null, ['class'=>'form-control', 'required' => ''])!!}
            </div>
            <div class="form-group">
                {!! Form::label('description', ucfirst('body:')) !!}
                {!! Form::textarea('description', null, ['class'=>'form-control', 'required' => '', 'rows'=>3]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status', ucfirst('status:')) !!}
                {!! Form::select('status', array(1=>'Available'),0, ['class'=>'form-control', 'required' => ''])!!}
            </div>

            <div class="form-group">
                {!! Form::label('photo_id', ucfirst('photo:')) !!}
                {!! Form::file('photo_id',null, ['class'=>'form-control', 'required' => '']) !!}
            </div>


            {{--['item', 'description','status','category_id', 'photo_id'];--}}

        </div><!-- /.box-body -->
        @include('partial.error')
        <div class="box-footer">
            <div class="box-footer">
                {!! Form::submit('Update Equipments ', ['class'=>'btn btn-info pull-right']) !!}
            </div><!-- /.box-footer -->

        </div>
        {!! Form::close() !!}
    </div><!-- /.box -->

@endsection
@section('sc')
    {!! Html::script('js/parsley.min.js') !!}
@endsection

{{--'name', 'email', 'password','category_id','photo_id', 'is_active',--}}