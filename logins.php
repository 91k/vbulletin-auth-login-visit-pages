<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=win-1251" />
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
</head>

<body>

<?php

	// данные по форуму на vBulletin
	define(URL_FORUM, ""); // google
	define(LOGIN_FORUM, ""); // login
	define(PASS_FORUM, ""); // pass

	// данные для настройки get/post-обращений
	define(URL_HTTP, "http://". URL_FORUM .".ru/");
	define(URL_HTTPS, "https://". URL_FORUM .".ru/");
	define(WEBBOT_NAME, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
    define(CURL_TIMEOUT, 10);

	// функция формирующая get/post-запросы
	// если в $postfields пусто, то выполняется curl get-запрос.
	// get-запрос можно использовать как обычное посещение страницы, когда получены cookie
    function c_exec($url, $postfields) {
    	$ch = ""; // reset
    	$ch = curl_init();
	    curl_setopt ($ch, CURLOPT_URL,			$url) ; // target site
	    curl_setopt ($ch, CURLOPT_COOKIEFILE,	"cookie-". URL_FORUM .".txt"); 
	    curl_setopt ($ch, CURLOPT_COOKIEJAR,	"cookie-". URL_FORUM .".txt");
	    curl_setopt ($ch, CURLOPT_REFERER,		URL_HTTP);
	    curl_setopt ($ch, CURLOPT_TIMEOUT,		CURL_TIMEOUT); // timeout
	    curl_setopt ($ch, CURLOPT_USERAGENT,	WEBBOT_NAME);

	    // по умолчанию CURLOPT_POST == 0
	    if(!empty($postfields)) {
	    	curl_setopt ($ch, CURLOPT_POST,		1);
		    curl_setopt ($ch, CURLOPT_POSTFIELDS, $postfields);
		}

	    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, FALSE); // follow redirects
	    curl_setopt ($ch, CURLOPT_MAXREDIRS,	0); // limit redirections to four
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE); // return in string

	    // sleep(rand(15));
	    return curl_exec($ch);
	}

	// пример post-запроса:
	// авторизация на форуме
    $webpage['FILE'] = c_exec(
		URL_HTTP ."login.php?do=login",

		"vb_login_username=". LOGIN_FORUM .
		"&vb_login_password=". PASS_FORUM .
		"&login_btn=%C2%F5%EE%E4".
		"&cookieuser=1".
		"&s=&securitytoken=guest".
		"&do=login".
		"&vb_login_md5password=".
		"&vb_login_md5password_utf="
	);

	// пример get-запроса:
	// посещение страницы
    $webpage['FILE'] = c_exec(URL_HTTP ."forumdisplay.php?f=300", "");

	curl_close($ch);
?>

</body>
</html>