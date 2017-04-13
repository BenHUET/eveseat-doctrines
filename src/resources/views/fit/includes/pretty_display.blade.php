<div id="pretty_display">

	<ul class="nav nav-pills"> 
		<li role="presentation" class="dropdown active"> 
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
				Fitting <span class="caret"></span> 
			</a>
			<ul class="dropdown-menu"> 
				<li class="active">
					<a href="#fitting_pretty" aria-controls="fitting_pretty" role="tab" data-toggle="tab">Pretty</a>
				</li> 
				<li>
					<a href="#fitting_list" aria-controls="fitting_list" role="tab" data-toggle="tab">List</a>
				</li> 
			</ul> 
		</li>
		<li role="presentation">
			<a href="#cargo" aria-controls="cargo" role="tab" data-toggle="tab">Cargo</a>
		</li> 
		<li role="presentation">
			<a href="#multibuy" aria-controls="multibuy" role="tab" data-toggle="tab">Multibuy</a>
		</li>
		<li role="presentation">
			<a href="#eft" aria-controls="eft" role="tab" data-toggle="tab">EFT</a>
		</li>
	</ul>

	<div class="tab-content">

		<div role="tabpanel" class="tab-pane active" id="fitting_pretty">
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
					@include('doctrines::fit.includes.pretty_display_corner', [
						'outside_div_class' => 'drones', 
						'inside_div_class' => 'drone-icon col-md-3 pull-right',
						'img_class' => 'drone-img',
						'collection' => $fit->drones_sorted
					])
					@include('doctrines::fit.includes.pretty_display_corner', [
						'outside_div_class' => 'implants', 
						'inside_div_class' => 'implant-icon col-md-3 pull-left',
						'img_class' => 'implant-img',
						'collection' => $fit->implants_sorted
					])

				</div>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="fitting_list">
			<div class="well">
				<?php $displayed = array(); ?>
				@foreach ($fit->fitted_sorted as $item)
					@if (!in_array($item->slot, $displayed))
						<span class="slot-separator {{ $item->slot }}">{{ $item->slot }}S</span>
						<?php $displayed[] = $item->slot; ?>
					@endif
					<span class="list-item">
						<img src="http://image.eveonline.com/Type/{{ $item->typeID }}_64.png" class="eve-icon medium-icon" />
						{{ $item->stack_qty }}x {{ $item->typeName }}
					</span>
				@endforeach
			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="cargo">
			<div class="well">
				@foreach ($fit->on_board_sorted as $item)
					<span class="list-item">
						<img src="http://image.eveonline.com/Type/{{ $item->typeID }}_64.png" class="eve-icon medium-icon" />
						{{ $item->stack_qty}}x {{ $item->typeName }}
					</span>
				@endforeach
			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="multibuy">
			<div class="well">
				<div class="row">
					<div class="col-md-10">
						<textarea id="fit-multibuy" class="form-control" readonly rows="15">{{ $fit->multibuy }}</textarea>
					</div>
					<div class="col-md-2">
						<button type="submit" id="copy_multibuy" class="btn btn-info btn-block btn-sm pull-right">{{ trans('doctrines::words.copy') }}</button>
					</div>
				</div>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="eft">
			<div class="well">
				<div class="row">
					<div class="col-md-10">
						<textarea id="fit-eft" class="form-control" readonly rows="15">{{ $fit->eft }}</textarea>
					</div>
					<div class="col-md-2">
						<button type="submit" id="copy_eft" class="btn btn-info btn-block btn-sm pull-right">{{ trans('doctrines::words.copy') }}</button>
					</div>
				</div>
			</div>
		</div>

	</div>



</div>