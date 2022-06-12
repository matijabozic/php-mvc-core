<?php

	/**
	 * This file is part of MVC Core framework
	 * (c) Matija Božić, www.matijabozic.com
	 * 
	 * This class is wrapper for libcurl, that allows you to connect and 
	 * communicate to many different types of servers with many different type
	 * of protocols.
	 * 
	 * Reference: http://www.php.net/manual/en/book.curl.php
	 * 
	 * This class enables you to use PHP cURL in object oriented manier.
	 * 
	 * @package    cURL
	 * @author     Matija Božić <matijabozic@gmx.com>
	 * @license    MIT - http://opensource.org/licenses/MIT
	 */
	 
	class cURL
	{
		
		/**
		 * cURL handle
		 * 
		 * @access  protected
		 * @var     array
		 */
		
		protected $handle = array();
		
		/**
		 * Starts new cURL session
		 * 
		 * @access  public
		 * @param   string
		 * @return  bool
		 */
		
		public function init($url = null)
		{
			if($this->handle = curl_init($url))
			{
				return true;
			}
			
			return false;
		}
		
		/**
		 * Close cURL session
		 * 
		 * @access  public
		 * @return  void
		 */
		
		public function close()
		{
			curl_close($this->handle);
		}
		
		/**
		 * Set single session option
		 * 
		 * @access  public
		 * @param   mixed
		 * @param   mixed
		 * @return  bool
		 */
		
		public function option($option, $value)
		{
			return curl_setopt($this->handle, $option, $value);
		}
		
		/**
		 * Set multiple session options
		 * 
		 * @access  public
		 * @param   array
		 * @return  bool
		 */
		
		public function options($options)
		{
			return curl_setopt_array($this->handle, $options);
		}
		
		/**
		 * Executes current cURL session
		 * 
		 * @access  public
		 * @return  mixed
		 */
		
		public function exec()
		{
			return curl_exec($this->handle);
		}
		
		/**
		 * Returns information about the last transfer
		 * 
		 * @access  public
		 * @return  mixed
		 */
		
		public function info($option = null)
		{
			return curl_getinfo($this->handle, $option);
		}
		
		/**
		 * Returns string containing the last error for the current session
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function error()
		{
			return curl_error($this->handle);
		}
		
		/**
		 * Returns the error number for the last error operation
		 * 
		 * @access  public
		 * @return  int
		 */
		
		public function errno()
		{
			return curl_errno($this->handle);
		}
		
		/**
		 * Returns information about cURL version
		 * 
		 * @access  public
		 * @return  array
		 */
		
		public function version()
		{
			return curl_version();
		}
	}
?>