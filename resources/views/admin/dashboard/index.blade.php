@extends('layouts.app')

@section('htmlheader_title')
@endsection
@section('contentheader_title', 'All Recently Added')
@section('main-content')
    <div class="row">
        <div class="col-md-6">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="pull-left header"><i class="fa fa-th"></i></li>
                    <li class="active"><a href="#tab_1" data-toggle="tab"><i class='fa fa-bookmark'></i> Consumables</a>
                    </li>
                    <li><a href="#tab_2" data-toggle="tab"><i class='fa fa-barcode'></i> Non Consumables</a></li>
                    <li><a href="#tab_3" data-toggle="tab"><i class='fa fa-bookmark'></i> Borrowed</a></li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">


                        <table id="firm_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="photo">Photo</th>
                                <th class="item">Item</th>
                                <th class="quantity">Quantity</th>
                                <th class="sta">Status</th>

                            </tr>
                            </thead>
                            <tbody>

                            @if($equipments)

                                @foreach( $equipments as $equipment)
                                    @if(!($equipment->nonconsumable_id) == 0 && !($equipment->status) == 0)
                                        <tr>


                                            <td><img height="50px"
                                                     src="{{ $equipment->photo ? $equipment->photo->file :'http://lorempixel.com/50/50'}}"
                                                     alt=""></td>
                                            <td>
                                                <a href="{{route('admin.equipment.edit', $equipment->id)}}"><strong>{{$equipment->item}}</strong></a>
                                            </td>

                                            <td class="quantity"
                                                style="{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity <= 1 ? 'color: #9f191f' : '':""}}">{{$equipment->nonconsumable ?$equipment->nonconsumable->quantity >=1 ?$equipment->nonconsumable->quantity : 'Out of stock':""}}</td>

                                            <td>
                                                <span class="label label-{{$equipment->nonconsumable ?  $equipment->nonconsumable->quantity >=1 ? $equipment->status==1 ? 'success':'default' : 'danger':""}}">{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity >=1 ?$equipment->status ? 'Available' : 'Borrowed' : 'Unavailable': ""}}</span>
                                            </td>


                                        </tr>
                                    @endif
                                @endforeach

                            @endif

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div>
                    <div class="tab-pane" id="tab_2">


                        <table id="firm_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="photo">Photo</th>
                                <th class="item">Item</th>
                                <th class="sta">Status</th>

                            </tr>
                            </thead>
                            <tbody>

                            @if($equipments)

                                @foreach( $equipments as $equipment)
                                    @if(($equipment->nonconsumable_id) == 0 )
                                        <tr>


                                            <td><img height="50px"
                                                     src="{{ $equipment->photo ? $equipment->photo->file :'http://lorempixel.com/50/50'}}"
                                                     alt=""></td>
                                            <td>
                                                <a href="{{route('admin.equipment.edit', $equipment->id)}}"><strong>{{$equipment->item}}</strong></a>
                                            </td>


                                            <td>
                                                <span class="label label-{{$equipment->status==1 ? 'success':'default'}}">{{$equipment->status == 1 ? 'Available' : 'Borrowed'}}</span>
                                            </td>


                                        </tr>
                                    @endif
                                @endforeach

                            @endif

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div>
                    <div class="tab-pane" id="tab_3">

                        <table id="firm_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="photo">Photo</th>
                                <th class="item">Item</th>
                                <th class="sta">Status</th>

                            </tr>
                            </thead>
                            <tbody>

                            @if($equipments)

                                @foreach( $equipments as $equipment)
                                    @if($equipment->consumable == 0)
                                        <tr>


                                            <td><img height="50px"
                                                     src="{{ $equipment->photo ? $equipment->photo->file :'http://lorempixel.com/50/50'}}"
                                                     alt=""></td>
                                            <td>
                                                <a href="{{route('admin.equipment.edit', $equipment->id)}}"><strong>{{$equipment->item}}</strong></a>
                                            </td>


                                            <td>
                                                <span class="label label-{{$equipment->status==1 ? 'success':'default'}}">{{$equipment->status == 1 ? 'Available' : 'Borrowed'}}</span>
                                            </td>


                                        </tr>
                                    @endif
                                @endforeach

                            @endif

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
        {{--<div class="col-md-6">--}}
            {{--<div class="box box-success">--}}
                {{--<div class="box-header with-border">--}}
                    {{--<h3 class="box-title">Recently Active Users</h3>--}}
                    {{--<div class="box-tools pull-right">--}}
                        {{--<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>--}}
                    {{--</div><!-- /.box-tools -->--}}
                {{--</div><!-- /.box-header -->--}}
                {{--<div class="box-body">--}}
                    {{--<table id="firm_table" class="table table-bordered table-striped">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th class="photo">Photo</th>--}}
                            {{--<th class="item">Name</th>--}}

                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}

                        {{--@if($users)--}}

                            {{--@foreach( $users as $user)--}}

                                        {{--<tr>--}}


                                            {{--<td><img height="50px"--}}
                                                     {{--src="{{ $user->photo ? $user->photo->file :'http://lorempixel.com/50/50'}}"--}}
                                                     {{--alt=""></td>--}}
                                            {{--<td>--}}
                                                {{--<a href="{{route('admin.user.edit', $user->id)}}"><strong>{{$user->name}}</strong></a>--}}
                                            {{--</td>--}}

                                            {{--<td>--}}
                                                {{--{{$user->last_login_at}}--}}
                                            {{--</td>--}}




                                        {{--</tr>--}}

                            {{--@endforeach--}}

                        {{--@endif--}}

                        {{--</tbody>--}}
                        {{--<tfoot>--}}
                        {{--</tfoot>--}}
                    {{--</table>--}}
                {{--</div><!-- /.box-body -->--}}
            {{--</div><!-- /.box -->--}}
        {{--</div>--}}
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
    <script>
        $(function () {
            $('#firm_table').DataTable({
                dom: 'Bfrtip',
                buttons: [

                    'copyHtml5',
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        title: d + ' Equipment',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '42');
                        }
                    },
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });

        });
    </script>
@endsection