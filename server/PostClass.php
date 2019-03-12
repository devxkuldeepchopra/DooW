<?php

class Post 
{
	private $conn;
	public function __construct($conn) {
		$this->conn = $conn;
	}
	// pubic function GenerateToken() {

	// }
	public function GetPost($page,$content,$rendPage) {
		$limit = 0;
		$upto = $content;
		$data = array();
		if($page > 1){
			$limit = $page*$upto-$upto;
		}
		if($rendPage){
			$limit = $rendPage;
		}		
		$query = $this->conn->prepare("SELECT `Id`,`Title`,`Url`,`ImageUrl`, `View` FROM `post` WHERE `IsActive` = 1 AND `isPage`=0 ORDER BY post.Id DESC LIMIT $limit,$upto");			
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$data['post'] = $result;	
        return $data;

	}

	public function GetPostAdmin() {
		$query = $this->conn->prepare("SELECT * FROM `post` ORDER BY post.Id DESC");			
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$data['post'] = $result;	
        return $data;
	}

	public function ActivatePost($id,$active) {
		$activate = (int) $active == 1 ? 0 : 1;
		$id = (int) $id;
		$query = $this->conn->prepare("UPDATE `post` SET `IsActive` = :isactive WHERE `post`.`Id` = :id");	

			$query->bindParam(':isactive',$activate);
			$query->bindParam(':id',$id);
		$query->execute();		
        return $this->conn->lastInsertId();
	}

	public function GetPostByPath($url) {		
		//$query = $this->conn->prepare("SELECT * FROM `post` LEFT OUTER JOIN `postvideo` ON `post`.`Id` = `postvideo`.`PostId` WHERE `post`.`Url` = :url");	
		$query = $this->conn->prepare("SELECT post.Id AS PostId, Title,Description,Post,Url,ImageUrl,PostOn,post.View,IsActive, postcategory.Id As PostCatId, category.Id As CatId, category.Name AS CatName, category.Icon AS CatIcon FROM ((`post` LEFT OUTER JOIN `postcategory` ON `post`.`Id` = `postcategory`.`PostId`)LEFT OUTER JOIN category ON postcategory.CateogyId = category.Id) WHERE `post`.`Url` = :url AND `post`.`IsActive` = 1  ORDER BY post.Id DESC ");	
		$query->bindParam(':url', $url);
		$query->execute();		
		$result = $query->fetchAll(PDO::FETCH_ASSOC);	
        return $result;
	}

	public function InsertPost($id,$postCatid,$title,$description,$post,$url,$ImageUrl,$catid) {
		$stmt1;
		$catPost;
        $postId;
		if($id != "null" && $id){
			$id = (int) $id;
			$stmt1 = $this->conn->prepare("UPDATE `post` SET `Title` = :title, `Description` = :description, `Post` = :post, `Url` = :url, `ImageUrl` = :imageUrl WHERE `post`.`Id` = :id");			
			$stmt1->bindParam(':id', $id);
			// if($video)
			// {
			// 	$stmt2 = $this->conn->prepare("UPDATE `postvideo` SET `Video` = :video WHERE `postvideo`.`Id` = :id;");	
			// 	$stmt2->bindParam(':id', $id);
			// 	$stmt2->bindParam(':video', $video);	
			// }
		}
		else{
			$stmt1 = $this->conn->prepare("INSERT INTO `post` (`Title`, `Description`, `Post`, `Url`, `ImageUrl`) VALUES (:title, :description, :post, :url, :imageUrl)");
			// if($video)
			// {
			// 	$stmt2 = $this->conn->prepare("INSERT INTO `postvideo` (`PostId`, `Video`) VALUES (LAST_INSERT_ID(), :video);");
			// 	$stmt2->bindParam(':video', $video);	
			// }
		}
		$stmt1->bindParam(':title', $title);
		$stmt1->bindParam(':description', $description);
		$stmt1->bindParam(':post', $post);
		$stmt1->bindParam(':url', $url);
		$stmt1->bindParam(':imageUrl', $ImageUrl);		
		$stmt1->execute();
		$postId = $this->conn->lastInsertId();
		$postReturn = $postId;
		// $stmt2->execute();			
		if($postCatid != "null" && $postCatid || $catid != "null" && $catid) 
		{
			if($postCatid != "null" && $postCatid)
			{
				$postCatid = (int) $postCatid;
				$catPost = $this->conn->prepare("UPDATE  `postcategory` SET `CateogyId` = :catid WHERE `postcategory`.PostId = :id;");
				$catPost->bindParam(':id', $id);			
			}
			else if(catid != "null" && $catid)
			{
				$postId = $postId == 0 ? $id : $postId; 
				$catPost = $this->conn->prepare("INSERT INTO `postcategory` (`PostId`, `CateogyId`) VALUES (:postid, :catid);");
				$catPost->bindParam(':postid', $postId);
			}	
			$catPost->bindParam(':catid', $catid);
			$catPost->execute();	 
			//return  $this->conn->lastInsertId();	
		}
		return $postReturn;
	}

	public function UpdatePost(){}

	public function DeletePost($id) {
		$query = $this->conn->prepare("DELETE FROM `postvideo` WHERE `PostId`= :id");
		$query->bindParam(':id', $id);
		$query->execute();
		$query = $this->conn->prepare("DELETE FROM `postcategory` WHERE `PostId`= :id");
		$query->bindParam(':id', $id);
		$query->execute();
		$query = $this->conn->prepare("DELETE FROM `post` WHERE `Id`= :id");
		$query->bindParam(':id', $id);
		$query->execute();
		$count = $query->rowCount();
		return $count;

	}

	public function GetPostById() {}

	public function PostPagination() {
		$query = $this->conn->prepare("SELECT COUNT(*) as total FROM `post` WHERE `IsActive` = 1 ");
		$query->execute();
		$count = $query->fetchAll(PDO::FETCH_ASSOC);
		$data = $count;
		return $data;
	}

	public function ImageUpload($image) {
		$query = $this->conn->prepare("INSERT INTO `post` (`ImageUrl`) VALUES (:ImageUrl);");
		$query->bindParam(':ImageUrl', $image);
		$query->execute();
		return  $this->conn->lastInsertId();	

	}
	
	public function AddView($view,$id) {
		$query = $this->conn->prepare("UPDATE `post` SET `View` = :view WHERE `post`.`Id` = :id;");
		$query->bindParam(':view',$view);
		$query->bindParam(':id',$id);
		$query->execute();
		return  $this->conn->lastInsertId();	
	}

	public function Search($sQuery)	{
		$search = explode(' ' , $sQuery.trim());
		$sizeS = sizeof($search);
		$qs = "SELECT `Id`,`Title`,`Url`,`ImageUrl`, `View` FROM `post` WHERE (";
		$i=0;
		$sArr = array();
		foreach($search as $s)
		{
			$or = " OR ";
			if(($sizeS-1) == $i )
			{
				$or = ""; 
			}
			$s = strtolower($s);
			if(	$s && $s != "to"
				&& $s != "of"
				&& $s != "in"
				&& $s != "as"
				&& $s != "at"
				&& $s != "this"
				&& $s != "that"
				&& $s != "have"
				&& $s != "we"
				&& $s != "you"
				&& $s != "they"
				&& $s != "are"
				&& $s != "will"
				&& $s != "can"
				&& $s != "should"
				&& $s != "ll"
				&& $s != "has"
				&& $s != "am"
				&& $s != "the"
				&& $s != "and"
                && strlen($s) > 1				
			)
			{
				$qs.= "`Title` LIKE ?".$or;
				$sPush = "%".$s."%";
				array_push($sArr,$sPush);
			}
			else
			{
				$qs.= "`Title` LIKE ?".$or;
				$sPush = "";
				array_push($sArr,$sPush);
			}
			$i++;
		} 
        array_push($sArr,0);
		$qs.=") AND IsActive NOT LIKE ?";
		$query= $this->conn->prepare($qs); 
		$query->execute($sArr);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);	
        return $result;
	}

	public function GetCategory() {	
		$query = $this->conn->prepare("SELECT * FROM `category`");			
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
	}

	public function GetCategoryById($id) {		
		try {
			$query = $this->conn->prepare("SELECT * FROM `category` WHERE `Id` = :id");	
			$query->bindParam(':id', $id);
			$query->execute();		
			$result = $query->fetchAll(PDO::FETCH_ASSOC);	
			return $result;
		}
		catch(Exception $e){
			return $e->getMessage();
		}    
	}

	public function InsertCategory($id,$cname,$icon) {	
		try {
			$stmt1;
			if($id != "null" && $id){
				$id = (int) $id;
				$stmt1 = $this->conn->prepare("UPDATE `category` SET `Name` = :cname, `Icon` = :icon WHERE `category`.`Id` = :id");			
				$stmt1->bindParam(':id', $id);
			}
			else{
				$stmt1 = $this->conn->prepare("INSERT INTO `category` ( `Name`, `Icon`) VALUES (:cname, :icon);");
			}			
			$stmt1->bindParam(':cname', $cname);
			$stmt1->bindParam(':icon', $icon);
			$stmt1->execute();
			return  $this->conn->lastInsertId();	
		}	
		catch(Exception $ex) {
			return $e->getMessage();
		}
		
	}

	public function Updatecategory(){}

	public function DeleteCategoryById($id) {
		try {
			$query = $this->conn->prepare("DELETE FROM `postcategory` WHERE `postcategory`.`CateogyId` = :id");
			$query->bindParam(':id', $id);
			$query->execute();
			$query = $this->conn->prepare("DELETE FROM `category` WHERE `Id`= :id");
			$query->bindParam(':id', $id);
			$query->execute();
			$count = $query->rowCount();
			return $count;
		}
		catch(Exception $ex) {
			return $ex.getMessage();
		}
	}
	public function GetPostByCategoryName($catName) {		
		//$query = $this->conn->prepare("SELECT * FROM `post` LEFT OUTER JOIN `postvideo` ON `post`.`Id` = `postvideo`.`PostId` WHERE `post`.`Url` = :url");	
		$query = $this->conn->prepare("SELECT post.Id AS PostId, Title,Description,Post,Url,ImageUrl,PostOn,post.View,IsActive, postcategory.Id As PostCatId, category.Id As CatId, category.Name AS CatName, category.Icon AS CatIcon FROM ((`post` LEFT OUTER JOIN `postcategory` ON `post`.`Id` = `postcategory`.`PostId`)LEFT OUTER JOIN category ON postcategory.CateogyId = category.Id) WHERE `category`.`Name` = :catname AND `post`.`IsActive` = 1  ORDER BY post.Id DESC");	
		$query->bindParam(':catname', $catName);
		$query->execute();		
		$result = $query->fetchAll(PDO::FETCH_ASSOC);	
        return $result;
	}
	public function GetBlogRandom(){
		$countQ = $this->conn->prepare("SELECT COUNT(*) as total FROM `blog`");	
		$countQ->execute();		
		$count = $countQ->fetchAll(PDO::FETCH_ASSOC);	
		$id = rand(1, $count[0]['total']);
		$query = $this->conn->prepare("SELECT * FROM `blog` WHERE blogid = :blogid");	
		$query->bindParam(':blogid', $id);
		$query->execute();		
		$result = $query->fetchAll(PDO::FETCH_ASSOC);	
        return $result;
	}
}
?>