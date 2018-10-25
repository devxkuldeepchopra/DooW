<?php

class Post 

{

	private $conn;

	public function __construct($conn) 
	{
		$this->conn = $conn;
	}

	public function GetPost($page,$content,$rendPage)
	{
		$limit = 0;
		$upto = $content;
		$data = array();
		if($page > 1){
			$limit = $page*$upto-$upto;
		}
		if($rendPage){
			$limit = $rendPage;
		}		
		$query = $this->conn->prepare("SELECT `Id`,`Title`,`Url`,`ImageUrl`, `View` FROM `post` WHERE `IsActive` = 1 ORDER BY post.Id DESC LIMIT $limit,$upto");			
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$data['post'] = $result;	
        return $data;

	}
	public function GetPostAdmin()
	{
		$query = $this->conn->prepare("SELECT * FROM `post`");			
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$data['post'] = $result;	
        return $data;
	}
	public function ActivatePost($id,$active)
	{
		$activate = (int) $active == 1 ? 0 : 1;
		$id = (int) $id;
		$query = $this->conn->prepare("UPDATE `post` SET `IsActive` = :isactive WHERE `post`.`Id` = :id");	

			$query->bindParam(':isactive',$activate);
			$query->bindParam(':id',$id);
		$query->execute();		
        return $this->conn->lastInsertId();
	}

	public function GetPostByPath($url){		
		//$query = $this->conn->prepare("SELECT * FROM `post` LEFT OUTER JOIN `postvideo` ON `post`.`Id` = `postvideo`.`PostId` WHERE `post`.`Url` = :url");	
		$query = $this->conn->prepare("SELECT post.Id AS PostId, Title,Description,Post,Url,ImageUrl,PostOn,post.View,IsActive,Video, postcategory.Id As PostCatId, category.Id As CatId, category.Name AS CatName, category.Icon AS CatIcon FROM (((`post` LEFT OUTER JOIN `postcategory` ON `post`.`Id` = `postcategory`.`PostId`)LEFT OUTER JOIN postvideo ON postvideo.PostId = post.Id)LEFT OUTER JOIN category ON postcategory.CateogyId = category.Id) WHERE `post`.`Url` = :url");	
		$query->bindParam(':url', $url);
		$query->execute();		
		$result = $query->fetchAll(PDO::FETCH_ASSOC);	
        return $result;
	}

	public function InsertPost($id,$postCatid,$title,$description,$post,$url,$ImageUrl,$video,$catid){
		$stmt1;
		$catPost;
        $postId;
		if($id != "null" && $id){
			$id = (int) $id;
			$stmt1 = $this->conn->prepare("UPDATE `post` SET `Title` = :title, `Description` = :description, `Post` = :post, `Url` = :url, `ImageUrl` = :imageUrl WHERE `post`.`Id` = :id");			
			$stmt2 = $this->conn->prepare("UPDATE `postvideo` SET `Video` = :video WHERE `postvideo`.`Id` = :id;");				
			$stmt1->bindParam(':id', $id);
			$stmt2->bindParam(':id', $id);

		}
		else{
			$stmt1 = $this->conn->prepare("INSERT INTO `post` (`Title`, `Description`, `Post`, `Url`, `ImageUrl`) VALUES (:title, :description, :post, :url, :imageUrl)");
			$stmt2 = $this->conn->prepare("INSERT INTO `postvideo` (`PostId`, `Video`) VALUES (LAST_INSERT_ID(), :video);");
		}
		$stmt1->bindParam(':title', $title);
		$stmt1->bindParam(':description', $description);
		$stmt1->bindParam(':post', $post);
		$stmt1->bindParam(':url', $url);
		$stmt1->bindParam(':imageUrl', $ImageUrl);	
		$stmt2->bindParam(':video', $video);	
		$stmt1->execute();
		$postId = $this->conn->lastInsertId();
		$postReturn = $postId;
		$stmt2->execute();			
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

	public function DeletePost($id){
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

	public function GetPostById(){}

	public function PostPagination(){
		$query = $this->conn->prepare("SELECT COUNT(*) as total FROM `post`");
		$query->execute();
		$count = $query->fetchAll(PDO::FETCH_ASSOC);
		$data = $count;
		return $data;
	}

	public function ImageUpload($image){
		$query = $this->conn->prepare("INSERT INTO `post` (`ImageUrl`) VALUES (:ImageUrl);");
		$query->bindParam(':ImageUrl', $image);
		$query->execute();
		return  $this->conn->lastInsertId();	

	}
	
	public function AddView($view,$id){
		$query = $this->conn->prepare("UPDATE `post` SET `View` = :view WHERE `post`.`Id` = :id;");
		$query->bindParam(':view',$view);
		$query->bindParam(':id',$id);
		$query->execute();
		return  $this->conn->lastInsertId();	
	}

	public function Search($sQuery)
	{
		$search = explode(' ' , $sQuery);
		$sizeS = sizeof($search);
		$qs = "SELECT `Id`,`Title`,`Url`,`ImageUrl`, `View` FROM `post` WHERE ";
		$i=0;
		$sArr = array();
		foreach($search as $s)
		{
			$or = " OR ";
			if(($sizeS-1) == $i )
			{
				$or = ""; 
			}
			//$qs.= "`Title` LIKE :".$s." ".$or;
			$qs.= "`Title` LIKE ?".$or;
			$sPush = "%".$s."%";
			array_push($sArr,$sPush);
			$i++;
		} 
		$qs.="AND `isActive` = 1";
		$query= $this->conn->prepare($qs); 
		$query->execute($sArr);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);	
        return $result;
	}

	public function GetCategory(){	
		$query = $this->conn->prepare("SELECT * FROM `category`");			
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
	}

	public function GetCategoryById($id){		
		$query = $this->conn->prepare("SELECT * FROM `category` WHERE `Id` = :id");	
		$query->bindParam(':url', $id);
		$query->execute();		
		$result = $query->fetchAll(PDO::FETCH_ASSOC);	
        return $result;
	}

	public function InsertCategory($id,$cname,$icon) {		
		$stmt1;
		if($id){
			$id = (int) $id;
			$stmt1 = $this->conn->prepare("UPDATE `category` SET `Name` = :cname, `Icon` = :icon WHERE `post`.`Id` = :id");			
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

	public function Updatecategory(){}

	public function Deletecategory(){}



}

?>