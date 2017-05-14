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
			@include('doctrines::fit.includes.pretty_display.index', ['fit' => $fit])
		@else
			<i>
				{{ trans('doctrines::notices.no_fit_loaded') }}
			</i>
		@endif
	</div>
</div>