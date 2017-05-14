<div class="box box-warning">
	<div class="box-header with-border">
		<i class="fa fa-pencil"></i>
		<h3 class="box-title">{{ trans('doctrines::words.edit') }}</h3>
	</div>
	<div class="box-body">
		@if ($categories->count() > 0)
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>{{ trans('doctrines::words.name') }}</th>
						<th class="th-fit">{{ trans('doctrines::words.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<td>{{ $category->name }}</td>
							<td>
								@include('doctrines::category.includes.manage.actions')
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<i>{{ trans('doctrines::notices.no_category_to_display') }}</i>
		@endif
	</div>
</div>