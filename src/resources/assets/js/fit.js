/* Copy EFT to clipboard */
var eft  = document.getElementById('fit-eft');
var btnCopyEFT = document.getElementById('copy_eft');

if (btnCopyEFT != null) {
	btnCopyEFT.addEventListener('click', function(){
		eft.select();
		document.execCommand('copy');
		return false;
	});
}

/* Copy Multibuy to clipboard */
var multibuy  = document.getElementById('fit-multibuy');
var btnCopyMultibuy = document.getElementById('copy_multibuy');

if (btnCopyMultibuy != null) {
	btnCopyMultibuy.addEventListener('click', function(){
		multibuy.select();
		document.execCommand('copy');
		return false;
	});
}

/* Disable "Load" button after submitting */
$('#form_fit_create_load').submit(function (e) {
	$('#form_fit_create_load_btn_submit').attr('disabled', true);
	return true;
});