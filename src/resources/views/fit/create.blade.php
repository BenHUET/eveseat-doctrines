@extends('web::layouts.grids.12')

@section('title', trans('doctrines::meta.plugin_name') . ' | ' . trans('doctrines::meta.title_create_fit'))
@section('page_header', trans('doctrines::meta.title_create_fit'))

@section('full')

<div class="col-md-7">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">{{ trans('doctrines::words.import') }} (EFT)</h3>
		</div>
		<form id="form_fit_create_load"  method="POST" action="{{ route('doctrines.fit.indexStorePreview') }}">
			<div class="box-body">
				{{ csrf_field() }}
				<div class="form-group">
					<textarea class="form-control" spellcheck="false" rows="25" name="eft">@if($fit_raw){{ $fit_raw }}@endif</textarea>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-info btn-lg btn-block">{{ trans('doctrines::words.load') }}</button>
			</div>
		</form>
	</div>
</div>

<div class="col-md-5">
	<div id="box-preview" class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">{{ trans('doctrines::words.preview') }}</h3>
		</div>
		<div class="box-body">
			@if($err)
				<div class="alert alert-danger">
					{{ trans('doctrines::notices.error_loading_fit') }} <br/>
					{{ trans('doctrines::words.details') }} : "{{ $err }}"
				</div>
			@else
				@if($pretty_display)
					<h3>{{ $pretty_display['ship']['name'] }} | {{ $pretty_display['title'] }}</h3>
					@include('doctrines::fit.includes.pretty_display', ['pretty' => $pretty_display])
				@else
					<i>
						{{ trans('doctrines::notices.no_fit_loaded') }}
					</i>
				@endif
			@endif
		</div>
	</div>

	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">{{ trans('doctrines::words.settings') }}</h3>
		</div>
		<div class="box-body">
			<p>SETTINGS</p>
		</div>
	</div>
</div>

@stop

@push('head')
	<link rel="stylesheet" href="{{ asset('web/css/kassie/doctrines/fit.css') }}" />
@endpush

@push('javascript')
	<script src="{{ asset('web/js/kassie/doctrines/fit.js') }}"></script>
@endpush