<?php
	// include i file esterni.
	require_once "config.php";
	require_once "jsonManager.php";
	require_once "bot_API.php";

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
		processMessage($update["message"]); //chiamo una funzione che elabora il messaggio
	}
	
	function processMessage($message)
	{
        $messsageID = $message["messsage_id"];
        $chatID = $message["chat"]["id"];
        $userID = $message["from"]["id"];
        $firtsName = $message["from"]["first_name"];
        $text = $message["text"];

		if(isset($message["text"]))
		{
			switch($text)
			{
				case "/start":
					apiRequest("sendMessage", array("chat_id" => $chatID, "text" => "Ciao ".$firtsName."! Benvenuto nel nostro bot!"));
					break;
                case "/compleanno":
                    $birthdays = readJSONfile();
                    $today = date('d/m');
                    foreach ($birthdays as $name => $birthday)
                    {
                        if($birthday == $today)
                        {
                            apiRequest("sendMessage", array("chat_id"=>$chatID, "text" => "Buon compleanno a ".$name));
                        }
                    }
				default:
                    apiRequest("sendMessage", array("chat_id"=>$chatID, "text" => "Non è un comando che capisco!"));
			}
		}
		else {
			apiRequest("sendMessage", array("chat_id" => $chatID, "text"=>"Spiacente, supporto solo messaggi di testo."));
		}
	}