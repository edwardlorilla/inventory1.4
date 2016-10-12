@extends('layouts.app')

@section('htmlheader_title', 'Create Equipment')
@section('css')


@endsection
@section('contentheader_title', 'Create')

@section('main-content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
                        <div class="input-group input-group-md">
                            {!! Form::select('category_id',['' => 'Choose categories'] + $categories,null, ['class'=>'form-control myselect', 'required' => ''])!!}
                            <span class="input-group-btn">
                      <button id="add-group-btn" class="btn btn-success btn-block" type="button">Add Category</button>
                    </span>

                        </div>
                    </div>

                    <div class="form-group" id="add-new-group">

                        <div class="input-group">
                            <input placeholder="Add Category" type="text" name="new_group" id="new_group" class="form-control">
                          <span class="input-group-btn">
                            <a href="#" id="add-new-btn" class="btn btn-success">
                              <i class="glyphicon glyphicon-ok"></i>
                            </a>
                          </span>
                        </div>
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

                    <div class="form-group">
                        {!! Form::label('nonconsumable_id', ucfirst('Quantity:')) !!}
                        {!! Form::text('nonconsumable_id', null, ['class'=>'form-control']) !!}
                    </div>


                    {!! Form::hidden('consumable', 1, ['class'=>'form-control']) !!}
                    {!! Form::hidden('hasQuantity', 1, ['class'=>'form-control']) !!}

                    {!! Form::hidden('hasQuantity', 1, ['class'=>'form-control']) !!}
                    {{--['item', 'description','status','category_idcrea', 'photo_id'];--}}
                </div>

                @include('partial.error')
                <div class="box-footer">
                    <div class="box-footer">
                        {!! Form::submit('Create Equipments ', ['class'=>'btn btn-info ']) !!}
                    </div><!-- /.box-footer -->

                </div>
                {!! Form::close() !!}
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

@endsection
@section('sc')
    {!! Html::style('css/parsley.min.css') !!}
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::style('plugins/select2/select2.min.css') !!}
    {!! Html::script('plugins/select2/select2.full.js') !!}
    <script>
        $("#add-new-group").hide();
        $('#add-group-btn').click(function () {
            $("#add-new-group").slideToggle(function () {
                $('#new_group').focus();
            });
            return false;
        });
        $('#add-new-btn').click(function () {
            var newGroup = $('#new_group');
            $.ajax({
                url: "{{route("admin.categories.store")}}",
                method: 'post',
                data: {
                    name: $("#new_group").val(),
                    _token: $("input[name=_token]").val()
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON;
                    var error = errors.name[0];
                    if (error) {
                        var inputGroup = newGroup.closest('.input-group');
                        inputGroup.next('.text-danger').remove();
                        inputGroup.addClass('has-error').after('<p class="text-danger">' + error + '</p>');
                    }
                }
            });
        });
        $(".myselect").select2();
    </script>
@endsection

{{--'name', 'email', 'password','category_id','photo_id', 'is_active',--}}