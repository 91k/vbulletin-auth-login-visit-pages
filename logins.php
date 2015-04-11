<?php

/*
	vBulletin auth/logins and visit pages script

	https://github.com/i-like-a-boss/vbulletin-auth-login-visit-pages
*/

?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=win-1251" />
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
</head>

<body>

<?php

	// data of user vBulletin 3.8

	define(URL_FORUM, ""); // link
	define(LOGIN_FORUM, ""); // login user
	define(PASS_FORUM, ""); // password


	// data setting for GET/POST-requests

	define(URL_HTTP, "http://" . URL_FORUM . ".ru/"); // http
	define(URL_HTTPS, "https://" . URL_FORUM . ".ru/"); // or httpS

	define(WEBBOT_NAME, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
    define(CURL_TIMEOUT, 10);


	// function for GET/POST-requests

	// if $postfields is not empty,
	// then start POST-req
	// else GET-req

    function c_exec($url, $postfields) {
    	$ch = ""; // reset value
    	$ch = curl_init();
	    curl_setopt ($ch, CURLOPT_URL, $url) ; // target site
	    curl_setopt ($ch, CURLOPT_COOKIEFILE, "cookie-" . URL_FORUM . ".txt");
	    curl_setopt ($ch, CURLOPT_COOKIEJAR, "cookie-" . URL_FORUM . ".txt");
	    curl_setopt ($ch, CURLOPT_REFERER, URL_HTTP);
	    curl_setopt ($ch, CURLOPT_TIMEOUT, CURL_TIMEOUT); // timeout
	    curl_setopt ($ch, CURLOPT_USERAGENT, WEBBOT_NAME);


	    // defaut CURLOPT_POST == 0

	    if(!empty($postfields)) {
	    	curl_setopt ($ch, CURLOPT_POST, 1);
		    curl_setopt ($ch, CURLOPT_POSTFIELDS, $postfields);
		}

	    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, FALSE); // follow redirects
	    curl_setopt ($ch, CURLOPT_MAXREDIRS,	0); // limit redirections to four
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE); // return in string

	    // sleep(rand(15)); // anti-flood-requests
	    return curl_exec($ch);
	}


	// example POST-req: authorisation on forum

    $webpage['FILE'] = c_exec(
		URL_HTTP . "login.php?do=login", // 1st param

		"vb_login_username=" . LOGIN_FORUM . // 2nd param
		"&vb_login_password=" . PASS_FORUM .
		"&login_btn=%C2%F5%EE%E4" .
		"&cookieuser=1" .
		"&s=&securitytoken=guest" .
		"&do=login" .
		"&vb_login_md5password=".
		"&vb_login_md5password_utf="
	);


	// example GET-req: visit page

    $webpage['FILE'] = c_exec(
		URL_HTTP .
		"forumdisplay.php?f=300", // 1st param

		"" // 2nd params is empty!
    );


    // var_dump($webpage['FILE']); // debug


	curl_close($ch);
?>

</body>
</html>
