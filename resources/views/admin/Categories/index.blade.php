@extends('layouts.app')

@section('htmlheader_title')
    Categories
@endsection
@section('contentheader_title', 'All Categories')

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
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Categories</h3>
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
                        <th>Category</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if($categories)

                        @foreach( $categories as $category)
                            <tr>
                                <td><input type="checkbox" id="checkbox" class="CheckBoxClassName" name="delete[]"
                                           value="{{$category->id}}" form="delete_form"></td>
                                <td>{{$category->id}}</td>
                                <td><strong>{{$category->name}}</strong></td>
                                {{--<td>{{$category->updated_at->diffForHumans()}}</td>--}}
                            </tr>
                        @endforeach

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
                {!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store'] ) !!}
                <div class="form-group">
                    {!! Form::label('name', ucfirst('name:')) !!}
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                </div>

                <div class="box-footer">
                    {!! Form::submit('Create category ', ['class'=>'btn btn-info']) !!}
                </div><!-- /.box-footer -->

                {!! Form::close() !!}
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>


@endsection
@section('sc')

    {!! Html::script('js/main.js') !!}
    {!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/tableExporter.js') !!}
    {!! Html::script('js/jquery.slimscroll.min.js') !!}
    {!! Html::script('plugins/fastclick/fastclick.min.js') !!}

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