<?php
set_time_limit(0);

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
require_once '../vendor/autoload.php';
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
class Chat implements MessageComponentInterface {
	protected $clients;
	protected $users;

	public function __construct() {
		$this->clients = new \SplObjectStorage;
		$this->users = [];
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->clients->attach($conn);
	}

	public function onClose(ConnectionInterface $conn) {	
		$key = array_search($conn, $this->users);
		$this->clients->detach($conn);
		unset($this->users[$key]);
	}

	public function onMessage(ConnectionInterface $from,  $data) {
		$from_id = $from->resourceId;
		$data = json_decode($data);
		$type = $data->type;

		switch ($type) {
			case "closeC":
			  $sender = htmlspecialchars($data->sender);
			  $array = $data->data;
			  $c = count($array);

			  for($i=0; $i<$c; $i++) {
			  	if(isset($this->users[$array[$i]])){
			  		$this->users[$array[$i]]->send(json_encode(array("type"=>"alert", "al"=>$sender)));
			  	}
			  }
			break;
			case "notifier":
			$user1 = htmlspecialchars($data->user1);
			$user2 = htmlspecialchars($data->user2);
			if(isset($this->users[$user1])){
				$this->users[$user1]->send(json_encode(array("type"=>$type)));
			}
			if($user1 != $user2){
				if(isset($this->users[$user2])){
					$this->users[$user2]->send(json_encode(array("type"=>$type)));
				}
			}

			  break;
			case "socket":
				$this->users[htmlspecialchars($data->sender)] = $from;
                break;
            case 'like':
            	$unique = htmlspecialchars($data->unique);
            	foreach ($this->users as $client) {
                $client->send(json_encode(array("type"=>$type, "unique"=>$unique)));
        }
            	break;
            case 'dislike':
            	$unique = htmlspecialchars($data->unique);
            	foreach ($this->users as $client) {
                $client->send(json_encode(array("type"=>$type, "unique"=>$unique)));
        }
            	break;
            case 'connected':
            	$sender = htmlspecialchars($data->sender);
            	$pSender = htmlspecialchars($data->pSender);
				$avSender = htmlspecialchars($data->avSender);
				$array = $data->data;

				$k = "";
				$c = count($array);
            	$mk = "<div class='cf1' id='connected,".$sender."' ><div id='randomavatar' style='width: 100%; height: 52px; display: flex;'><div id='randomimage'><a href='profile.php?pseudo=".$pSender."'><span id='avataricon'style='background-image: url(profilesimages/".$avSender.");'></span></a></div><span style='line-height: 52px; margin-left: 10px;'>".$pSender."</span></div></div>";
            	for($i=0; $i<$c; $i++) {
            		$value = $array[$i];
            		if(isset($this->users[$value[0]])){
            			$this->users[$value[0]]->send(json_encode(array("type"=>$type, "newDispo"=>$mk, "newconnextion"=>$sender)));
            			$k = $k . "<div class='cf1' id='connected,".$value[0]."' ><div id='randomavatar' style='width: 100%; height: 52px; display: flex;'><div id='randomimage'><a href='profile.php?pseudo=".$value[1]."'><span id='avataricon'style='background-image: url(profilesimages/".$value[2].");'></span></a></div><span style='line-height: 52px; margin-left: 10px;'>".$value[1]."</span></div></div>";
            		}
            	}
            	$from->send(json_encode(array("type"=>$type, "dispo"=>$k)));
            	break;
            case 'connectedfriendschess':
            $sender = htmlspecialchars($data->sender);
            $array = $data->data;

            $k = "";
            $c = count($array);

            for($i=0; $i<$c; $i++) {
            	$value = $array[$i];
            	if(isset($this->users[$value[0]])){
            		$k = $k . "<div class='cf1' id='ches,".$value[0]."' style='background-color: #2b2626; color: #fff; display: flex;'><div id='randomavatar' class='r_a'><div id='randomimage'><a href='profile.php?pseudo=".$value[1]."'><span id='avataricon' style='background-image: url(profilesimages/".$value[2].");'></span></a></div><span style='line-height: 52px; margin-left: 10px;'>".$value[1]."</span></div><button  id='".$value[0]."' class='inv'>Invite</button><button style='display: none;'  id='".$value[0]."' class='can'>Cancel</button></div>";
            	}
            }
            $from->send(json_encode(array("type"=>$type, "amie"=>$k)));
            	break;
            case 'addPlayer':
				$sender = htmlspecialchars($data->sender);
				$pSender = htmlspecialchars($data->pSender);
				$avSender = htmlspecialchars($data->avSender);
				$array = $data->data;
				
				$c = count($array);
				for($i=0; $i<$c; $i++) {
					if(isset($this->users[$array[$i]])){
						$this->users[$array[$i]]->send(json_encode(array("type"=>$type, "sender"=>$sender, "p"=>$pSender, "av"=>$avSender)));
					}
				}

            	break;
			case 'chat':
				$user_id = htmlspecialchars($data->user_id);
				$chat_msg = htmlspecialchars($data->chat_msg);
				$sender = htmlspecialchars($data->sender);
				$file = htmlspecialchars($data->file);
				$psender = htmlspecialchars($data->psender);

				if($file=='audio'){
					if(isset($this->users[$user_id])){
						$this->users[$user_id]->send(json_encode(array("type"=>$type."Audio","msg"=>$chat_msg, "id"=>$sender, "img"=>$psender)));
					}
					$from->send(json_encode(array("type"=>$type."Audio","msg"=>$chat_msg, "id"=>$sender, "img"=>$psender)));
				}else if($file=='Img'){
					if(isset($this->users[$user_id])){
						$this->users[$user_id]->send(json_encode(array("type"=>$type."Img","msg"=>$chat_msg, "id"=>$sender)));
					}
					$from->send(json_encode(array("type"=>$type."Img","msg"=>$chat_msg, "id"=>$sender)));
				}else if($file=='lien'){
					$ar = explode(",", $user_id);
					$s = count($ar);
					$chat_msg = "post.php?post_id=" . $chat_msg;
					$response_to = "<div class='showm'><div class='s2' style='margin-right: 45%;'><div id='avataricon' style='background-image: url(profilesimages/".$psender.");'></div><a target='_blank' style='color: blue;' href=".$chat_msg.">Post Link</a></div></div>";

					for ($i=0; $i < $s; $i++) { 
						if(isset($this->users[$ar[$i]])){
							$this->users[$ar[$i]]->send(json_encode(array("type"=>$type,"msg"=>$response_to, "id"=>$sender)));
						}
					}

				}else if($file=='textFile'){
					$response_from = "<div class='showm'><div class='s1' style='margin-left: 45%;'><div id='avataricon' style='background-image: url(profilesimages/".$psender.");'></div><a target='_blank' style='color: blue;' href=".$chat_msg.">Text file</a></div></div>";
					$response_to = "<div class='showm'><div class='s2' style='margin-right: 45%;'><div id='avataricon' style='background-image: url(profilesimages/".$psender.");'></div><a target='_blank' style='color: blue;' href=".$chat_msg.">Text file</a></div></div>";
					if(isset($this->users[$user_id])){
						$this->users[$user_id]->send(json_encode(array("type"=>$type,"msg"=>$response_to, "id"=>$sender)));
					}
					$from->send(json_encode(array("type"=>$type,"msg"=>$response_from, "id"=>$sender)));
				}else{
					$response_from = "<div class='showm'><div class='s1' style='margin-left: 45%;'><div id='avataricon' style='background-image: url(profilesimages/".$psender.");'></div>".$chat_msg."</div></div>";
					$response_to = "<div class='showm'><div class='s2' style='margin-right: 45%;'><div id='avataricon' style='background-image: url(profilesimages/".$psender.");'></div>".$chat_msg."</div></div>";

					if(isset($this->users[$user_id])){
						$this->users[$user_id]->send(json_encode(array("type"=>$type,"msg"=>$response_to, "id"=>$sender)));
					}
					$from->send(json_encode(array("type"=>$type,"msg"=>$response_from, "id"=>$sender)));
				}

				break;
				case 'invitation':
					$sender = htmlspecialchars($data->sender);
					$pseudo = htmlspecialchars($data->pseudo);
					$inviter = htmlspecialchars($data->inviter);
					$temps = htmlspecialchars($data->temps);

				if(isset($this->users[$inviter])){
					$this->users[$inviter]->send(json_encode(array("type"=>$type,"pseudo"=>$pseudo, "sender"=>$sender, "temps"=>$temps, "logOut"=>'no')));
				}else{
					$from->send(json_encode(array("type"=>$type,"logOut"=>'out', "inviter"=>$inviter)));
				}
					break;
				case 'takeOf':
					$sender = htmlspecialchars($data->sender);
					$array = $data->data;

					$count = count($array);
					for($i=0; $i<$count; $i++) {
						if(isset($this->users[$array[$i]])){
							$this->users[$array[$i]]->send(json_encode(array("type"=>$type,"idn"=>$sender)));
						}
					}

					break;
				case 'invitationAN':
					$inAN = htmlspecialchars($data->inAN);

					if($inAN=='ok'){
						$sender = htmlspecialchars($data->sender);
						$inviteur = htmlspecialchars($data->inviteur);
						if(isset($this->users[$inviteur])){
							$this->users[$inviteur]->send(json_encode(array("type"=>$type,"an"=>'ok')));
							$from->send(json_encode(array("type"=>$type,"an"=>'ok')));
						}
					}else{
						$da = $data->data;

						$array1 = $da[0];
						$array2= $da[1];
						
						$inviter = htmlspecialchars($array1[0]);
						$sender = htmlspecialchars($array2[0]);
						if(isset($this->users[$inviteur])){
							$this->users[$inviteur]->send(json_encode(array("type"=>$type,"an"=>'no', 'sender'=>$sender)));
							$count = count($array1);
							for ($i=3; $i<$count; $i++) {
								$value = htmlspecialchars($array1[$i]);
								if(isset($this->users[$value])){
									$this->users[$value]->send(json_encode(array("type"=>'addPlayer', "sender"=>$inviter, "p"=>$array1[1], "av"=>$array1[2])));
								}
							}
						}

						$count = count($array2);
						for ($i=3; $i<$count; $i++) {
							$value = htmlspecialchars($array2[$i]);
							if(isset($this->users[$value])){
								$this->users[$value]->send(json_encode(array("type"=>'addPlayer', "sender"=>$sender, "p"=>$array2[1], "av"=>$array2[1])));
							}
						}
					}
					break;
				case 'annuller':
				    $da = $data->data;
				    $array1 = $da[0];
				    $array2= $da[1];

					$inviter = htmlspecialchars($array1[0]);
					$sender = htmlspecialchars($array2[0]);

					if(isset($this->users[$inviter])){
						$this->users[$inviter]->send(json_encode(array("type"=>$type)));
						$count = count($array1);
						for ($i=3; $i<$count; $i++) {
							$value = htmlspecialchars($array1[$i]);
							if(isset($this->users[$value])){
								$this->users[$value]->send(json_encode(array("type"=>'addPlayer', "sender"=>$inviter, "p"=>$array1[1], "av"=>$array1[2])));
							}
						}
				    }
				    $count = count($array2);
				    for ($i=3; $i<$count; $i++) {
				    	$value = htmlspecialchars($array2[$i]);
				    	if(isset($this->users[$value])){
				    		$this->users[$value]->send(json_encode(array("type"=>'addPlayer', "sender"=>$sender, "p"=>$array2[1], "av"=>$array2[1])));
				    	}
				    }
					break;
				case 'chessSocket':
					$this->users[htmlspecialchars($data->user)] = $from;
					break;
				case 'chessEnd':
					$lost = htmlspecialchars($data->lost);
					$sender = htmlspecialchars($data->sender);
					$gegener = htmlspecialchars($data->gegener);

					if(isset($this->users[$gegener])){
						$this->users[$gegener]->send(json_encode(array("type"=>$type, "lose"=>$lost)));
					}
					$from->send(json_encode(array("type"=>$type, "lose"=>$lost)));
				break;
				case 'replay':
				  $ps = htmlspecialchars($data->spseudo);
				  $sender = htmlspecialchars($data->sender);
				  $gegener = htmlspecialchars($data->gegener);
				  if(isset($this->users[$gegener])){
					$this->users[$gegener]->send(json_encode(array("type"=>"chooseplay","ps"=>$ps)));
				  }
				break;
				case 'are_ready':
				  $sender = htmlspecialchars($data->sender);
				  $gegener = htmlspecialchars($data->gegener);
				  if(isset($this->users[$gegener])){
					$this->users[$gegener]->send(json_encode(array("type"=>"let_go")));
				  }
				  $this->users[$sender]->send(json_encode(array("type"=>"let_go")));
				break;
				case 'no_play':
				  $gegener = htmlspecialchars($data->gegener);
				  if(isset($this->users[$gegener])){
					$this->users[$gegener]->send(json_encode(array("type"=>"no_play")));
				  }
				break;
				case 'chessChat':
				$mes = htmlspecialchars($data->chat_msg);
				$sender = htmlspecialchars($data->sender);
				$gegener = htmlspecialchars($data->gegener);

				$response_from = "<div class='showm'><div class='s1' style='margin-left: 45%;'>".$mes."</div></div>";
				$response_to = "<div class='showm'><div class='s2' style='margin-right: 45%;'>".$mes."</div></div>";

				if(isset($this->users[$gegener])){
					$this->users[$gegener]->send(json_encode(array("type"=>$type,"msg"=>$response_to, "id"=>$sender)));
				}
				$from->send(json_encode(array("type"=>$type,"msg"=>$response_from, "id"=>$sender)));

				break;
				case 'chessMove':
					$user = htmlspecialchars($data->user);
					$move = $data->move;
					$gegener = htmlspecialchars($data->gegener);

					if(isset($this->users[$gegener])){
						$this->users[$gegener]->send(json_encode(array("type"=>$type, "move"=>$move)));
					}
				break;
		}
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		$conn->close();
	}
}
$server = IoServer::factory(
	new HttpServer(new WsServer(new Chat())),
	8080
);
$server->run();
?>