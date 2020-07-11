<?php include 'layouts/header.php';
$userInfo =getUser($conn,$twitterId);
?>

<div class="body">
	<div class="mycontainer">
		<div class="row">
			<div class="col-12">
				<div class="tit">
					<h2>登録広告一覧</h2>
				</div>
			</div>
			<?php $Ad = getAllAd($conn);
			if(empty($Ad)){
			?>
			<div class="col-12">
				<h2 class="nana">No Ads</h2>
			</div>
			<?php }; ?>
			<div class="col-12">
				<div class="popup-gallery">
					<div class="row">
					<?php
					  foreach ($Ad as $k => $info):
					?>
					<div class="col-lg-3 col-md-4 col-12">
						<div class="aditem">
							<img id="myImg" src="img/<?php echo $info['image_file_name'];?>" alt="<?php echo $info['title'];?>" onclick="popup(this.src, this.alt);">
							<span><?php echo $info['title'];?></span>
							<p><?php echo $info['details'];?></p>
							<a href="deletead.php?ref=<?php echo $info['id']; ?>" onclick="return confirm('Are you sure to delete ?')">削除</a>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
			<div class="col-12">
				<div class="long">
					<?php if(empty($userInfo['company']) || empty($userInfo['zip']) || empty($userInfo['email']) || empty($userInfo['tel']) || empty($userInfo['address1']) || empty($userInfo['address2'])) { ?> 
						<span class="warn">広告を登録する前に、アカウントの追加情報の登録をお願いします。</span>
						<span class="warn"><red>こちら</red>を押して、必須項目の登録をお願い致します。</span>
					<?php } else { ?>
					<a href="/add_ad.php" class="albtn">新規登録</a>
				<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<?php include 'layouts/footer.php';?>