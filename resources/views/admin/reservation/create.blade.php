@extends('layouts.app')

@section('htmlheader_title', 'Create Equipment')
@section('css')
    {!! Html::style('css/parsley.min.css') !!}
    {!! Html::style('plugins/timepicker/bootstrap-timepicker.min.css') !!}
    {!! Html::style('plugins/daterangepicker/daterangepicker-bs3.css') !!}
@endsection
@section('contentheader_title', 'Create')

@section('main-content')


    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Date picker</h3>
        </div>
        <div class="box-body">
            <!-- Date range -->


            <!-- Date and time range -->
            <div class="form-group">
                <label>Date and time range:</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="reservationtime">
                </div><!-- /.input group -->
            </div><!-- /.form group -->
        </div>
    </div>

@endsection
@section('sc')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::style('plugins/select2/select2.min.css') !!}
    {!! Html::script('plugins/select2/select2.full.js') !!}
    {!! Html::script('plugins/input-mask/jquery.inputmask.js') !!}
    {!! Html::script('plugins/input-mask/jquery.inputmask.date.extensions.js') !!}
    {!! Html::script('plugins/input-mask/jquery.inputmask.extensions.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    {!! Html::script('plugins/timepicker/bootstrap-timepicker.min.js') !!}
    {!! Html::script('plugins/daterangepicker/daterangepicker.js') !!}


    <script>




        $(function () {
            //Initialize Select2 Elements


            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mmA'});


            //Timepicker
            $(".timepicker").timepicker({
                showInputs: false
            });
        });

    </script>

@endsection

{{--'name', 'email', 'password','category_id','photo_id', 'is_active',--}}