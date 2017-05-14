<div class="box box-success">
	<div class="box-header with-border">
		<i class="fa fa-plus"></i>
		<h3 class="box-title">{{ trans('doctrines::words.new') }}</h3>
	</div>
	<div class="box-body">
		<form method="POST" action="{{ route('doctrines.category.store') }}" class="form-horizontal">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="name" class="col-md-2 control-label">{{ trans('doctrines::words.name') }}</label>
				<div class="col-md-8">
					<input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('doctrines::placeholders.create.category.name') }}">
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-block btn-primary">{{ trans('doctrines::words.new') }}</button>
				</div>
			</div>
		</form>
	</div>
</div>