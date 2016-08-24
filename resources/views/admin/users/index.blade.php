@extends('layouts.app')

@section('htmlheader_title')
    Users
@endsection
@section('contentheader_title', 'All Users')


@section('main-content')

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Users</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <a href="{{route('admin.users.create')}}" class="btn btn-primary btn-flat"><span
                                    class="glyphicon glyphicon-plus"></span> Create</a>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Email</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($users)

                                @foreach( $users as $user)
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <th><img height="50px" src="{{$user->photo? $user->photo->file:'http://lorempixel.com/50/50'}}" alt=""></th>
                                        <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}
                                        <td>{{$user->role_id == 0 ? 'No Role' : $user->role->name }}</td>
                                        <td>{{$user->is_active == 1 ? 'Active' : 'Not Active' }}</td>

                                        <td>{{$user->email}}</td>
                                        <td>{{$user->created_at->diffForHumans()}}</td>
                                        <td>{{$user->updated_at->diffForHumans()}}</td>
                                    </tr>
                                @endforeach

                            @endif
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

@endsection
@section('sc')
    @include('partial.checkAll')

@endsection()
