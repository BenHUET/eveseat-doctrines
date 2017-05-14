$('#modal_delete_confirm').on('show.bs.modal', function(e) {
	var id = $(e.relatedTarget).data('id');
	$(e.currentTarget).find('input[name="id"]').val(id);
});

$('#modal_update').on('show.bs.modal', function(e) {
	var id = $(e.relatedTarget).data('id');
	var name = $(e.relatedTarget).data('name');

	$(e.currentTarget).find('input[name="id"]').val(id);
	$(e.currentTarget).find('input[name="name"]').val(name);
});