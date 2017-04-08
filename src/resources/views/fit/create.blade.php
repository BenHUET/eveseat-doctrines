@extends('web::layouts.grids.12')

@section('title', trans('doctrines::meta.plugin_name') . ' | ' . trans('doctrines::meta.title_create_fit'))
@section('page_header', trans('doctrines::meta.title_create_fit'))

@section('full')

<div class="row">
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{ trans('doctrines::words.import') }} (EFT)</h3>
			</div>
			<div class="box-body">
				<form id="form_fit_create_load"  method="POST" action="{{ route('doctrines.fit.indexStorePreview') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<textarea class="form-control" spellcheck="false" rows="25" name="eft"></textarea>
					</div>
					<button type="submit" id="form_fit_create_load_btn_submit" class="btn btn-default btn-block">{{ trans('doctrines::words.load') }}</button>
				</form>
			</div>
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
					@if($fit)
						<h3>{{ $fit->ship->typeName }} | {{ $fit->name }}</h3>
						@include('doctrines::fit.includes.pretty_display', ['fit' => $fit])
					@else
						<i>
							{{ trans('doctrines::notices.no_fit_loaded') }}
						</i>
					@endif
				@endif
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{ trans('doctrines::words.settings') }}</h3>
			</div>
			<div class="box-body">
				<p>SETTINGS</p>
			</div>
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