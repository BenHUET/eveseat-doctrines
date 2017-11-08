<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('doctrines::words.import') }} (EFT)</h3>
	</div>
	<form id="form_fit_create_load" method="POST" action="{{ route('doctrines.fit.indexStorePreview') }}">
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