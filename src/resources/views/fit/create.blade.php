@extends('web::layouts.grids.12')

@section('title', trans('doctrines::meta.plugin_name') . ' | ' . trans('doctrines::meta.title_create_fit'))
@section('page_header', trans('doctrines::meta.title_create_fit'))

@section('full')

@if($err)
	<div class="callout callout-danger">
		<h4>Error</h4>
		{{ trans('doctrines::notices.error_loading_fit') }} <br/>
		{{ trans('doctrines::words.details') }} : "{{ $err }}"
	</div>
@endif

<div class="row">
	<div class="col-md-3">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{ trans('doctrines::words.import') }} (EFT)</h3>
			</div>
			<form id="form_fit_create_load"  method="POST" action="{{ route('doctrines.fit.indexStorePreview') }}">
				{{ csrf_field() }}
				<div class="box-body">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#fitting_input" aria-controls="fitting_input" role="tab" data-toggle="tab">Fitting</a></li>
						<li role="presentation"><a href="#cargo_input" aria-controls="cargo_input" role="tab" data-toggle="tab">Cargo</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="fitting_input">
							<div class="form-group">
								<textarea class="form-control user-input" spellcheck="false" rows="20" wrap="off" name="eft" placeholder="{{ trans('doctrines::placeholders.create.fit.fiting') }}">@if ($raw_eft){{ $raw_eft }}@endif</textarea>
							</div>
						</div>

						<div role="tabpanel" class="tab-pane" id="cargo_input">
							<div class="form-group">
								<textarea class="form-control user-input" spellcheck="false" rows="20" wrap="off" name="cargo" placeholder="{{ trans('doctrines::placeholders.create.fit.cargo') }}">@if ($raw_cargo){{ $raw_cargo }}@endif</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" id="form_fit_create_load_btn_submit" class="btn btn-default btn-block">{{ trans('doctrines::words.load') }}</button>
				</div>
			</form>
		</div>
	</div>

	<div class="col-md-4">
		@if($fit)
			<div class="box box-info">
		@else
			<div class="box box-default">
		@endif
			<div class="box-header with-border">
				<h3 class="box-title">{{ trans('doctrines::words.settings') }}</h3>
			</div>
			<div class="box-body">
				<p>SETTINGS</p>
			</div>
		</div>
	</div>

	<div class="col-md-5">
		@if($fit)
			<div class="box box-info">
		@else
			<div class="box box-default">
		@endif
			<div class="box-header with-border">
				<h3 class="box-title">{{ trans('doctrines::words.preview') }}</h3>
			</div>
			<div class="box-body">
				@if($fit)
					<h3>{{ $fit->ship->typeName }} | {{ $fit->name }}</h3>
					@include('doctrines::fit.includes.pretty_display', ['fit' => $fit])
				@else
					<i>
						{{ trans('doctrines::notices.no_fit_loaded') }}
					</i>
				@endif
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