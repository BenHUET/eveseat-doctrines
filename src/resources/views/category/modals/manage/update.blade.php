<div class="modal" id="modal_update">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="text-center">
					<i class="fa fa-pencil"></i> 
					{{ trans('doctrines::words.update') }}
				</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{ route('doctrines.category.update') }}" class="form-horizontal">
					{{ csrf_field() }}

					<input type="hidden" name="id" id="id">

					<label for="name" class="col-md-2 control-label">{{ trans('doctrines::words.name') }}</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('doctrines::placeholders.update.category.name') }}">
					</div>
				</br>
			</div>
			<div class="modal-footer">
					<button type="button " class="btn btn-block" data-dismiss="modal">{{ trans('doctrines::words.cancel') }}</button>
					<button type="submit" class="btn btn-block btn-warning">
						{{ trans('doctrines::actions.update.category.confirm') }}
					</button>
				</form>
			</div>
		</div>
	</div>
</div>