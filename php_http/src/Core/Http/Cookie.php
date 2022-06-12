<?php

	/**
	 * This file is part of MVC Core framework
	 * (c) Matija Božić, www.matijabozic.com
	 * 
	 * Cookie class, wraps PHP Cookies functionality, and enables you to use
	 * Cookies in object oriented manier.
	 * 
	 * @package    Http
	 * @author     Matija Božić <matijabozic@gmx.com>
	 * @license    MIT - http://opensource.org/licenses/MIT
	 */
	
	namespace Core\Http;
	use Core\Http\CookieInterface;
	
	class Cookie implements CookieInterface
	{
		/**
		 * Set new cookie
		 * 
		 * @access public
		 * @param  string - Cookie name
		 * @param  string - Cookie value
		 * @param  int    - Cookie expire time, secunds
		 * @param  string - Path on the server where the cookie will be available on
		 * @param  string - Domain that cookie is available on
		 * @param  bool   - Cookie will only be transmitted over secure HTTPS connection
		 * @param  bool   - Cookie will be accessible only through HTTP protocol.
		 * @return bool
		 */
		
		public function setCookie($name, $value, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
		{
			if(isset($expire)) {
				$expire = time() + $expire;
			}
			
			if(setcookie($name, $value, $expire, $path, $domain, $secure, $httponly)) {
				return true;
			}
			
			return false;
		}
		
		/** 
		 * Set new raw cookie
		 * 
		 * @access public
		 * @param  string - Cookie name
		 * @param  string - Cookie value
		 * @param  int    - Cookie expire time, secunds
		 * @param  string - Path on the server where the cookie will be available on
		 * @param  string - Domain that cookie is available on
		 * @param  bool   - Cookie will only be transmitted over secure HTTPS connection
		 * @param  bool   - Cookie will be accessible only through HTTP protocol.
		 * @return bool
		 */
		
		public function setRawCookie($name, $value, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null)
		{
			if(isset($expire)) {
				$expire = time() + $expire;
			}
			
			if(setcookie($name, $value, $expire, $path, $domain, $secure, $httponly)) {
				return true;
			}
			
			return false;		
		}
		
		/**
		 * Get cookie value
		 * 
		 * @access public
		 * @param  string - Cookie name
		 * @return bool
		 */
		
		public function getCookie($name)
		{
			if(isset($_COOKIE[$name])) {
				return $_COOKIE[$name];
			}
			
			return false;
		}
		
		/**
		 * Get all cookies as array
		 * 
		 * @access public
		 * @return array
		 */
		
		public function getCookies()
		{
			$cookies = array();
			
			foreach($_COOKIE as $name => $value) {
				$cookies[$name] = $value;	
			}
			
			return $cookies;
		}
		
		/**
		 * Delete cookie
		 * 
		 * @access public
		 * @param  string - Cookie name to delete
		 * @return bool
		 */
		
		public function deleteCookie($name)
		{
			if(setcookie($name, null, time() - 3600)) {
				return true;
			}
			
			return false;
		}
		
		/**
		 * Delete all cookies
		 * 
		 * @access public
		 * @return bool
		 */
		
		public function deleteCookies()
		{
			foreach($_COOKIE as $name => $value) {
				setcookie($name, null, time() - 360);
			}
			
			if(sizeof($_COOKIE) === 0) {
				return true;
			}
			
			return false;	
		}
	}

?>