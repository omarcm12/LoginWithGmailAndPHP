<?php 
	
	require_once('vendor/autoload.php');
	require_once('app/clases/google_auth.php');
	require_once('app/init.php');

	$googleClient = new Google_Client();
	$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
    $googleClient->setHttpClient($guzzleClient);
	$auth = new GoogleAuth($googleClient); 
//	$auth->checkRedirectCode()

	if($auth->checkRedirectCode()){
		//die($_GET['code']);
		header('Location: index.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>login with php</title>
</head>
<body>
	<?php if(!$auth->isLoggedIn()): ?>
		<a href="<?php echo $auth->getAuthUrl(); ?>">iniciar session</a>
	<?php else: ?>
		Bienvenido... <a href="logout.php">Cerrar sesion</a>
	<?php endif; ?>
</body>
</html>