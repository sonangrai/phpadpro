<?php 
// Include configuration file 
require_once 'config.php'; 
 
// Include User class 
require_once 'User.class.php'; 

// Includeing user function
include 'inc/userfunction.php';
 
// If OAuth token not matched 
if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] !== $_REQUEST['oauth_token']){ 
    //Remove token from session 
    unset($_SESSION['token']); 
    unset($_SESSION['token_secret']); 
} 
 
// If user already verified  
if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified' && !empty($_SESSION['request_vars'])){ 
    //Retrive variables from session 
    $username         = $_SESSION['request_vars']['screen_name']; 
    $twitterId        = $_SESSION['request_vars']['user_id']; 
    $oauthToken       = $_SESSION['request_vars']['oauth_token']; 
    $oauthTokenSecret = $_SESSION['request_vars']['oauth_token_secret']; 
    $name             = $_SESSION['userData']['first_name'].' '.$_SESSION['userData']['last_name']; 
    $profilePicture   = $_SESSION['userData']['picture']; 
     
    /* 
     * Prepare output to show to the user 
     */ 
    $twClient = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, $oauthToken, $oauthTokenSecret); 
     
    //If user submits a tweet to post to twitter 
    if(isset($_POST["updateme"])){ 
        $my_update = $twClient->post('statuses/update', array('status' => $_POST["updateme"])); 
    } 
     
    // Display username and logout link 
    $output = '<div class="welcome_txt">Welcome <strong>'.$username.'</strong>'; 

}elseif(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']){ 
    // Call Twitter API 
    $twClient = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']); 
     
    // Get OAuth token 
    $access_token = $twClient->getAccessToken($_REQUEST['oauth_verifier']); 
     
    // If returns success 
    if($twClient->http_code == '200'){ 
        // Storing access token data into session 
        $_SESSION['status'] = 'verified'; 
        $_SESSION['request_vars'] = $access_token; 
         
        // Get user profile data from twitter 
        $userInfo = $twClient->get('account/verify_credentials'); 
         
        // Initialize User class 
        $user = new User(); 
         
        // Getting user's profile data 
        $name = explode(" ",$userInfo->name); 
        $fname = isset($name[0])?$name[0]:''; 
        $lname = isset($name[1])?$name[1]:''; 
        $profileLink = 'https://twitter.com/'.$userInfo->screen_name; 
        $twUserData = array( 
            'oauth_uid'     => $userInfo->id, 
            'first_name'    => $fname, 
            'last_name'     => $lname, 
            'locale'        => $userInfo->lang, 
            'picture'       => $userInfo->profile_image_url, 
            'link'          => $profileLink, 
            'twitter_id'      => $userInfo->screen_name,
            'name'			=> $fname . ''. $lname
        ); 
         
        // Insert or update user data to the database 
        $twUserData['oauth_provider'] = 'twitter'; 
        $userData = $user->checkUser($twUserData); 
         
        // Storing user data into session 
        $_SESSION['userData'] = $userData; 
         
        // Remove oauth token and secret from session 
        unset($_SESSION['token']); 
        unset($_SESSION['token_secret']); 
         
        // Redirect the user back to the same page 
        header('Location: ./ad_edit.php'); 
    }else{ 
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>'; 
    } 
}else{ 
    // Fresh authentication 
    $twClient = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET); 
    $request_token = $twClient->getRequestToken(TW_REDIRECT_URL); 
     
    // Received token info from twitter 
    $_SESSION['token']         = $request_token['oauth_token']; 
    $_SESSION['token_secret']= $request_token['oauth_token_secret']; 
     
    // If authentication returns success 
    if($twClient->http_code == '200'){ 
        // Get twitter oauth url 
        $authUrl = $twClient->getAuthorizeURL($request_token['oauth_token']); 
         
        // Display twitter login button 
        $output = '<a class="tweet" href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><i class="fa fa-twitter"></i> Twitterでログイン</a>'; 
    }else{ 
        $output = '<h3 style="color:red">Error connecting to Twitter! Try again later!</h3>'; 
    } 
} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>AD-VR</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<header>
	<div class="container-myfluid">
		<div class="row">
			<div class="col-6">
				<div class="logo">
					<a href="<?php $_SERVER['SERVER_NAME'];?>">AD-VR</a>
				</div>
			</div>
			<div class="col-6">
                <?php $userInfo =getUser($conn,$twitterId); ?>
				<div class="account">
				  <div class="avt">
				  	<?php if (!empty($userInfo['picture'])) {?>
				  		<img src="<?php echo $userInfo['picture'];?>" alt=""/>
					<?php };?>
					<span id="prof"><?php if (!empty($_SESSION['request_vars']['screen_name'])) {echo $_SESSION['request_vars']['screen_name'];};?></span>
					<span><?php if (empty($_SESSION['request_vars']['screen_name'])) {echo '<a href="#login">Login</a>';};?></span>
				  </div>
				  <div class="dropdown-box" id="dropdown-box">
				    <a class="drop-item" href="ad_edit.php">広告管理</a>
				    <a class="drop-item" href="account_edit.php">アカウント管理</a>
				    <?php if (!empty($name)) {echo '<a class="drop-item" href="logout.php">ログアウト</a>';};?>
				  </div>
				</div>
			</div>
		</div>
	</div>
</header>