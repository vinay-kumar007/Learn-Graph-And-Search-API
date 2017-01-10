<?php
session_start();
require_once __DIR__ . '/php-sdk-v5/src/Facebook/autoload.php';
function PageExists()
{
	
	$fb = new Facebook\Facebook([
	'app_id' => '// your app id//',
	'app_secret' => '//your app secret//',
	'default_graph_version' => 'v2.8',
	]);
	$helper = $fb->getRedirectLoginHelper();
	
	try 
	{
		if (isset($_SESSION['facebook_access_token'])) 
		{
			$accessToken = $_SESSION['facebook_access_token'];
		} 	
		else 
		{
			$accessToken = $helper->getAccessToken();
		}
	} 
	
	catch(Facebook\Exceptions\FacebookResponseException $e) 
	{
		// When Graph returns an error
		//echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} 
	catch(Facebook\Exceptions\FacebookSDKException $e) 
	{
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	if (isset($accessToken)) 
	{
		if (isset($_SESSION['facebook_access_token'])) 
		{
			$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
		} 
		else 
		{
			// getting short-lived access token
			$_SESSION['facebook_access_token'] = (string) $accessToken;
			// OAuth 2.0 client handler
			$oAuth2Client = $fb->getOAuth2Client();
			// Exchanges a short-lived access token for a long-lived one
			$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
			$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
			// setting default access token to be used in script
			$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
		}
	// redirect the user back to the same page if it has "code" GET variable
	// if (isset($_GET['code'])) 
	// {
		// header("Location:http://localhost/Onlooker_Mvc/index.php" );
	// }
	// getting basic info about user
	try 
	{
		$profile_request = $fb->get('/me');
		$profile = $profile_request->getGraphNode()->asArray();
	} 
	catch(Facebook\Exceptions\FacebookResponseException $e) 
	{
		session_destroy();
		session_start();
		PageExists();
		exit;
	} 
	catch(Facebook\Exceptions\FacebookSDKException $e) 
	{
		session_destroy();
		session_start();
		PageExists();
		exit;
	}
	
	// get basic page info
	$page = $fb->get("https://www.facebook.com/CricTrackerIndia/");
	$page = $page->getGraphNode()->asArray();
	"<br>".print_r ($page)."</br>";
  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
	} 
	else 
	{
		// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
		$loginUrl = $helper->getLoginUrl('http://localhost/Demo/fb/FbNameId.php');
		echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
	}

}
PageExists()
?>