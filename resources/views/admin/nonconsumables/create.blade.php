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
        {!! Form::open(['method'=>'POST', 'action'=>'AdminEquipmentController@store' , 'files'=>true, 'data-parsley-validate' => ''] ) !!}
        {{--'title', 'body','category_id', 'photo_id'--}}

        <div class="box-body">
            <div class="form-group">
                {!! Form::label('item', ucfirst('title:')) !!}
                {!! Form::text('item', null, ['class'=>'form-control', 'required' => '']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('category_id', ucfirst('Categories:')) !!}
                {!! Form::select('category_id',['' => 'Choose categories']+ $categories,null, ['class'=>'form-control myselect', 'required' => '' ])!!}
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
                {!! Form::file('photo_id',null, ['class'=>'form-control', 'required' => '']) !!} {!! Form::hidden('consumable', 0, ['class'=>'form-control']) !!}{!! Form::hidden('hasQuantity', 0, ['class'=>'form-control']) !!}
            </div>


            {{--['item', 'description','status','category_id', 'photo_id'];--}}

        </div><!-- /.box-body -->
        @include('partial.error')
        <div class="box-footer">
            <div class="box-footer">
                {!! Form::submit('Create Equipments ', ['class'=>'btn btn-info ']) !!}
            </div><!-- /.box-footer -->

        </div>
        {!! Form::close() !!}
    </div><!-- /.box -->

@endsection
@section('sc')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::style('plugins/select2/select2.min.css') !!}
    {!! Html::script('plugins/select2/select2.full.js') !!}
    <script>$(".myselect").select2();</script>
@endsection

{{--'name', 'email', 'password','category_id','photo_id', 'is_active',--}}