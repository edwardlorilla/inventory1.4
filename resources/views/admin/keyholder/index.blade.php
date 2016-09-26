@extends('layouts.app')

@section('htmlheader_title')
    Keyholders
@endsection
@section('contentheader_title', 'All Keyholder')

@section('css')

    {{--{!! Html::script('js/jquery-1.12.4.min.js') !!}--}}

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

    <script type="text/javascript">
        $(function () {
            var $chk = $("#grpChkBox input:checkbox");
            var $tbl = $("#firm_table");
            var $tblhead = $("#firm_table th");
            $chk.prop('checked', true);
            $chk.click(function () {
                var colToHide = $tblhead.filter("." + $(this).attr("name"));
                var index = $(colToHide).index();
                $tbl.find('tr :nth-child(' + (index + 1) + ')').toggle();
            });        });
    </script>
@endsection
@section('main-content')

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
                                <div class="form-group">

                                </div>


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
    <div class="modal fade example-modal" id="error">
        <div class="modal modal-danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Oh snap!</h4>
                    </div>
                    <div class="modal-body">
                        <p>You must select at least 1 choices.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div><!-- /.example-modal -->
    @include('partial.message')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Keyholders</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <button name="sendNewSms" class="btn btn-danger btn-flat" type="submit" id="deleteButton"
                            onClick="deleteModal();" disabled>Delete
                    </button>
                    <table id="grpChkBox" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="nosort"><input type="checkbox" id="checkAll"></th>
                            <th class="nosort">ID</th>
                            <th>User</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($keyholders)

                            @foreach( $keyholders as $keyholder)
                                <tr data-toggle="collapse" data-target="#collapse{{$keyholder->id}}">
                                    <td><input type="checkbox" id="checkbox" class="CheckBoxClassName" name="delete[]"
                                               value="{{$keyholder->id}}" form="delete_form"></td>
                                    <td>{{$keyholder->id}}</td>
                                    <td><strong>{{$keyholder->user->name}}</strong></td>
                                    <td>{{$keyholder->quantity}}</td>

                                    {{--<td><strong>{{$keyholder->location->room}}</strong></td>--}}
                                    {{--<td><strong>{{$keyholder->location->floor_located}}</strong></td>--}}
                                    {{--<td>{{$keyholder->updated_at->diffForHumans()}}</td>--}}
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="{{$keyholder->id}}">
                                        <div id="collapse{{$keyholder->id}}" class="collapse out">
                                            @foreach($keyholder->locations as $locatio)<span
                                                    class="label label-default" id="{{$locatio->id}}"
                                                    value="{{$locatio->room}}">{{$locatio->room}} - {{$locatio->floor_located}}</span><br/>@endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            {{--['user_id', 'quantity', 'location_id'--}}
                        @endif
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Create category</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['method'=>'POST', 'action'=>'AdminKeyholderController@store'] ) !!}

                    <div class="form-group">
                        {!! Form::label('user_id', ucfirst('user:')) !!}

                        {!! Form::select('user_id',['' => 'Choose categories'] + $user,null, ['class'=>'form-control myselect', 'required' => ''])!!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('quantity', ucfirst('quantity:')) !!}
                        {!! Form::number('quantity', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('location_id', ucfirst('location:')) !!}
                        {!! Form::select('location_id', $location,null, ['name'=>'locations[]','multiple'=>"multiple", 'class'=>'form-control myselect', 'required' => ''])!!}

                    </div>


                    <div class="box-footer">
                        {!! Form::submit('Add Location ', ['class'=>'btn btn-info']) !!}
                    </div><!-- /.box-footer -->



                    {!! Form::close() !!}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>


@endsection
@section('sc')

    {!! Html::script('js/main.js') !!}
    {!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/tableExporter.js') !!}
    {!! Html::script('js/jquery.slimscroll.min.js') !!}
    {!! Html::script('plugins/fastclick/fastclick.min.js') !!}
    {!! Html::style('plugins/select2/select2.min.css') !!}
    {!! Html::script('plugins/select2/select2.full.js') !!}
    <script>$(".myselect").select2();</script>

    <script>
        $('table').tableCheckbox({/* options */});
        $(function () {
            var button = $('#deleteButton');
            button.attr('disabled', 'disabled');
            $("input[id='checkbox']").change(function () {

                var maxAllowed = 0;
                var cnt = $("input[id='checkbox']:checked").length;

                if (cnt == maxAllowed) {
                    button.attr('disabled', 'disabled');

                } else {
                    button.removeAttr('disabled');
                }

            });
        });
        function deleteModal() {

            $("#deleteModal").modal();

        }
    </script>
@endsection()