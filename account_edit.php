<?php 
include 'layouts/header.php';

if(isset($_POST['updatebtn']))
{
	if($_FILES['picture']['name'] != "") {

		$oldName = $_FILES['picture']['name'];
	  	$newname = uniqid().'-'.$oldName;
	    $folder ='img/';
	    if(!is_dir($folder))
	      mkdir($folder,777); 
	      if(move_uploaded_file($_FILES['picture']['tmp_name'],$folder.$newname)){
			updatephoto($conn,$_POST,$newname,$twitterId);
	      };
	}

  if(updateuser($conn,$_POST,$twitterId))
    {
      redirection('account_edit.php');
    } 
}
?>

<div class="body">
	<div class="mycontainer">
		<div class="row">
			<div class="col-12">
				<form class="flexer" method="POST" id="adminform" enctype="multipart/form-data">
					<div class="imgprt">
						<?php $userInfo =getUser($conn,$twitterId); ?>
						<h3>アイコン</h3>
						<img src="
						<?php if(empty($userInfo['picture'])){echo "img/ad.png";}else{ echo $userInfo['picture'];};?>" alt="" id="here" >
							<input type="file" name="picture" id="file" class="inputfile" onchange="readURL(this);"/>
							<label for="file" class="cen2">ファイル</label>
					</div>
					<div class="flexer frprt">
						<h3>アカウント情報</h3>
							<label>名前 <sup>*</sup></label>
							<input type="text" name="first_name" value="<?php echo $userInfo['first_name']; ?>">
							<label>企業名</label>
							<input type="text" name="company" placeholder="<?php if(empty($userInfo['company'])) { echo "Enter Company Name";}else{ echo $userInfo['company'];}; ?>" value="<?php echo $userInfo['company']; ?>">
							<label>郵便番号 <sup>*</sup></label>
							<input type="text" name="zip" placeholder="<?php if(empty($userInfo['zip'])) { echo "Enter zip Code";}else{ echo $userInfo['zip'];}; ?>" value="<?php echo $userInfo['zip']; ?>">
							<label>住所１ <sup>*</sup></label>
							<input type="text" name="address1" placeholder="<?php if(empty($userInfo['address1'])) { echo "Enter address1";}else{ echo $userInfo['address1'];}; ?>" value="<?php echo $userInfo['address1']; ?>">
							<label>住所２</label>
							<input type="text" name="address2" placeholder="<?php if(empty($userInfo['adress2'])) { echo "Enter adress2";}else{ echo $userInfo['adress2'];}; ?>" value="<?php echo $userInfo['address2']; ?>">
							<label>電話番号 <sup>*</sup></label>
							<input type="text" name="tel" placeholder="<?php if(empty($userInfo['tel'])) { echo "Enter tel no";}else{ echo $userInfo['tel'];}; ?>"  value="<?php echo $userInfo['tel']; ?>">
							<label>メール <sup>*</sup></label>
							<input type="email" name="email" placeholder="<?php if(empty($userInfo['email'])) { echo "Enter email";}else{ echo $userInfo['email'];}; ?>" value="<?php echo $userInfo['email']; ?>">
							<button class="msbtn" type="submit" name="updatebtn">変更</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?php include 'layouts/footer.php';?>
<script type="text/javascript">
	function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#here')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>