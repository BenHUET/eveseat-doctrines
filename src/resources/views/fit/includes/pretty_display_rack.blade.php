<?php $i = 0 ?>
@foreach($pretty_display['items'] as $item)
	@if($item['type'] == 'module' && $item['slot'] == $rack && $i < $pretty_display['ship']['layout'][$rack])
		<div class="item {{ $rack }} {{ $rack . ($i + 1) }}" data-toggle="tooltip" data-placement="top" title="{{ $item['module']['name'] }}">
			<img class="fitted" src="http://image.eveonline.com/Type/{{ $item['module']['id'] }}_64.png" >
		</div>
		<?php $i++ ?>
	@endif
@endforeach

@for ($j = $i; $j < $pretty_display['ship']['layout'][$rack]; $j++)
	<div class="item {{ $rack }} {{ $rack . ($j + 1) }} empty"></div>
@endfor