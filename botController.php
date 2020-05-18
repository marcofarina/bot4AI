<?php
	// include i file esterni.
	require_once "config.php";
	require_once "jsonManager.php";
	
	$jsonPath = "birthday.json";
	$content = file_get_contents("php://input"); // legge il json inviato dal server Telegram
	$update = json_decode($content, true); // true abilita la conversione in array associativo
	
	if(!$update) // verifica che il decode sia andato a buon fine
	{
		// questo non deve mai capitare.
		exit;
	}
	
	if(isset($update["message"])) //se all'interno dell'update che è arrivato dal server Telegram c'è un campo messaggio
	{
		processMessage($update["message"]); //chiamo una funzione che elabora il messagio
	}
	
	function processMessage($message)
	{
		if(isset($message["text"]))
		{
			$messsageID = $message["messsage_id"];
			$chatID = $message["chat"]["id"];
			$userID = $message["from"]["id"];
			$userName = $message["from"]["first_name"];
			$text = $message["text"];
			
			switch($text)
			{
				case "/start":
					// TODO rispondere allo start
					break;
				default:
					// TODO gestire il default
			}
		}
		else {
			// TODO scrivere all'utente che gestiamo soltanto i messaggi testuali
		}
	}
?>