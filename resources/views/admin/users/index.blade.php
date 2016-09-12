@extends('layouts.app')

@section('htmlheader_title')
    Users
@endsection
@section('contentheader_title', 'All Users')
@section('css')
    {!! Html::script('js/modernizr.custom.63321.js') !!}
    {!! Html::style('css/jquery.dataTables.min.css') !!}
    {!! Html::style('css/buttons.dataTables.min.css') !!}
@endsection

@section('main-content')


        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Users</h3>
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="btn-group" style="margin-bottom: 20px;">
                    <a href="{{route('admin.users.create')}}" class="btn btn-primary btn-flat"><span
                                class="glyphicon glyphicon-plus"></span> Create</a>
                </div>
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
                                <th><img height="50px"
                                         src="{{$user->photo? $user->photo->file:'http://lorempixel.com/50/50'}}"
                                         alt="">
                                </th>
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
        </div>



@endsection
@section('sc')

    {!! Html::script('js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('js/jquery.dataTables.min.js') !!}
    {!! Html::script('js/dataTables.buttons.min.js') !!}
    {!! Html::script('js/jszip.min.js') !!}
    {!! Html::script('js/pdfmake.min.js') !!}
    {!! Html::script('js/vfs_fonts.js') !!}
    {!! Html::script('js/buttons.html5.min.js') !!}
    {!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/jquery.slimscroll.min.js') !!}
    <script>
        $(function () {
            $('#example1').DataTable({
                "paging": false,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
@endsection()
