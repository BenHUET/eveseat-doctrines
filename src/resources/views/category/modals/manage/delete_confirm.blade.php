<div class="modal" id="modal_delete_confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="text-center">
					<i class="fa fa-trash"></i> 
					{{ trans('doctrines::actions.delete.category.question') }}
				</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{ route('doctrines.category.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" name="id" id="id">
					<button type="button " class="btn btn-block btn-lg btn-primary" data-dismiss="modal">{{ trans('doctrines::actions.delete.category.cancel') }}</button>
					<button type="submit" class="btn btn-block btn-sm btn-danger">
						{{ trans('doctrines::actions.delete.category.confirm') }}
					</button>
				</form>
			</div>
		</div>
	</div>
</div>