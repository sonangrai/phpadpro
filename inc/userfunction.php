<?php 

function redirection($path)
{
	echo '<script> window.location.href="'.$path.'" </script>';
}


$server = DB_HOST;
$db = DB_NAME;
try {
	$conn = new PDO("mysql:host=$server;dbname=$db", DB_USERNAME, DB_PASSWORD);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
}
catch(PDOException $e)
{
	echo  $e->getMessage();
}

//get user data
function getUser($conn,$id)
 {
 	$stmtSelect = $conn->prepare("SELECT * FROM a_user WHERE oauth_uid=:oauth_uid");
 	$stmtSelect->bindParam(':oauth_uid',$id);
 	$stmtSelect->execute();
 	return $info = $stmtSelect->fetch();
 }

//update the data
function updateuser($conn,$data,$id)
 {
    $stmtUpdate = $conn->prepare("UPDATE  a_user SET first_name=:first_name, company=:company, zip=:zip, address1=:address1, address2=:address2, tel=:tel, email=:email WHERE oauth_uid=:oauth_uid");
 
    $stmtUpdate->bindParam('first_name',$data['first_name']);
    $stmtUpdate->bindParam('company',$data['company']);
    $stmtUpdate->bindParam('zip',$data['zip']);
    $stmtUpdate->bindParam('address1',$data['address1']);
    $stmtUpdate->bindParam('address2',$data['address2']);
    $stmtUpdate->bindParam('tel',$data['tel']);
    $stmtUpdate->bindParam('email',$data['email']);
    $stmtUpdate->bindParam('oauth_uid',$id);
    if($stmtUpdate->execute())
        return true;

    return false;
                                
 }

 //update the photto
function updatephoto($conn,$data,$image,$id)
 {
 	$newimg = 'img/'.$image;
    //find old image
    $stmtFind = $conn->prepare("SELECT * FROM a_user WHERE oauth_uid=:oauth_uid");
    $stmtFind->bindParam(':oauth_uid',$id);
    if($stmtFind->execute()){
        $dname = $stmtFind->fetch();
        unlink($dname['picture']);
        //now update
        $stmtUpdate = $conn->prepare("UPDATE  a_user SET picture=:picture WHERE oauth_uid=:oauth_uid");     
        $stmtUpdate->bindParam('picture',$newimg);
        $stmtUpdate->bindParam('oauth_uid',$id);
        if($stmtUpdate->execute())
            return true;

        return false;
    }
                                
 }

//insert ad
 function insertad($conn,$data,$image)
 {
    $stmtInsert = $conn->prepare("INSERT INTO r_ad 
                                (`title`, `details`, `user_id`, `image_file_name`,`timestamp`)
                                VALUES(:title, :details, :user_id, :image_file_name,CURRENT_TIMESTAMP)");
 
    $stmtInsert->bindParam('title',$data['title']);
    $stmtInsert->bindParam('details',$data['details']);
    $stmtInsert->bindParam('user_id',$_SESSION['request_vars']['user_id']);
    $stmtInsert->bindParam('image_file_name',$image);
    if($stmtInsert->execute())
        return true;

    return false;
                                
 }


//get ad
 function getAllAd($conn)
 {
    $stmtSelect = $conn->prepare("SELECT * FROM r_ad WHERE user_id=:user_id");
    $stmtSelect->bindParam('user_id',$_SESSION['request_vars']['user_id']);
    $stmtSelect->execute();
    return $info = $stmtSelect->fetchAll();
 }

 //delete ad
 function deletead($conn,$id)
 {
    //find image
    $stmtFind = $conn->prepare("SELECT * FROM r_ad WHERE id=:id");
    $stmtFind->bindParam(':id',$id);
    if($stmtFind->execute()){
        $dname = $stmtFind->fetch();
        unlink("./img/".$dname['image_file_name']);
        //delete ad
        $stmtSelect = $conn->prepare("DELETE FROM r_ad WHERE id=:id");
        $stmtSelect->bindParam(':id',$id);
        if($stmtSelect->execute())
            return true;
        
        return false;
    }
 }


