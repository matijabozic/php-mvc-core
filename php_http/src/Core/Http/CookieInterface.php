<?php

	namespace Core\Http;

	interface CookieInterface
	{
		public function setCookie($name, $value, $expire, $path, $domain, $secure, $httponly);
		public function setRawCookie($name, $value, $expire, $path, $domain, $secure, $httponly);
		public function getCookie($name);
		public function getCookies();
		public function deleteCookie($name);
		public function deleteCookies();
	}

?>