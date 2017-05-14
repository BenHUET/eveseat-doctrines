<?php $fitted_count = 0 ?>
@foreach ($fit->fitted as $item)
	@if($item->slot == $rack)
		@for ($qty = 0; $qty < $item->pivot->qty; $qty++)
			@if ($fitted_count < $fit->layout->get($rack))
				<div class="item {{ $rack }} {{ $rack . ($fitted_count + 1) }}" data-toggle="tooltip" data-placement="top" title="{{ $item->typeName }}">
					<img class="fitted" src="http://image.eveonline.com/Type/{{ $item->typeID }}_64.png" >
				</div>
				<?php $fitted_count++ ?>
			@endif
		@endfor
	@endif
@endforeach

@for ($empty_slot = $fitted_count; $empty_slot < $fit->layout->get($rack); $empty_slot++)
	<div class="item {{ $rack }} {{ $rack . ($empty_slot + 1) }} empty"></div>
@endfor