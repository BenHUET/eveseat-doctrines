<div id="pretty_display">

	<div class="bg-circle">

		<img class="ship" src="http://image.eveonline.com/Render/{{ $pretty_display['ship']['id'] }}_512.png" alt="{{ $pretty_display['ship']['name'] }}">

		@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'high'])
		@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'med'])
		@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'low'])
		@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'rig'])

	</div>

</div>