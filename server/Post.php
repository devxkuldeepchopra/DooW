<?php 

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// use ReallySimpleJWT\Token;

// // Generate a token
// $token = Token::getToken('userIdentifier', 'secret', 'tokenExpiryDateTimeString', 'issuerIdentifier');

// // Validate the token
// $result = Token::validate($token, 'secret');

$model; 

if($data = json_decode(file_get_contents("php://input"))){

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

		if ($action == 'GetPost') {
			$page = $model ? $model->page : $_POST["page"];
			$content = $model ? $model->content : $_POST["content"];
			$randPage = $model ? $model->randPage : $_POST["randPage"];
			$Data = $Post->GetPost($page,$content,$randPage);
			echo json_encode($Data);
		}
		if ($action == 'GetPostAdmin') {
			$Data = $Post->GetPostAdmin();
			echo json_encode($Data);
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
						
						$Data = $Post->InsertPost($_POST['id'],$_POST['postcatid'],$_POST['title'],$_POST['description'],$_POST['mypost'],$_POST['url'],$newFile,$_POST['video'],$_POST['catid']);
						echo json_encode($Data);
					}
				}	
			}
			else{
				$Data = $Post->InsertPost($_POST['id'],$_POST['postcatid'],$_POST['title'],$_POST['description'],$_POST['mypost'],$_POST['url'],$_POST['filename'],$_POST['video'],$_POST['catid']);
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

	}

	

?>