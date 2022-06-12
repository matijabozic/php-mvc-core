<?php

	/**
	 * This file is part of MVC Core framework
	 * (c) Matija Božić, www.matijabozic.com
	 * 
	 * This file represents current HTTP Response
	 * 
	 * @package    Http
	 * @author     Matija Božić <matijabozic@gmx.com>
	 * @license    MIT - http://opensource.org/licenses/MIT
	 * @version    20120817
	 */
	
	namespace Core\Http;
	
	class Response
	{
		/**
		 * HTTP protocol version
		 * 
		 * @access  protected
		 * @var     integer
		 */
		
		protected $version = '1.0';
		
		/** 
		 * HTTP status code
		 * 
		 * @access  protected
		 * @var     integer
		 */
		
		protected $statusCode;
		
		/**
		 * HTTP status text
		 * 
		 * @access  protected
		 * @var     string
		 */
		
		protected $statusText;
		
		/**
		 * Holds HTTP Headers to be sent to browser
		 * 
		 * @access  protected
		 * @var     array
		 */
		
		protected $headers;
		
		/** 
		 * Holds HTTP body aka page content to be sent to the browser
		 * 
		 * @access  protected
		 * @var     string
		 */
		
		protected $content;
		
		/**
		 * List of available HTTP Response codes / messages
		 * 
		 * @access  protected
		 * @var     array
		 */
		
		protected $statusCodes = array(
		
		// Informational codes
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',
		
		// Success codes
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-status',
		208 => 'Already Reported',
		
		// Redirection codes
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => 'Switch Proxy', // Deprecated
		307 => 'Temporary Redirect',
		
		// Client error
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Time-out',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Large',
		415 => 'Unsupported Media Type',
		416 => 'Requested range not satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		425 => 'Unordered Collection',
		426 => 'Upgrade Required',
		428 => 'Precondition Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',
		
		// Server error
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Time-out',
		505 => 'HTTP Version not supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		508 => 'Loop Detected',
		511 => 'Network Authentication Required',
		);
		
		/**
		 * Constructor
		 * 
		 * @param  string   Page content
		 * @param  integer  HTTP status code
		 * @param  array    HTTP headers
		 */
		
		public function __construct($content = '', $status = 200, $headers = array())
		{
			$this->content    = $content;
			$this->statusCode = $status;
			$this->headers    = $headers;
			
			return $this;
		}
		
		/**
		 * Set HTTP protocol version
		 * 
		 * @access  public
		 * @param   int
		 * @return  void
		 */
		
		public function setVersion($version)
		{
			$this->version = $version;
		}
		
		/**
		 * Check if HTTP protocol version is set
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function hasVersion()
		{
			if(isset($this->version)) {
				return true;
			}
			return false;
		}		
		
		/**
		 * Get HTTP protocol version
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getVersion()
		{
			return $this->version;
		}
		
		/**
		 * Set HTTP status code 
		 *
		 * @access  public
		 * @param   int
		 * @return  void
		 */
		
		public function setStatusCode($code)
		{
			$this->statusCode = $code;
			$this->statusText = $this->statusCodes[$code];
		}
		
		/**
		 * Check if status code is set
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function hasStatusCode()
		{
			if(isset($this->statusCode)) {
				return true;
			}
			return false;
		}
		
		/**
		 * Get status code
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getStatusCode()
		{
			return $this->statusCode;
		}
		
		/**
		 * Set HTTP status text
		 * 
		 * @access  public
		 * @param   string
		 * @return  void
		 */
		
		public function setStatusText($text)
		{
			$this->statusText = $text;
		}
		
		/**
		 * Check if status text is set
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function hasStatusText()
		{
			if(isset($this->statusText)) {
				return true;	
			}
			return false;
		}
		
		/**
		 * Get status text
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getStatusText()
		{
			return $this->statusText;
		}
		
		/**
		 * Sets HTTP header to be sent to the browser
		 * 
		 * @access  public
		 * @param   string
		 * @param   string
		 * @return  void
		 */
		
		public function setHeader($name, $value)
		{
			$this->headers[$name] = $value;
		}
		
		/**
		 * Check if HTTP header is set
		 * 
		 * @access  public
		 * @param   string
		 * @return  bool
		 */
		
		public function hasHeader($name)
		{
			if(isset($this->headers[$name])) {
				return true;
			}
			return false;
		}
		
		/**
		 * Get HTTP header
		 * 
		 * @access  public
		 * @param   string
		 * @return  string
		 */
		
		public function getHeader($name)
		{
			return $this->headers[$name];	
		}
		
		/**
		 * Sets HTTP body, page content
		 * 
		 * @access  public
		 * @param   string
		 * @return  void
		 */
		
		public function setContent($content)
		{
			$this->content = $content;
		}
		
		/**
		 * Check if HTTP body is set
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function hasContent()
		{
			if(isset($this->content)) {
				return true;
			}
			return false;
		}
		
		/**
		 * Get HTTP body
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getContent()
		{
			return $this->content;
		}
		
		/**
		 * Sends all headers to the browser
		 * 
		 * @access  public
		 * @return  void
		 */
		
		public function sendHeaders()
		{
			header("HTTP/{$this->version} {$this->statusCode} {$this->statusText}");
		
			if(isset($this->headers)) {
				foreach($this->headers as $name => $value) {
					header($name . ': ' . $value);
				}
			}
		}
		
		/**
		 * Sends HTTP body to the browser
		 * 
		 * @access  public
		 * @return  void
		 */
		
		public function sendContent()
		{
			echo $this->content;
		}
		
		/**
		 * Sends both HTTP headers and HTTP body to the browser
		 * 
		 * @access  public
		 * @return  void
		 */
		
		public function send()
		{
			$this->sendHeaders();
			$this->sendContent();
		}
	}

?>