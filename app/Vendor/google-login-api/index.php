<?php
	$google_client_id 		= '881139507359-etn56n15hdo6g7u9rhutrdagellgimf6.apps.googleusercontent.com';
	$google_client_secret 	= '9JZpP1_ZPp9qd825bq43bm09';
	$google_redirect_url 	= 'http://aktively.com/users/gpluslogin'; //path to your script
	$google_developer_key 	= 'AIzaSyCBdXu6lk4-44ubRy5HsSfVIz2qd2bHsn4';


	//include google api files
	require_once 'src/Google_Client.php';
	require_once 'src/contrib/Google_Oauth2Service.php';

	$gClient = new Google_Client();
	$gClient->setApplicationName('Login to Aktively');
	$gClient->setClientId($google_client_id);
	$gClient->setClientSecret($google_client_secret);
	$gClient->setRedirectUri($google_redirect_url);
	$gClient->setDeveloperKey($google_developer_key);

	$google_oauthV2 = new Google_Oauth2Service($gClient);


	$authUrl = $gClient->createAuthUrl();

	echo $authUrl; 
?>

