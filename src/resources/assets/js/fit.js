/* Copy EFT to clipboard */
var toCopy  = document.getElementById('fit-raw');
var btnCopy = document.getElementById('copy');

if (btnCopy != null) {
	btnCopy.addEventListener('click', function(){
		toCopy.select();
		document.execCommand('copy');
		return false;
	});
}

/* Disable "Load" button after submitting */
$('#form_fit_create_load').submit(function (e) {
	$('#form_fit_create_load_btn_submit').attr('disabled', true);
	return true;
});