<?php include 'layouts/header.php';

$id = $_SESSION['userData']['twitter_id'];
if(isset($_POST['savebtn']))
{
  $oldName = $_FILES['image_file_name']['name'];
  $newname = uniqid().'-'.$oldName;
    $folder ='img/';
    if(!is_dir($folder))
      mkdir($folder,777); 
      if(move_uploaded_file($_FILES['image_file_name']['tmp_name'],$folder.$newname))
        {
          if(insertad($conn,$_POST,$newname,$id))
            {
              redirection('ad_edit.php');
            } 
        }
}
?>

<div class="body">
	<div class="mycontainer">
		<div class="row">
			<div class="col-12">
				<div class="imgprt adprt">
					<img src="img/ad.png" alt="" id="here">
					<form class="flexer adfrm" method="POST" id="adminform" enctype="multipart/form-data">
						<input type="file" name="image_file_name" id="file" class="inputfile" onchange="readURL(this);"/>
						<label for="file" class="cen">ファイル選択</label>
						<div class="sfrm flexer">
							<h3>広告情報</h3>
							<label>タイトル <sup>*</sup></label>
							<input type="text" name="title" required="">
							<label>詳細</label>
							<textarea name="details"></textarea>						
						</div>
						<button type="submit" class="msbtn" name="savebtn">登録</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include 'layouts/footer.php';?>
