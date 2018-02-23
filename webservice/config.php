<?php

define('SITE_URL','http://107.170.152.166/twop/');

function getConnection() {

	$dbhost="localhost";

	$dbuser="root";

	$dbpass="Host@123456";

	$dbname="twop";

	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $dbh;

}



?>