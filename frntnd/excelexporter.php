<?php
	
	header( "Content-type: application/vnd.ms-excel; name=’excel’" );
	header( "Content-Disposition: attachment; filename='sanangel_empleados.xls'");
	//" + $_REQUEST[ 'filename' ] + "'" );
	header( "Pragma: no-cache" );
	header( "Expires: 0" );

	$data = $_REQUEST[ 'data' ];
	$table = iconv( "UTF-8", "ISO-8859-1//IGNORE", $data );
	//echo ini_Get('post_max_size' );
	echo $table;

?>