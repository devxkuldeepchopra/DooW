<?php
class Category 
{
	private $conn;
	public function __construct($conn) 
	{
		$this->conn = $conn;
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
	public function InsertCategory($title,$description,$category,$url,$ImageUrl){		
		$query = $this->conn->prepare("INSERT INTO `category` (`Title`, `Description`, `category`, `Url`, `ImageUrl`) VALUES (:title, :description, :category, :url, :imageUrl)");
		$query->bindParam(':title', $title);
		$query->bindParam(':description', $description);
		$query->bindParam(':category', $category);
		$query->bindParam(':url', $url);
		$query->bindParam(':imageUrl', $ImageUrl);
		$query->execute();
		return  $this->conn->lastInsertId();	
	}
	public function Updatecategory(){}
	public function Deletecategory(){}

}
?>