<?php 
	require_once('db.php');
	class GoogleAuth{
		protected $client;

		public function __construct(Google_Client $googleClient = null){
			$this->client = $googleClient;
			if($this->client){
				$this->client->setClientId('458450572399-id0hcv3as2cu3g4vdtfs95dacc799ffd.apps.googleusercontent.com');
				$this->client->setClientSecret('8XP3wijyav3SG60KKwjl4j1D');
				$this->client->setRedirectUri('http://localhost:80/tutorialgoogle/index.php');
				$this->client->setScopes('email');
			}
		}

		public function isLoggedIn(){
			return isset($_SESSION["access_token"]);
		}

		public function getAuthUrl(){
			return $this->client->createAuthUrl();
		}

		public function checkRedirectCode(){
			if(isset($_GET["code"])){
				$this->client->authenticate($_GET["code"]);
				$this->setToken($this->client->getAccessToken());
				$payload = $this->getPayload();
				$this->createUser($payload);
				echo "<pre>", print_r($payload), "</pre>";
				return true;
			}
			return false;
		}

		public function setToken($token){
			$_SESSION["access_token"] = $token;
			$this->client->setAccessToken($token);
		}

		public function logout(){
			unset($_SESSION['access_token']);
		}

		public function getPayload(){
			$payload = $this->client->verifyIdToken();
			return $payload;
		}

		public function createUser($payload){
			$db = new DB();
			$conn = $db->get_connection();

			$a=$payload['sub'];
			$b=$payload['email'];
			try{
				$query = "insert into usuario_google(id_google, email) values(?,?)";
				$statement = $conn->prepare($query);
				if($statement === false){
					echo "error";
				}else{
					$statement->bind_param("ss",$a,$b);
					$statement->execute();
				}
				
				
			}catch(Exception $ex){

			}finally{
				$statement->close();
				$conn->close();
			}
		}

	}
?>