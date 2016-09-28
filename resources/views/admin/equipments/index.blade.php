@extends('layouts.app')

@section('htmlheader_title')
    Equipment
@endsection
@section('contentheader_title', 'All equipments')
@section('css')
    {!! Html::style('css/parsley.min.css') !!}
    {!! Html::style('css/jquery.dataTables.min.css') !!}
    {!! Html::style('css/bootstrap-spinner.css') !!}
    {!! Html::style('css/buttons.dataTables.min.css') !!}

    <style>



        .example-modal .modal {
            position: relative;
            top: auto;
            bottom: auto;
            right: auto;
            left: auto;
            display: block;
            z-index: 1;
        }

        .example-modal .modal {
            background: transparent !important;
        }

    </style>
    {!! Html::script('js/jquery-1.12.4.min.js') !!}

    {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--}}


@endsection

@section('main-content')
    {{--<button disabled='false' type="button" data-toggle="modal" name="participant_add_btn"  id="participant_add_btn"  onclick="showSelectedValues();">Borrow</button>--}}
    {{--<input type="submit"  name="sendNewSms" class="inputButton"  id="sendNewSms" value=" Send " />--}}


    @include('partial.errorModal')
    @if(session()->has('RETURN'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            {{session('RETURN')}}
        </div>
    @endif
    <div class="modal fade example-modal" id="borrow" role="dialog">
        <div class="modal">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span class="inline-edit">Stock out Equipment</span></h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['id'=>'delete_form', 'method'=>'post']) !!}

                        <div class="form-group has-feedback">
                            {!! Form::label('name', 'Name') !!}<br>
                            {!! Form::select('name', $users, null,  ['class'=>' myselect'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('location_id', ucfirst('Department:')) !!}<br>
                            {!! Form::select('location_id', $locations, null,  ['class'=>'myselect'])!!}

                        </div>
                        <div class="form-group">
                            <div id="userquerytable-container"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        {!! Form::submit('Borrow Item', ['class'=>'btn btn-success  ']) !!}
                        {!! Form::close() !!}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>


    <div class="modal fade example-modal" id="borrownon" role="dialog">
        <div class="modal">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><span class="inline-edit">Equipment Borrows</span></h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['id'=>'borrows_form', 'method'=>'post']) !!}

                        <div class="form-group has-feedback">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::select('name', $users, null,  ['class'=>'form-control'])!!}
                        </div>


                        <div class="form-group">
                            {{--{!! Form::hidden('items', '', ['class' => 'form-control', 'id' =>'itemArray']) !!}--}}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        {!! Form::submit('Borrow Item', ['class'=>'btn btn-success  ']) !!}
                        {!! Form::close() !!}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

    <div class="modal fade example-modal" id="deleteModal">
        <div class="modal modal-danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Are you sure you want to delete this?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::open(['id'=>'delete_form', 'method'=>'delete']) !!}
                            <div class="col-sm-offset-2 col-sm-6">

                                {!! Form::hidden('no', '', ['class' => 'form-control', 'id' =>'deleteExample' ]) !!}
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        {!! Form::submit('Delete User', ['class'=>'btn btn-outline pull-left']) !!}
                        {!! Form::close() !!}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div><!-- /.example-modal -->





    @include('partial.message')
    <!-- Custom Tabs -->

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="pull-left header"><i class="fa fa-th"></i></li>
            <li class="active"><a href="#tab_1" data-toggle="tab"><i class='fa fa-bookmark'></i> Consumables <span
                            class="label label-primary">{{App\Equipment::where('hasQuantity','=',1)->count() == 0 ? App\Equipment::where('hasQuantity','=',1)->count() :App\Equipment::where('hasQuantity','=',1)->count() }}</span></a>
            </li>
            <li><a href="#tab_2" data-toggle="tab"><i class='fa fa-barcode'></i> Non Consumables <span
                            class="label label-info">{{App\Equipment::where('nonconsumable_id','=',null)->count() == 0 ? App\Equipment::where('nonconsumable_id','=',null)->count() :App\Equipment::where('nonconsumable_id','=',null)->count() }}</span></a>
            </li>
            <li><a href="#tab_3" data-toggle="tab"><i class='fa fa-bookmark'></i> Out of Stock <span
                            class="label label-danger">{{App\Equipment::where('outOfStock','=',1)->count() == 0 ? App\Equipment::where('outOfStock','=',1)->count() :App\Equipment::where('outOfStock','=',1)->count() }}</span></a>
            </li>
            <li><a href="#tab_4" data-toggle="tab"><i class='fa fa-bookmark'></i> Borrowed <span
                            class="label label-primary">{{App\Equipment::where('consumable','=',0)->count() == 0 ? App\Equipment::where('consumable','=',0)->count() :App\Equipment::where('consumable','=',0)->count() }}</span></a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div id="ValidateCheckBox">


                    <div class="box-body">
                        <div id="grpChkBox" >
                            <div class="btn-group" style="margin-bottom: 20px; ">

                                <button name="sendNewSms" class="btn bg-olive btn-flat " id="sendNewSms" type="submit"
                                        onClick="ValidateCheckBox();">Consume
                                </button>
                                <a href="{{route('admin.equipment.create')}}" class="btn btn-primary btn-flat"><span
                                            class="glyphicon glyphicon-plus"></span> Create</a>

                                <button name="sendNewSms" class="btn btn-danger btn-flat    " id="sendNewSms2"
                                        type="submit"
                                        onClick="deleteModal();">Delete
                                </button>
                            </div>

                            <div class="btn-group  pull-right">
                                <button type="button" class="btn bg-purple btn-flat dropdown-toggle"
                                        data-toggle="dropdown"><span
                                            class="glyphicon glyphicon-cog"></span> <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="no"/> ID</p></li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="add"/> Added by</p>
                                    </li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="cat"/> Categories</p>
                                    </li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="photo"/> Photo</p>
                                    </li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="item"/> Item</p></li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="des"/> Description
                                        </p></li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="sta"/> Status</p>
                                    </li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="created"/> Created at
                                        </p></li>
                                    <li style="margin-left: 10px;"><p><input type="checkbox" name="updated"/> Updated at
                                        </p></li>
                                </ul>
                            </div>
                        </div>


                        <table  id="firm_table" class="table table-bordered table-striped table-fixed">
                            <thead>
                            <tr>
                                <th class="nosort"><input type="checkbox" id="checkAll"></th>
                                <th class="no">#</th>
                                <th class="add">Added by</th>
                                <th class="cat">Categories</th>
                                <th class="photo">Photo</th>
                                <th class="item">Item</th>
                                <th class="quantity">Quantity</th>
                                <th class="des">Description</th>
                                <th class="sta">Status</th>
                                <th class="created">Created at</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($equipments)

                                @foreach( $equipments as $equipment)
                                    @if(!($equipment->nonconsumable_id) == 0 && !($equipment->status) == 0 && !($equipment->nonconsumable->quantity <= 0) )
                                        <tr>
                                            <td><input type="checkbox"
                                                       class="CheckBoxClassName" name="borrows[]"
                                                       value="{{$equipment->id}}"
                                                       form="delete_form"

                                                        {{--{{$equipment->nonconsumable->quantity==0 ? 'disabled' : ''}}--}}
                                                ></td>
                                            <td><span class="inline-edit">{{$equipment->id}}</span></td>
                                            <td>
                                                <a href="{{route('admin.users.edit',$equipment->user->id)}}">{{$equipment->user_id == 0 ? 'no user' : $equipment->user->name}}</a>
                                            </td>
                                            <td>{{$equipment->category ? $equipment->category->name : "Uncatalogued"}}</td>
                                            <td><img height="50px"
                                                     src="{{ $equipment->photo ? $equipment->photo->file :'http://lorempixel.com/50/50'}}"
                                                     alt=""></td>
                                            <td>
                                                <a href="{{route('admin.equipment.edit', $equipment->id)}}"><strong>{{$equipment->item}}</strong></a>
                                            </td>

                                            <td class="quantity"
                                                style="{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity <= 1 ? 'color: #9f191f' : '':""}}">{{$equipment->nonconsumable ?$equipment->nonconsumable->quantity >=1 ?$equipment->nonconsumable->quantity : 'Out of stock':""}}</td>

                                            <td>{{$equipment->description}}</td>
                                            <td>
                                                <span class="label label-{{$equipment->nonconsumable ?  $equipment->nonconsumable->quantity >=1 ? $equipment->status==1 ? 'success':'default' : 'danger':""}}">{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity >=1 ?$equipment->status ? 'Available' : 'Borrowed' : 'Unavailable': ""}}</span>
                                            </td>

                                            <td>{{$equipment->created_at->diffForHumans()}}</td>

                                        </tr>
                                    @endif
                                @endforeach

                            @endif

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->
                </div>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <div id="ValidateCheckBox">


                    <div class="box-body">
                        <div id="grpChkBox">
                            <div class="btn-group" style="margin-bottom: 20px;">

                                <button name="sendNewSms" class="btn bg-olive btn-flat " id="sendNewSms3" type="submit"
                                        onClick="borrownon();">Borrow
                                </button>
                                <a href="{{route('admin.nonconsumables.create')}}"
                                   class="btn btn-primary btn-flat"><span
                                            class="glyphicon glyphicon-plus"></span> Create</a>

                                <button name="sendNewSms" class="btn btn-danger btn-flat    " id="sendNewSms4"
                                        type="submit"
                                        onClick="deleteModal();">Delete
                                </button>
                            </div>


                        </div>


                        <table id="tab2" class="table table-bordered table-striped " width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="nosort"><input type="checkbox" id="checkAll"></th>
                                <th class="no">#</th>
                                <th class="add">Added by</th>
                                <th class="cat">Categories</th>
                                <th class="photo">Photo</th>
                                <th class="item">Item</th>
                                <th class="des">Description</th>
                                <th class="sta">Status</th>
                                <th class="created">Created at</th>
                                <th class="updated">Return at</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($equipments)

                                @foreach( $equipments as $equipment)
                                    @if(($equipment->nonconsumable_id) == 0 )
                                        <tr>
                                            <td><input type="checkbox"
                                                       class="CheckBoxClassName" name="non[]"
                                                       value="{{$equipment->id}}"
                                                       form="borrows_form"

                                                        {{--{{$equipment->nonconsumable->quantity==0 ? 'disabled' : ''}}--}}
                                                ></td>
                                            <td><span class="inline-edit">{{$equipment->id}}</span></td>
                                            <td>
                                                <a href="{{route('admin.equipment.edit',$equipment->id)}}">{{$equipment->user_id == 0 ? 'no user' : $equipment->user->name}}</a>
                                            </td>
                                            <td>{{$equipment->category ? $equipment->category->name : "Uncatalogued"}}</td>
                                            <td><img height="50px"
                                                     src="{{ $equipment->photo ? $equipment->photo->file :'http://lorempixel.com/50/50'}}"
                                                     alt=""></td>
                                            <td>
                                                <a href="{{route('admin.equipment.edit', $equipment->id)}}"><strong>{{$equipment->item}}</strong></a>
                                            </td>


                                            <td>{{$equipment->description}}</td>
                                            <td>
                                                <span class="label label-{{$equipment->status==1 ? 'success':'default'}}">{{$equipment->status == 1 ? 'Available' : 'Borrowed'}}</span>
                                            </td>

                                            <td>{{$equipment->created_at->diffForHumans()}}</td>
                                            <td>{{$equipment->updated_at->diffForHumans()}}</td>
                                        </tr>
                                    @endif
                                @endforeach

                            @endif

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->
                </div>
            </div><!-- /.tab-pane -->

            <div class="tab-pane" id="tab_3">
                <div id="ValidateCheckBox">


                    <div class="box-body">
                        <div id="grpChkBox">
                            <div class="btn-group" style="margin-bottom: 20px;">

                                <a href="{{route('admin.equipment.create')}}" class="btn btn-primary btn-flat"><span
                                            class="glyphicon glyphicon-plus"></span> Create</a>

                                <button name="sendNewSms" class="btn btn-danger btn-flat    " id="sendNewSms5"
                                        type="submit"
                                        onClick="deleteModal();">Delete
                                </button>
                            </div>


                        </div>


                        <table id="tab3" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                {{--<th class="nosort"><input type="checkbox" id="checkAll"></th>--}}

                                <th class="no">#</th>
                                <th class="add">Added by</th>
                                <th class="cat">Categories</th>
                                <th class="photo">Photo</th>
                                <th class="item">Item</th>
                                <th class="quantity">Quantity</th>
                                <th class="des">Description</th>
                                <th class="sta">Status</th>
                                <th class="created">Created at</th>
                                <th class="updated">Return at</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($equipments)

                                @foreach( $equipments as $equipment)
                                    @if($equipment->nonconsumable)
                                        @if($equipment->outOfStock == 1)
                                            <tr>
                                                {{--<td><input type="checkbox"--}}
                                                {{--class="CheckBoxClassName" name="borrows[]"--}}
                                                {{--value="{{$equipment->id}}"--}}
                                                {{--form="delete_form"--}}

                                                {{--{{$equipment->nonconsumable->quantity==0 ? 'disabled' : ''}}--}}
                                                {{--></td>--}}
                                                <td><span class="inline-edit">{{$equipment->id}}</span></td>
                                                <td>
                                                    <a href="{{route('admin.equipment.edit',$equipment->id)}}">{{$equipment->user_id == 0 ? 'no user' : $equipment->user->name}}</a>
                                                </td>
                                                <td>{{$equipment->category ? $equipment->category->name : "Uncatalogued"}}</td>
                                                <td><img height="50px"
                                                         src="{{ $equipment->photo ? $equipment->photo->file :'http://lorempixel.com/50/50'}}"
                                                         alt=""></td>
                                                <td>
                                                    <a href="{{route('admin.equipment.edit', $equipment->id)}}"><strong>{{$equipment->item}}</strong></a>
                                                </td>

                                                <td class="quantity"
                                                    style="{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity <= 1 ? 'color: #9f191f' : '':""}}">{{$equipment->nonconsumable ?$equipment->nonconsumable->quantity >=1 ?$equipment->nonconsumable->quantity : 'Out of stock':""}}</td>

                                                <td>{{$equipment->description}}</td>
                                                <td>
                                                    <span class="label label-{{$equipment->nonconsumable ?  $equipment->nonconsumable->quantity >=1 ? $equipment->status==1 ? 'success':'default' : $equipment->nonconsumable->quantity < 0 ? 'primary' : 'danger':""}}">{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity >=1 ?$equipment->status ? 'Available' : 'Borrowed' : $equipment->nonconsumable->quantity < 0 ? 'Borrowed': 'Unavailable': ""}}</span>
                                                </td>

                                                <td>{{$equipment->created_at->diffForHumans()}}</td>
                                                <td>{{$equipment->updated_at->diffForHumans()}}</td>
                                            </tr>
                                        @endif
                                    @endif

                                @endforeach

                            @endif

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>


                    </div><!-- /.box-body -->
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->

            <div class="tab-pane" id="tab_4">
                <div id="ValidateCheckBox">


                    <div class="box-body">


                        <table id="tab4" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                {{--<th class="nosort"><input type="checkbox" id="checkAll"></th>--}}

                                <th class="no">#</th>
                                <th class="add">Added by</th>
                                <th class="cat">Categories</th>
                                <th class="photo">Photo</th>
                                <th class="item">Item</th>
                                {{--<th class="quantity">Quantity</th>--}}
                                <th class="des">Description</th>
                                <th class="sta">Status</th>
                                <th class="created">Created at</th>
                                <th class="updated">Return at</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($equipments)

                                @foreach( $equipments as $equipment)
                                    @if($equipment->nonconsumable)
                                        @if($equipment->consumable == 0)
                                            <tr>
                                                {{--<td><input type="checkbox"--}}
                                                {{--class="CheckBoxClassName" name="borrows[]"--}}
                                                {{--value="{{$equipment->id}}"--}}
                                                {{--form="delete_form"--}}

                                                {{--{{$equipment->nonconsumable->quantity==0 ? 'disabled' : ''}}--}}
                                                {{--></td>--}}
                                                <td><span class="inline-edit">{{$equipment->id}}</span></td>
                                                <td>
                                                    <a href="{{route('admin.equipment.edit',$equipment->id)}}">{{$equipment->user_id == 0 ? 'no user' : $equipment->user->name}}</a>
                                                </td>
                                                <td>{{$equipment->category ? $equipment->category->name : "Uncatalogued"}}</td>
                                                <td><img height="50px"
                                                         src="{{ $equipment->photo ? $equipment->photo->file :'http://lorempixel.com/50/50'}}"
                                                         alt=""></td>
                                                <td>
                                                    <a href="{{route('admin.equipment.edit', $equipment->id)}}"><strong>{{$equipment->item}}</strong></a>
                                                </td>

                                                {{--<td class="quantity"--}}
                                                {{--style="{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity <= 1 ? 'color: #9f191f' : '':""}}">{{$equipment->nonconsumable ?$equipment->nonconsumable->quantity >=1 ?$equipment->nonconsumable->quantity : 'Out of stock':""}}</td>--}}

                                                <td>{{$equipment->description}}</td>
                                                <td>
                                                    <span class="label label-{{$equipment->nonconsumable ?  $equipment->nonconsumable->quantity >=1 ? $equipment->status==1 ? 'success':'default' : $equipment->nonconsumable->quantity < 0 ? 'primary' : 'danger':""}}">{{$equipment->nonconsumable ? $equipment->nonconsumable->quantity >=1 ?$equipment->status ? 'Available' : 'Borrowed' : $equipment->nonconsumable->quantity < 0 ? 'Borrowed': 'Unavailable': ""}}</span>
                                                </td>

                                                <td>{{$equipment->created_at->diffForHumans()}}</td>
                                                <td>{{$equipment->updated_at->diffForHumans()}}</td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach

                            @endif

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div>
    </div><!-- nav-tabs-custom -->






@endsection
@section('sc')
    {{--@include('partial.checkAll')--}}
    {!! Html::script('plugins/fastclick/fastclick.min.js') !!}
    {!! Html::script('js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('js/jquery.dataTables.min.js') !!}
    {!! Html::style('plugins/select2/select2.min.css') !!}
    {!! Html::script('plugins/select2/select2.full.js') !!}
    {!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/jquery.slimscroll.min.js') !!}
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/jquery.spinner.js.js') !!}
    {!! Html::script('js/dataTables.buttons.min.js') !!}
    {{--{!! Html::script('js/jszip.min.js') !!}--}}
    {{--{!! Html::script('js/pdfmake.min.js') !!}--}}
    {{--{!! Html::script('js/vfs_fonts.js') !!}--}}
    {{--{!! Html::script('js/buttons.html5.min.js') !!}--}}
    {!! Html::script('js/jszip.min.js') !!}
    {!! Html::script('js/pdfmake.min.js') !!}
    {!! Html::script('js/vfs_fonts.js') !!}
    {!! Html::script('js/buttons.html5.min.js') !!}
    @if(session()->has('borrows'))

        <script>
            $(document).ready(function () {
                $('.nav-tabs a[href="#tab_2"]').tab('show')

            });
        </script>
    @endif
    @if(session()->has('RETURN'))

        <script>
            $(document).ready(function () {
                $('.nav-tabs a[href="#tab_2"]').tab('show')

            });
        </script>
    @endif
    <script>
        $(".myselect").select2();
        var editor;


        $('table').tableCheckbox({/* options */});

        $(function () {

            var tdate = new Date();
            var dd = tdate.getDate(); //yields day
            var MM = tdate.getMonth(); //yields month
            var yyyy = tdate.getFullYear(); //yields year
            var d = dd + "-" + ( MM + 1) + "-" + yyyy;
            $('#firm_table').DataTable({
                "scrollY":        "500px",
                "scrollCollapse": true,
                "paging": false,
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
            $('#tab2').DataTable({

                "paging": false,
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
            $('#tab3').DataTable({
                "paging": false,
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
            $('#tab4').DataTable({
                "paging": false,
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

            var button = $('#sendNewSms');
            var button2 = $('#sendNewSms2');
            var button3 = $('#sendNewSms3');
            var button4 = $('#sendNewSms4');
            var button5 = $('#sendNewSms5');
            button.attr('disabled', 'disabled');
            button2.attr('disabled', 'disabled');
            button3.attr('disabled', 'disabled');
            button4.attr('disabled', 'disabled');
            button5.attr('disabled', 'disabled');
//            $('#toggle').change(function (e) {
//                if (!this.checked) {
//                    button.attr('disabled', 'disabled');
//                } else {
//                    button.removeAttr('disabled');
//
//                }
//            });

            $("input[class='CheckBoxClassName']").change(function () {


                var maxAllowed = 0;
                var cnt = $("input[class='CheckBoxClassName']:checked").length;


                if (cnt == maxAllowed) {
                    button2.attr('disabled', 'disabled');
                    button.attr('disabled', 'disabled');
                    button3.attr('disabled', 'disabled');
                    button5.attr('disabled', 'disabled');
                    button4.attr('disabled', 'disabled');
                } else {
                    button.removeAttr('disabled');
                    button2.removeAttr('disabled');
                    button3.removeAttr('disabled');
                    button4.removeAttr('disabled');
                    button5.removeAttr('disabled');
                }

            });


            var $chk = $("#grpChkBox input:checkbox");
            var $tbl = $("#firm_table");
            var $tblhead = $("#firm_table th");
            $chk.prop('checked', true);
            $chk.click(function () {
                var colToHide = $tblhead.filter("." + $(this).attr("name"));
                var index = $(colToHide).index();
                $tbl.find('tr :nth-child(' + (index + 1) + ')').toggle();
            });
            $("#quantity").keydown(function (e) {
                if ((e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode >= 35 && e.keyCode <= 40) ||
                        $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                        (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });


        });

        var options = [];

        $('.dropdown-menu a').on('click', function (event) {

            var $target = $(event.currentTarget),
                    val = $target.attr('data-value'),
                    $inp = $target.find('input'),
                    idx;

            if (( idx = options.indexOf(val) ) > -1) {
                options.splice(idx, 1);
                setTimeout(function () {
                    $inp.prop('checked', false)
                }, 0);
            } else {
                options.push(val);
                setTimeout(function () {
                    $inp.prop('checked', true)
                }, 0);
            }

            $(event.target).blur();

            console.log(options);
            return false;
        });
        var selectedCheckBoxesValue = '';

        function ValidateCheckBox() {
//                    $('#ValidateCheckBox').find("input:checkbox.CheckBoxClassName:checked").each(function (i, selected) {
//                        if (selectedCheckBoxesValue.length == 0) {
//                            selectedCheckBoxesValue += $(selected).val();
//                        }
//                        else {
//                            selectedCheckBoxesValue += ',' + $(selected).val();
//                        }
//                    });
//                    if (selectedCheckBoxesValue.length == 0) {
//                        $("#error").modal();
//                    } else {
            var list = document.getElementById("userquerytable-container");
            while (list.hasChildNodes()) {
                list.removeChild(list.firstChild);
            }
            var chkArray = [];
            var data;
            $("input[name='borrows[]']:checked").map(function () {
                chkArray.push([$(this).closest("tr").find("td:eq(5)").text(), $(this).closest("tr").find("td:eq(6)").text()]);
                var colData = ["Item", "Quantity"];
                data = {"Cols": colData, "Rows": chkArray};
            }).get();
            var table = $('<table/>').attr("id", "userquerytable").addClass("display").attr("cellspacing", "0").attr("width", "100%");
            var tr = $('<tr/>');
            table.append('<thead>').children('thead').append(tr);
            for (var i = 0; i < data.Cols.length; i++) {
                tr.append('<th><span class="inline-edit">' + data.Cols[i] + '</span></th>');
            }
            for (var r = 0; r < data.Rows.length; r++) {
                var tr = $('<tr/>');
                table.append(tr);
                for (var c = 0; c < data.Cols.length; c++) {
                    if (c % 2 == 0) {
                        tr.append('<td>' + data.Rows[r][c] + '</td>');
                    } else {
                        tr.append('<td><input type="number" min="1" max="' + data.Rows[r][c] + '" required="" name="quantity[]" id="quantity" value="1"></td><input type="hidden" name="originalQuantity[]" id="originalQuantity" value="' + data.Rows[r][c] + '" >');
                    }
                }
            }


            if ($.fn.dataTable.isDataTable('#userquerytable')) {
                $('#userquerytable').DataTable();
            }
            else {

                $('#userquerytable').DataTable().destroy();

                $('#userquerytable-container').append(table);
                $('#userquerytable').DataTable({

                    "pagingType": "full_numbers"
                });
            }
            $("#borrow").modal('show');
//                    }
        }

        function borrownon() {
            var list = document.getElementById("userquerytable-container");
            while (list.hasChildNodes()) {
                list.removeChild(list.firstChild);
            }
            var chkArray = [];

            $("input[name='borrows[]']:checked").map(function () {
                chkArray.push(this.value);
            }).get();

            $('#itemArray').attr('value', chkArray);
            $("#borrownon").modal();
        }

        function deleteModal() {

//                    $('#ValidateCheckBox').find("input:checkbox.CheckBoxClassName:checked").each(function (i, selected) {
//                        if (selectedCheckBoxesValue.length == 0) {
//                            selectedCheckBoxesValue += $(selected).val();
//
//                        }
//                        else {
//                            selectedCheckBoxesValue += ',' + $(selected).val();
//                        }
//                    });
//                    if (selectedCheckBoxesValue.length == 0) {
//
//                        //  $('#sendNewSms').prop("disabled", !this.checked);
//                        $("#error").modal();
//                    } else {
            var chkArray = [];
            $("input[name='non[]']:checked").map(function () {
                chkArray.push(this.value);
            }).get();
            $("input[name='borrows[]']:checked").map(function () {
                chkArray.push(this.value);
            }).get();
            var selected;
            selected = chkArray.join(',') + ",";
            $('#deleteExample').attr('value', selected);
            $('#deleteModal').modal();
            //$('.method').attr('id', $(this).data('delete_form'));
//                    }
        }


    </script>



@endsection()

