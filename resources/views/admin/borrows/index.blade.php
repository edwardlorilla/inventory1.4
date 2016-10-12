@extends('layouts.app')

@section('htmlheader_title')
    Borrow
@endsection
@section('contentheader_title', 'All Borrows')
@section('css')
    {!! Html::script('js/modernizr.custom.63321.js') !!}
    {!! Html::style('css/jquery.dataTables.min.css') !!}
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
@endsection

@section('main-content')

    @include('partial.message')
    <div class="modal fade" id="email">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Quick Email</h4>

                </div>
                <div class="modal-body">

                    <div id="userquerytable-container"></div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Send Email', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="return">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Return</h4>

                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'return_form' , 'method'=>'POST',]) !!}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Return Item', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="pull-left header"><i class="fa fa-th"></i></li>
            <li class="active"><a href="#tab_1" data-toggle="tab"><i class='fa fa-bookmark'></i> Consumables</a></li>
            <li><a href="#tab_2" data-toggle="tab"><i class='fa fa-barcode'></i> Non Consumables</a></li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <table id="firm_table" class="table table-bordered table-striped">
                    <thead>
                    <tr>


                        <th class="nosort">ID</th>
                        <th>Approved by</th>
                        <th>Borrowed by</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Equipment - Quantity</th>
                        <th>Date/Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($borrows)

                        @foreach( $borrows as $borrow)
                            @if($borrow->status ==  1)

                                <tr>

                                    <td>{{$borrow->id}}</td>
                                    <td>{{$borrow->user->name}}</td>
                                    <td>
                                        <a href="{{route('admin.users.edit', $borrow->borrowedby_id)}}">{{$borrow->borrowedby_id == 0 ? 'no user' :$borrow->borrowedby->name}}</a>
                                    </td>

                                    <td><a href="#" class="button-email"
                                           title="{{$borrow->user->email}}">{{$borrow->borrowedby->email}}</a></td>
                                    <td><a href="#" class="button-email"
                                           title="{{$borrow->location_id}}">{{$borrow->location_id == 0 ? 'location not found' : $borrow->location->room }}</a>
                                    </td>

                                    <td>@foreach($borrow->equipments as $nonconsumables)<span
                                                class="label label-default" id="{{$nonconsumables->id}}"
                                                value="{{$nonconsumables->name}}">{{$nonconsumables->item}}
                                            - {{$nonconsumables->stockin->deduction}} </span>
                                        <br>@endforeach
                                    </td>


                                    <td>{{$borrow->created_at->toDayDateTimeString()}}</td>
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
                <div class="btn-group" style="margin-bottom: 20px;">
                    <button name="sendNewSms" class="btn btn-primary btn-flat    " id="sendNewSms"
                            type="submit"
                            onClick="ValidateCheckBox();">Return
                    </button>
                </div>
                <table id="firm_table2" class="table table-bordered table-striped">
                    <thead>
                    <tr>

                        <th class="nosort"><input type="checkbox" id="checkAll"></th>

                        <th class="nosort">ID</th>
                        <th>Approved by</th>
                        <th>Borrowed by</th>
                        <th>Email</th>
                        <th>Equipment borrowed</th>
                        <th>Borrowed at</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if($borrows)
                        @foreach( $borrows as $borrow)
                            @if($borrow->status == 0 )
                                    <tr>
                                        <td><input type="checkbox" id="checkbox" class="checkboxs CheckBoxClassName"
                                                   name="return[]" value="{{$borrow->id}}" form="return_form"></td>
                                        <td>{{$borrow->id}}</td>
                                        <td>{{$borrow->user->name}}</td>
                                        <td>
                                            <a href="{{route('admin.users.edit', $borrow->borrowedby_id)}}">{{$borrow->borrowedby_id == 0 ? 'no user' :$borrow->borrowedby->name}}</a>
                                        </td>

                                        <td><a href="#" class="button-email"
                                               title="{{$borrow->user->email}}">{{$borrow->user->email}}</a></td>


                                        <td data-parent="{{$borrow->id}}">@foreach($borrow->equipments as $equipment)
                                                <span
                                                        class="label label-default"
                                                        value="{{$equipment->id}}">{{$equipment->item}}</span>
                                                ,@endforeach
                                        </td>


                                        <td>{{$borrow->updated_at->toDayDateTimeString()}}</td>
                                    </tr>
                                @endif

                        @endforeach

                    @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>


@endsection
@section('sc')

    {!! Html::script('plugins/fastclick/fastclick.min.js') !!}
    {!! Html::script('js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('js/jquery.dataTables.min.js') !!}
    {!! Html::script('js/tableExporter.js') !!}
    {!! Html::script('js/dataTables.buttons.min.js') !!}
    {!! Html::script('js/jszip.min.js') !!}
    {!! Html::script('js/pdfmake.min.js') !!}
    {!! Html::script('js/vfs_fonts.js') !!}
    {!! Html::script('js/buttons.html5.min.js') !!}
    {!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/jquery.slimscroll.min.js') !!}

    @if(session()->has('nonconsumables'))
        <script>
            $(document).ready(function () {
                $('.nav-tabs a[href="#tab_2"]').tab('show')

            });
        </script>
    @endif

    <script>
        $('table').tableCheckbox({});


        $('.button-email').click(function (e) {
            var list = document.getElementById("userquerytable-container");
            while (list.hasChildNodes()) {
                list.removeChild(list.firstChild);
            }

            var title = $(this).attr('title');

            $('#userquerytable-container').append('<form action="#" method="post"> <div class="form-group"> <input type="email" class="form-control" name="emailto" placeholder="Email to:" value="' + title + '"> </div> <div class="form-group"> <input type="text" class="form-control" name="subject" placeholder="Subject"> </div> <div> <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> </div> </form>');
            $("#email").modal();
        });
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


            $("#return").modal();


        }


        $(function () {

            $('#firm_table').DataTable({
                "paging": false,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
            $('#firm_table2').DataTable({
                "paging": false,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
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