<div class="{{ $outside_div_class }}">
	<?php $items = $collection; ?>
	@for ($row = 0; $row < 4; $row++)
		<div class="row">
			{{-- can't chunk! https://github.com/laravel/framework/issues/6281 --}}
			@for ($i = 0; $i < 4 - $row; $i++)
				<?php $item = $items->pop(); ?>
				@if ($item)
					<a href="https://o.smium.org/db/type/{{ $item->typeID }}" target="_blank">
						<div class="{{ $inside_div_class }}" data-toggle="tooltip" data-placement="top" title="{{ $item->stack_qty }}x {{ $item->typeName }}">
							<img class="{{ $img_class }}" src="http://image.eveonline.com/Type/{{ $item->typeID }}_64.png">
						</div>
					</a>
				@endif
			@endfor
		</div>
	@endfor
</div>