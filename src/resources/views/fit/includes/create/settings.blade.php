@if($fit)
	<div class="box box-info">
@else
	<div class="box box-default">
@endif
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('doctrines::words.settings') }}</h3>
	</div>
	<div class="box-body">
		<form class="form-horizontal" method="POST" action="{{ route('doctrines.fit.indexStore') }}">
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
			<div class="form-group">
				<label for="comment" class="col-md-2 control-label">{{ trans('doctrines::words.comment') }}</label>
				<div class="col-md-10">
					<textarea class="form-control" name="comment" id="comment" rows="8" placeholder="{{ trans('doctrines::placeholders.create.fit.comment') }}" @if (!$fit) disabled @endif></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<button type="submit" class="btn btn-block btn-primary" @if (!$fit) disabled @endif>
						{{ trans('doctrines::words.submit') }}
					</button>
				</div>
			</div>
		</form>
	</div>
</div>