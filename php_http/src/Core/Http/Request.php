<?php

	/**
	 * This file is part of MVC Core framework
	 * (c) Matija Božić, www.matijabozic.com
	 * 
	 * This class represent current HTTP Request
	 * 
	 * @package    Http
	 * @author     Matija Božić <matijabozic@gmx.com>
	 * @license    MIT - http://opensource.org/licenses/MIT
	 * @version    20120817
	 */
	
	namespace Core\Http;
	use Core\Http\Cookie;
	use Core\Http\Session;
	
	class Request
	{	
		/**
		 * Class constructor, fetches data and prepares HTTP Request object
		 * 
		 * @access  public
		 * @return  void
		 */
		
		public function __construct()
		{
			$this->cookie      = new Cookie();
			$this->session     = new Session();			
			
			$this->absoluteUri = $this->fetchAbsoluteUri();
			$this->requestUri  = $this->fetchRequestUri();
			$this->pathInfo    = $this->fetchPathInfo();
			$this->method      = $this->fetchMethod();
			$this->version     = $this->fetchVersion();
			$this->headers     = $this->fetchHeaders();
			$this->content     = $this->fetchContent();
			$this->get         = $this->fetchGet();
			$this->post        = $this->fetchPost();
			$this->files       = $this->fetchFiles();
			$this->port        = $this->fetchPort();
			$this->scheme      = $this->fetchScheme();
			$this->userIp      = $this->fetchUserIp();
		}		

		/**
		 * HTTP Cookies object
		 * 
		 * @access  public
		 * @var     object
		 */
		
		public $cookie;

		/**
		 * HTTP Sesssions object
		 * 
		 * @access  public
		 * @var     object
		 */
		
		public $session;
		
		/**
		 * Absolute URI including schema and query string
		 * Example: http://www.example.com/controller/action/param/?test=test
		 * 
		 * @access  protected
		 * @var     string
		 */
				 
		protected $absoluteUri;
		
		/**
		 * HTTP Request URI including query string
		 * Example: /controller/model/param/?test=test
		 * 
		 * @access  protected
		 * @var     string
		 */
		
		protected $requestUri;
		
		/**
		 * Path info, use this for dispatcher
		 * Example: /controller/model/param/
		 * 
		 * @access  protected
		 * @var     string
		 */
		 
		protected $pathInfo;
		
		/**
		 * HTTP Request method/verb
		 * 
		 * @access  protected
		 * @var     string
		 */
		 
		protected $method;
		
		/**
		 * HTTP version
		 * Example: HTTP/1.1
		 * 
		 * @access  protected
		 * @var     string
		 */
		 
		protected $version;
		
		/**
		 * Array that holds all HTTP Request header informations
		 * 
		 * @access  protected
		 * @var     array
		 */
		
		protected $headers;
		
		/**
		 * HTTP Request body 
		 *
		 * @access  protected
		 * @var     string
		 */
		
		protected $content;
		
		/**
		 * Holds everything from $_GET super global variable
		 * 
		 * @access  protected
		 * @var     array
		 */

		protected $get;
		
		/**
		 * Holds everything from $_POST super global variable
		 * 
		 * @access  protected
		 * @var     array
		 */
		 
		protected $post;
		
		/**
		 * Holds everything from $_FILES super global variable
		 * 
		 * @access  protected
		 * @var     array
		 */
		 
		protected $files;
		
		/**
		 * Server port
		 * 
		 * @access  protected
		 * @var     string
		 */		
		
		protected $port;
		
		/**
		 * HTTP Request Scheme, HTTP or HTTPS
		 * 
		 * @access  protected
		 * @var     string
		 */
		
		protected $scheme;
		
		/**
		 * Client Remote Address
		 * 
		 * @access  protected
		 * @var     string
		 */
		
		protected $userIp;
		
		/**
		 * Fetches absolute URI including schema and query string
		 * Example: http://www.example.com/controller/action/param/?test=test
		 * 
		 * @access  protected
		 * @return  string
		 */
				
		protected function fetchAbsoluteUri()
		{
			return $this->fetchScheme() . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		
		/**
		 * Fetches HTTP Request URI including query string
		 * Example: /controller/model/param/?test=test
		 * 
		 * @access  protected
		 * @return  string
		 */	
		
		protected function fetchRequestUri()
		{
			return $_SERVER['REQUEST_URI'];
		}
		
		/**
		 * Fetches path info, use this for dispatcher
		 * Example: /controller/model/param/
		 * 
		 * WARNING: If you get null from this method, you are probably using
		 * .htaccess file to route all requests to index.php, and this removes
		 * $_SERVER['PATH_INFO']. Don't know why, but will check it out!
		 * 
		 * @access  protected
		 * @return  string
		 */	
		
		protected function fetchPathInfo()
		{
			if(isset($_SERVER['ORIG_PATH_INFO'])) {
				return $_SERVER['ORIG_PATH_INFO'];
			} else if(isset($_SERVER['PATH_INFO'])) {
				return $_SERVER['PATH_INFO'];
			}
			return false;
		}
		
		/**
		 * Fetches HTTP Request method/verb
		 * 
		 * @access  protected
		 * @return  string
		 */	
		
		protected function fetchMethod()
		{
			return $_SERVER['REQUEST_METHOD'];	
		}
		
		/**
		 * Fetches HTTP version
		 * Example: HTTP/1.1
		 * 
		 * @access  protected
		 * @return  string
		 */	
		
		protected function fetchVersion()
		{
			return $_SERVER['SERVER_PROTOCOL'];
		}
		
		/**
		 * Fetches HTTP Request headers
		 * 
		 * @access  protected
		 * @return  array
		 */	
		
		protected function fetchHeaders()
		{
			$headers = array();
			
			foreach($_SERVER as $key => $value) {
				if(substr($key, 0, 5) === 'HTTP_') {
					$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
					$headers[$header] = $value;
				} 
			}

			return $headers;
		}
		
		/**
		 * Fetches HTTP Request body 
		 *
		 * @access  protected
		 * @return  string
		 */	
		
		protected function fetchContent()
		{
			return file_get_contents('php://input');
		}
		
		/**
		 * Fetches everything from $_GET super global variable
		 * 
		 * @access  protected
		 * @return  array
		 */
		 		
		protected function fetchGet()
		{
			$get = array();
			
			foreach($_GET as $name => $value) {
				$get[$name] = $value;
			}
			
			return $get;
		}
		
		/**
		 * Fetches everything from $_POST super global variable
		 * 
		 * @access  protected
		 * @return  array
		 */	
		
		protected function fetchPost()
		{
			$post = array();
			
			foreach($_POST as $name => $value) {
			    $post[$name] = $value;
			}
			
			return $post;			
		}
		
		/**
		 * Fetches everything from $_FILES super global variable
		 * 
		 * @access  protected
		 * @return  array
		 */
		
		protected function fetchFiles()
		{
			$files = array();
			
			foreach($_FILES as $name => $value) {
				$files[$name] = $value;
			}
			
			return $files;
		}
		
		/**
		 * Fetches server port
		 * 
		 * @access  protected
		 * @return  string
		 */			
		
		protected function fetchPort()
		{
			return $_SERVER['SERVER_PORT'];			
		}
		
		/**
		 * Fetches HTTP Request Scheme, HTTP or HTTPS
		 * 
		 * @access  protected
		 * @return  string
		 */
		
		protected function fetchScheme()
		{
			return empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off' ? 'http' : 'https';
		}
		
		/**
		 * Fetches Client Remote Address
		 * 
		 * @access  protected
		 * @return  string
		 */
		
		protected function fetchUserIp()
		{
			return $_SERVER['REMOTE_ADDR'];
		}
		
		/**
		 * Returns absolute URI including schema and query string
		 * Example: http://www.example.com/controller/action/param/?test=test
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function absoluteUri()
		{
			return $this->absoluteUri;
		}
		
		/**
		 * Returns HTTP Request URI including query string
		 * Example: /controller/model/param/?test=test
		 * 
		 * @access  public
		 * @return  string
		 */	
		
		public function requestUri()
		{
			return $this->requestUri;
		}
		
		/**
		 * Returns path info, use this for dispatcher
		 * Example: /controller/model/param/
		 * 
		 * @access  public
		 * @return  string
		 */	
		
		public function pathInfo()
		{
			return $this->pathInfo;
		}
		
		/**
		 * Returns HTTP Request method/verb
		 * 
		 * @access  public
		 * @return  string
		 */	
		
		public function method()
		{
			return $this->method;
		}
		
		/**
		 * HTTP version
		 * Example: HTTP/1.1
		 * 
		 * @access  public
		 * @var     string
		 */
		 
		public function version()
		{
			return $this->version;
		}
		
		/**
		 * Returns all HTTP Request headers
		 * 
		 * @access  public
		 * @return  array
		 */			
		
		public function headers()
		{
			return $this->headers;
		}
				
		/**
		 * Returns single HTTP Request header
		 * 
		 * @access  public
		 * @return  string
		 */	
		
		public function header($key)
		{
			if(isset($key)) {
				if(isset($this->headers[$key])) {
					return $this->headers[$key];
				}
				return null;
			}
			return false;
		}
		
		/**
		 * Returns HTTP Request body 
		 *
		 * @access  public
		 * @return  string
		 */			
		
		public function content()
		{
			return $this->content;
		}
		
		/**
		 * Returns everything from $_GET super global variable, or single item
		 * if key value is provided
		 * 
		 * @access  public
		 * @return  array | string
		 */		
		
		public function get($key = null)
		{
			if($key === null) {
				return $this->get;
			}
			
			return $this->get[$key]; 
		}
		
		/**
		 * Returns everything from $_POST super global variable, or single item
		 * if key value is provided
		 * 
		 * @access  public
		 * @return  array | string
		 */	
				
		public function post($key = null)
		{
			if($key === null) {
				return $this->post;
			}
			
			return $this->post[$key];
		}
		
		/**
		 * Returns everything from $_FILES super global variable, or single item
		 * if key value is provided
		 * 
		 * @access  public
		 * @return  array | string
		 */
				
		public function files($key = null)
		{
			if($key === null) {
				return $this->files;
			}
			
			return $this->files[$key];
		}
		
		/**
		 * Returns server port
		 * 
		 * @access  public
		 * @return  string
		 */
				
		public function port()
		{
			return $this->port;
		}
		
		/**
		 * HTTP Request Scheme, HTTP or HTTPS
		 * 
		 * @access  public
		 * @var     string
		 */
				
		public function scheme()
		{
			return $this->scheme;
		}
		
		/**
		 * Returns Client Remote Address
		 * 
		 * @access  public
		 * @return  string
		 */		
		
		public function userIp()
		{
			return $this->userIp;
		}
		
		/**
		 * Returns User Client
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function userClient()
		{
			return $this->header("User-Agent");
		}
		
		/**
		 * Checks if HTTP Request is AJAX
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function isAjax()
		{
			if(isset($this->header['X_REQUESTED_WITH']) AND $this->header['X_REQUESTED_WITH'] === 'XMLHttpRequest') {
				return true;
			}
			return false;
		}
		
		/**
		 * Checks if Request is secure, HTTP or HTTPS
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function isSecure()
		{
			if($this->scheme === 'https') {
				return true;
			}
			return false;
		}
	}

?>