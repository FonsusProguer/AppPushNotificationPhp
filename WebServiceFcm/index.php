<?php 


function pushNotification($pTitle, $pSubtitle, $pTokens, $pCustomData, $pServerKey)
{
	/*Valores requeridos para firebase*/
	$dataNotification = array(
	    'notiTitle' => $pTitle, 
		'notiBody' => $pSubtitle, 
		
	    'notiVisible' => "1",
	    'notiDateTime'=>date('Y-m-d H:i:s'),
	    'notiLink' => '', 
	    'notiData'=>json_encode($pCustomData) 
	);

	$fieldsFirebase = array(
		'registration_ids' => $pTokens, 
		// 'notification'=> array notification
	    'data' => $dataNotification,
	    'priority'=> 'high'
	);

	$headers = array('Content-Type: application/json',
    'Authorization:key='.$pServerKey
	);

	// Ejecutar Api de Firebase
	$url = 'https://fcm.googleapis.com/fcm/send';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fieldsFirebase));
	$result = curl_exec($ch);

	if ($result == FALSE){
		echo '<h1>Error</h1>'; 
	    die('Curl failed: ' . curl_error($ch));
	}else{
		echo '<h1>Correcto</h1>';
	}

	curl_close($ch);
}





$serverKey='FFFFFF- SERVER KEY AQUI -PPPPPPP';

$titulo="Fonsus Proguer";
$subtitulo="Video de notificaciones push desde web service PHP";

$tokens = array("FFFFF- TOKENS AQUI -PPPPPP");

$customData = array( 'Nombre' => 'Fonsus', 'Apellido'=>'Proguer' );

pushNotification($titulo, $subtitulo, $tokens, $customData, $serverKey);

?>