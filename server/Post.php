<?php 
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$model; 
	if($data = json_decode(file_get_contents("php://input"))) {
		$model = $data;
	}

	require_once('PostClass.php');
	include 'conn.php';
	$Post = new Post($conn);
	$action="";

	if (isset($model)) {
		$action=$model->action;
	}
	if (isset($_POST["action"])) {
		$action=$_POST["action"];
	}
	if (isset($_GET['action'])) { 
		$action = $_GET['action']; 
	}

	if($action)
	{		
		if($action == 'token') {	
			$username = $model ? $model->username : $_POST["username"];
			$password = $model ? $model->password : $_POST["password"];
			if (md5($password) == "4e5c44c32a2ccd77d089c9006299d62b" && md5($username) == "5a8a322c63333a78f40c03ec5a0205de") {
				//$_SESSION['nwstrp'] = "4e5c44c32a2ccd77d089c9006299d62b";  
				$token = generateRandomString(50,md5($password));
				echo json_encode($token);
			}
			else {
			}
		}

		if ($action == 'GetPost') {
			$page = $model ? $model->page : $_POST["page"];
			$content = $model ? $model->content : $_POST["content"];
			$randPage = $model ? $model->randPage : $_POST["randPage"];
			$Data = $Post->GetPost($page,$content,$randPage);
			echo json_encode($Data);
		}

		if ($action == 'GetPostAdmin') {
			try {
				isAuthorized();
					$Data = $Post->GetPostAdmin();
					echo json_encode($Data);
			}
			catch (Exception $e){
				echo json_encode($e.getMessage());
			}
			
			
		}

		if ($action == 'ActivatePost') {
                        $activate= $model ? $model->activate: $_POST["activate"];
                        $id = $model ? $model->id: $_POST["id"];
			$Data = $Post->ActivatePost($id,$activate);
			echo json_encode($Data);
		}

		if ($action == 'SearchPost') {
			$search = $model ? $model->search : $_POST["search"];
			if(!$search){return false;}
			$Data = $Post->Search($search);
			echo json_encode($Data);
		}

		if ($action == 'GetPostByUrl') {
			$url = $model ? $model->url : $_POST["url"];
			$Data = $Post->GetPostByPath($url);
			echo json_encode($Data);

		}

		if ($action == 'InsertPost') {
			
			if(isset($_FILES['file'])) {
				if ( $_FILES['file']['error'] > 0 ) {
					$Data  = $_FILES['file']['error'];
					echo json_encode($Data);
				}
				else {
					$path = '../web/assets/images/uploads/';  //server path
					//$path = '../web/src/assets/images/uploads/';  //local path
			   		$d =	date("Y-m-d-h-i-s");
			   		$newFile = $_POST['filename'].$d.".".$_POST['extension'];
					if(move_uploaded_file($_FILES['file']['tmp_name'], $path . $newFile))
					{
						
						$Data = $Post->InsertPost($_POST['id'],$_POST['postcatid'],$_POST['title'],$_POST['description'],$_POST['mypost'],$_POST['url'],$newFile,$_POST['catid']);
						echo json_encode($Data);
					}
				}	
			}
			else{
				$Data = $Post->InsertPost($_POST['id'],$_POST['postcatid'],$_POST['title'],$_POST['description'],$_POST['mypost'],$_POST['url'],$_POST['filename'],$_POST['catid']);
				echo json_encode($Data);
			}

		}

		if ($action == 'UpdatePost') {

			$Data = $Post->UpdatePost();

			echo json_encode($Data);

		}

		if ($action == 'GetPostById') {

			$Data = $Post->GetPostById();

			echo json_encode($Data);

		}

		if ($action == 'DeletePost') {
			$Data = $Post->DeletePost($model->id);
			echo json_encode($Data);
		}

		if ($action == 'PostPagination') {
			$Data = $Post->PostPagination();
			echo json_encode($Data);
		}

		if ($action == 'GetCategory') {
			$Data = $Post->GetCategory();
			echo json_encode($Data);
		}
		
		if ($action == 'InsertCategory') {
			if(isset($_FILES['file'])) {
				if ( $_FILES['file']['error'] > 0 ) {
					$Data  = $_FILES['file']['error'];
					echo json_encode($Data);
				}
				else {
					$path = '../web/assets/images/icon/';  //server path
					//$path = '../web/src/assets/images/uploads/';  //local path
			   		$d =	date("Y-m-d-h-i-s");
			   		$newFile = $_POST['filename'].$d.".".$_POST['extension'];
					if(move_uploaded_file($_FILES['file']['tmp_name'], $path . $newFile))
					{
						$Data = $Post->InsertCategory($_POST['id'],$_POST['title'],$newFile);
						echo json_encode($Data);
					}
				}	
			}
			else{
				$Data = $Post->InsertCategory($_POST['id'],$_POST['title'],$_POST['icon']);
				echo json_encode($Data);
			}
		}

		if ($action == 'GetCategoryById') {
			$id = $model ? $model->id : $_POST['id'];
			$Data = $Post->GetCategoryById($id);
			echo json_encode($Data);
		}

		if ($action == 'DeleteCategory') {
			$id = $model ? $model->id : $_POST['id'];
			$Data = $Post->DeleteCategoryById($id);
			echo json_encode($Data);
		}
	}

	
function generateRandomString($length = 50,$nwstrp) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
	$randomString = '';
	$saltNumber = 5;
    for ($i = 0; $i < $length; $i++) {
		if($i == 25){
			$saltNumber = rand(0, $charactersLength - 1);
		}
        $randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	$strFirst = substr($randomString, 0, $saltNumber);
	$strLast = substr($randomString, $saltNumber);
	$newString = $strFirst.$nwstrp.$strLast;
	 //. $str_to_insert . "hello".;
    return $newString;
}

function getHeaders() {
	$headers="";
	foreach (getallheaders() as $name => $value) {
		$headers .=  "{ $name: $valuen },";
	}
	return $headers;
}

function GetAuthorized() {
	foreach (getallheaders() as $name => $value) {
		if($name == "Authorization") {
			return $value;
		}
	}
}

function isAuthorized()
{
	$authCode = GetAuthorized();
	$key = "4e5c44c32a2ccd77d089c9006299d62b";
	if($authCode){
		$isPosAuth = strpos($authCode, $key);
		if($isPosAuth !== false) {
			http_response_code(201);
		}
		else {
			header("HTTP/1.1 401 Unauthorized");
			exit;
		}
	}
	else {
		header("HTTP/1.1 401 Unauthorized");
		exit;
	}
	
}


?>