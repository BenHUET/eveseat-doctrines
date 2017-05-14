<span class="clickable" 
	data-toggle="tooltip" 
	data-placement="top" 
	title="{{ trans('doctrines::words.update') }}">

	<i class="fa fa-pencil"
	data-toggle="modal"
	data-id="{{ $category->id }}"
	data-name="{{ $category->name }}"
	data-target="#modal_update"></i>

</span>
&nbsp;
<span class="clickable" 
	data-toggle="tooltip" 
	data-placement="top" 
	title="{{ trans('doctrines::words.delete') }}">

	<i class="fa fa-trash"
	data-toggle="modal"
	data-id="{{ $category->id }}"
	data-target="#modal_delete_confirm"></i>

</span>