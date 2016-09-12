@extends('layouts.app')

@section('htmlheader_title', 'Create Equipment')
@section('css')
    {!! Html::style('css/parsley.min.css') !!}
    {!! Html::style('css/jquery.dataTables.min.css') !!}
    {!! Html::style('css/bootstrap-spinner.css') !!}
    {!! Html::style('css/buttons.dataTables.min.css') !!}

    {!! Html::script('js/jquery-1.12.4.min.js') !!}
@endsection
@section('contentheader_title', 'Setting')

@section('main-content')

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Equipment</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($equipments, ['method'=>'PATCH', 'action'=>['AdminEquipmentController@update', $equipments->id] , 'files'=>true, 'data-parsley-validate' => ''] ) !!}
            {{--'title', 'body','category_id', 'photo_id'--}}

            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('item', ucfirst('title:')) !!}
                    {!! Form::text('item', null, ['class'=>'form-control', 'required' => '']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('category_id', ucfirst('Categories:')) !!}
                    {!! Form::select('category_id', $categories,null, ['class'=>'form-control', 'required' => ''])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', ucfirst('body:')) !!}
                    {!! Form::textarea('description', null, ['class'=>'form-control', 'required' => '', 'rows'=>3]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('status', ucfirst('status:')) !!}
                    {!! Form::select('status', array(1=>'Available'),0, ['class'=>'form-control', 'required' => ''])!!}
                </div>

                <div class="form-group">
                    {!! Form::label('photo_id', ucfirst('photo:')) !!}
                    {!! Form::file('photo_id',null, ['class'=>'form-control', 'required' => '']) !!}
                </div>
                @if($equipments->nonconsumable)
                    <div class="form-group">
                        {!! Form::label('nonconsumable_id', ucfirst('Quantity:')) !!}
                        {!! Form::number('nonconsumable',$equipments->nonconsumable->quantity,['class'=>'form-control', 'required' => '', 'min' => 1] ) !!}

                    </div>

                @endif

                {!! Form::hidden('nonconsumable_id', null, ['class'=>'form-control']) !!}
                {!! Form::hidden('consumable', 0, ['class'=>'form-control']) !!}
                @if($equipments->nonconsumable)
                    {!! Form::hidden('hasQuantity', 1, ['class'=>'form-control']) !!}
                @endif
                @if(!$equipments->nonconsumable)
                    {!! Form::hidden('hasQuantity', 0, ['class'=>'form-control']) !!}
                @endif

                {!! Form::hidden('outOfStock',0, ['class'=>'form-control']) !!}
                {{--['item', 'description','status','category_id', 'photo_id'];--}}

            </div><!-- /.box-body -->
            @include('partial.error')
            <div class="box-footer">
                <div class="box-footer">
                    {!! Form::submit('Update Equipments ', ['class'=>'btn btn-info pull-right']) !!}
                </div><!-- /.box-footer -->

            </div>
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div>
    <div class="row">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h1 class="box-title">{{$equipments->item}} History
                            <small>{{$equipments->borrows()->count()}} users</small>
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

                        @foreach($equipments->borrows as $borrow)
                            <tr>
                                <th>{{$borrow->id}}</th>
                                <td><a href="{{route('admin.users.edit', $borrow->borrowedby_id)}}">{{$borrow->borrowedby_id == 0 ? 'no user' :$borrow->borrowedby->name}}</a></td>

                                <td>@foreach($borrow->nonconsumables as $nonconsumables)<span
                                            class="label label-default" id="{{$nonconsumables->id}}"
                                            value="{{$nonconsumables->name}}">{{$nonconsumables->name}}</span>
                                    @endforeach
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
@section('sc')
    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/jszip.min.js') !!}
    {!! Html::script('js/pdfmake.min.js') !!}
    {!! Html::script('js/vfs_fonts.js') !!}
    {!! Html::script('js/buttons.html5.min.js') !!}
    {!! Html::script('js/dataTables.buttons.min.js') !!}
    {!! Html::script('js/jquery.dataTables.min.js') !!}

    <script>
        $(function () {
            var tdate = new Date();
            var dd = tdate.getDate(); //yields day
            var MM = tdate.getMonth(); //yields month
            var yyyy = tdate.getFullYear(); //yields year
            var d = dd + "-" + ( MM + 1) + "-" + yyyy;
            $('#firm_table2').DataTable({
                "paging": true,
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

{{--'name', 'email', 'password','category_id','photo_id', 'is_active',--}}