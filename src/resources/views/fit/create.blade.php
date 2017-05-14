@extends('web::layouts.grids.12')

@section('title', trans('doctrines::meta.plugin_name') . ' | ' . trans('doctrines::meta.title.fit.create'))
@section('page_header', trans('doctrines::meta.title.fit.create'))

@section('full')

@if($err)
	<div class="callout callout-danger">
		<h4>Error</h4>
		{{ trans('doctrines::notices.error_loading_fit') }} <br/>
		{{ trans('doctrines::words.details') }} : "{{ $err }}"
	</div>
@endif

@if ($categories->count() == 0)
	<i>{{ trans('doctrines::notices.no_category') }}</i>
@else
	<div class="row">
		<div class="col-md-3">
			@include('doctrines::fit.includes.create.import', ['fit' => $fit])
		</div>

		<div class="col-md-4">
			@include('doctrines::fit.includes.create.settings', ['fit' => $fit])
		</div>

		<div class="col-md-5">
			@include('doctrines::fit.includes.create.preview', ['fit' => $fit])
		</div>
	</div>
@endif

@stop

@push('head')
	<link rel="stylesheet" href="{{ asset('web/css/kassie/doctrines/fit.css') }}" />
@endpush

@push('javascript')
	<script src="{{ asset('web/js/kassie/doctrines/fit.js') }}"></script>
@endpush