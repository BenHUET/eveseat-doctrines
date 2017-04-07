var toCopy  = document.getElementById( 'fit-raw' ),
    btnCopy = document.getElementById( 'copy' );

btnCopy.addEventListener( 'click', function(){
	toCopy.select();
	document.execCommand( 'copy' );
	return false;
} );