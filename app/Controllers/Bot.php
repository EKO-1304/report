<?php

namespace App\Controllers;

use Modules\Users\Models\ModelUsers;

class Bot extends BaseController
{
	protected $db;

	public function __construct(){
		$this->ModelMaster = new ModelMaster();
		$this->db = \Config\Database::connect();
	}

	public function index()
	{
		$TOKEN = "2103578392:AAGGtZbwZ4w36Vo23LG_bUOrmLz88GdjWAc";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        $usernametelegram = $update["message"]["chat"]["username"];
        
        
        if (strpos($message, "/start") === 0) {
        
            
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Halo, ".$usernametelegram."&parse_mode=HTML");
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=KETIKAN /reg-{username kebunku} - untuk menghubungkan telegram ke kebunku.stekom.ac.id&parse_mode=HTML");
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=CONTOH : /reg-ekohary13&parse_mode=HTML");
            
        
        }elseif (strpos($message, "/reg-") === 0) {
            
            $username = str_replace('/reg-','',$message);            
            
			$dtusers = $this->db->table("users")->select("random,fullname")->where('username', $username)->get()->getRowArray();

			if($dtusers <> null){
				$random = $dtusers["random"];
				$fullname = $dtusers["fullname"];

				$data = array(
					"idchat" => $chatID,
				);
				$status = $this->ModelMaster->dataedit("users",["random"=>$random],$data);

				if ($status) {
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$fullname." Telegram berhasil terdaftar ke kebunku.stekom.ac.id&parse_mode=HTML");
				  }else{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$fullname." Telegram gagal terdaftar ke kebunku.stekom.ac.id&parse_mode=HTML");
				  }
			}else{
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Halo, ".$usernametelegram."&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=WARNING !!! username tidak di temukan, lakukan dengan benar sesuai langkah dibawah ini :");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=KETIKAN /reg-{username kebunku} - untuk menghubungkan telegram ke kebunku.stekom.ac.id&parse_mode=HTML");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=CONTOH : /reg-ekohary13&parse_mode=HTML");
			}
                
        }else{
        
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Halo, ".$usernametelegram."&parse_mode=HTML");
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=KETIKAN /reg-{nomor_telegram} - untuk menghubungkan telegram ke kebunku.stekom.ac.id&parse_mode=HTML");
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=CONTOH : /reg-ekohary13&parse_mode=HTML");
        
        }

	}
}
