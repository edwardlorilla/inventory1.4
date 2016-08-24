@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')



				<div class="panel panel-default">
					<div class="panel-heading">Home</div>

					<div class="panel-body">
						{{ trans('adminlte_lang::message.logged') }}
					</div>
				</div>



@endsection
