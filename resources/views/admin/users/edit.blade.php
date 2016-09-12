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
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h1 class="box-title">{{$user->item}} History
                        <small>{{$user->borrows()->count()}} users</small>
                    </h1>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="firm_table2" class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th class="no">#</th>
                            <th class="add">Borrowed by</th>
                            <th class="Equipments">Equipments</th>
                            <th class="Equipments">Equipments Quantity</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($user->borrows as $borrow)
                            <tr>
                                <th>{{$borrow->id}}</th>
                                <td><a href="{{route('admin.users.edit', $borrow->borrowedby_id)}}">{{$borrow->borrowedby_id == 0 ? 'no user' :$borrow->borrowedby->name}}</a></td>

                                <td>@foreach($borrow->nonconsumables as $nonconsumables)<span
                                            class="label label-default" id="{{$nonconsumables->id}}"
                                            value="{{$nonconsumables->name}}">{{$nonconsumables->name}}</span>@endforeach
                                </td>
                                @if($borrow->nonconsumables)
                                    <td>@foreach($borrow->nonconsumables as $nonconsumables)<span
                                                class="label label-default" id="{{$nonconsumables->id}}"
                                                value="{{$nonconsumables->quantity}}"> {{$nonconsumables->quantity}} </span>@endforeach
                                    </td>
                                @endif

                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection

{{--'name', 'email', 'password','role_id','photo_id', 'is_active',--}}