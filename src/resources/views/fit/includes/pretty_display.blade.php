<div id="pretty_display">

	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#fitting" aria-controls="fitting" role="tab" data-toggle="tab">Fitting</a></li>
		<li role="presentation"><a href="#drones" aria-controls="drones" role="tab" data-toggle="tab">Drones</a></li>
		<li role="presentation"><a href="#cargo" aria-controls="cargo" role="tab" data-toggle="tab">Cargo</a></li>
		<li role="presentation"><a href="#eft" aria-controls="eft" role="tab" data-toggle="tab">EFT</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="fitting">
			<div class="well">
				<div class="bg-circle">

					<img class="ship" src="http://image.eveonline.com/Render/{{ $fit->ship->typeID }}_512.png">

					@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'high'])
					@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'med'])
					@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'low'])
					@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'rig'])
					@if ($fit->layout->get('subsystem') > 0)
						@include('doctrines::fit.includes.pretty_display_rack', ['rack' => 'subsystem'])
					@endif

				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="drones">
			<div class="well">
				...
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="cargo">
			<div class="well">
				...
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="eft">

		</div>
	</div>



</div>