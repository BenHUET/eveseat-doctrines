@if($fit)
	<div class="box box-info">
@else
	<div class="box box-default">
@endif
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('doctrines::words.settings') }}</h3>
	</div>
	<div class="box-body">
		<form class="form-horizontal">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="name" class="col-md-2 control-label">{{ trans('doctrines::words.category') }}</label>
				<div class="col-md-10">
					<select class="form-control" @if (!$fit) disabled @endif>
						@foreach($categories as $category)
							<option>{{ $category->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</form>
	</div>
</div>