@extends('layouts.app')

@section('htmlheader_title')
    Borrow
@endsection
@section('contentheader_title', 'All borrows')
@section('css')
    {!! Html::style('css/jquery.dataTables.min.css') !!}
@endsection

@section('main-content')

    @include('partial.errorModal')
    <div class="modal fade" id="return">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Return</h4>

                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'delete_form' , 'method'=>'POST',]) !!}


                    {{--{!! Form::select('borrows', $borrowdrop , null , ['class' => 'select2-multi form-control', 'multiple'=>'multiple']) !!}--}}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Return Item', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="box box-primary" id="ValidateCheckBox">
        <div class="box-header">
            <h3 class="box-title">Borrows</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="btn-group" style="margin-bottom: 20px">

                <button name="sendNewSms"  class="btn bg-primary btn-flat " id="sendNewSms" type="submit"
                        onClick="ValidateCheckBox();" >Return
                </button>

                <button type="button" class="btn bg-navy btn-flat" data-toggle="dropdown" aria-expanded="false">Export
                    to <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a onclick="exportTo('csv');" href="javascript://">CSV</a></li>
                    <li><a onclick="exportTo('txt');" href="javascript://">TXT</a></li>
                    <li><a onclick="exportTo('xls');" href="javascript://">XLS</a></li>
                    <li><a onclick="exportTo('sql');" href="javascript://">SQL</a></li>
                </ul>
            </div>


            <table id="firm_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="nosort"><input type="checkbox" id="checkAll"></th>
                    <th class="nosort">ID</th>
                    <th>Approved by</th>
                    <th>Borrowed by</th>
                    <th>Email</th>
                    <th>Equipment borrowed</th>
                </tr>
                </thead>
                <tbody>
                @if($borrows)

                    @foreach( $borrows as $borrow)
                        <tr>
                            <td><input  type="checkbox" id="checkbox" class="checkboxs CheckBoxClassName" name="return[]"
                                       value="{{$borrow->id}}" form="delete_form"></td>
                            <td>{{$borrow->id}}</td>
                            <td>{{$borrow->user->name}}</td>
                            <td><strong>{{$borrow->name}}</strong></td>
                            <td><a href="#" class="button-email" title="{{$borrow->description}}">{{$borrow->description}}</a></td>
                            <td>@foreach($borrow->equipments as $equipment)<span class="label label-default" value="{{$equipment->item}}">{{$equipment->item}}</span>@endforeach
                            </td>
                            {{--<td>{{$borrow->updated_at->diffForHumans()}}</td>--}}
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

    {!! Html::script('plugins/fastclick/fastclick.min.js') !!}
    {!! Html::script('js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('js/jquery.dataTables.min.js') !!}
    {!! Html::script('js/tableExporter.js') !!}

{!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/jquery.slimscroll.min.js') !!}

    <script>
        $('table').tableCheckbox({/* options */});
        function exportTo(type) {

            $('.table').tableExport({
                filename: 'table_%DD%-%MM%-%YY%',
                format: type,
                cols: '3,4,5,6'
            });

        }
        var selectedCheckBoxesValue = '';
        function ValidateCheckBox() {




            $('#ValidateCheckBox').find("input:checkbox.CheckBoxClassName:checked").each(function (i, selected) {
                if (selectedCheckBoxesValue.length == 0) {
                    selectedCheckBoxesValue += $(selected).val();

                }
                else {
                    selectedCheckBoxesValue += ',' + $(selected).val();
                }
            });
            // Here you also get all the comma separated values if you want else use below method for it


            if (selectedCheckBoxesValue.length == 0) {

                //  $('#sendNewSms').prop("disabled", !this.checked);
                $("#error").modal();
            } else {

                $("#return").modal();

            }


        }
        $(function () {
            $('#firm_table').DataTable({
                "pagingType": "full_numbers"
            });
            var button = $('#sendNewSms');
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
    </script>
@endsection()