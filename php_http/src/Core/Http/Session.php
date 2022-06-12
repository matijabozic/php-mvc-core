<?php

   	/** 
	 * This file is part of MVC Core framework
	 * (c) Matija Božić, www.matijabozic.com
	 * 
	 * Session Class is wrapper for PHP Session functionality
	 * 
	 * PHP Sessions:          http://www.php.net/manual/en/book.session.php 
	 * PHP Session Functions: http://www.php.net/manual/en/ref.session.php
	 * 
	 * Not all of these functions are implemented in this Session class, 
	 * only the ones I find useful. For example, setting a name of Session
	 * cookie is done through Settings class, so there is no need to change
	 * Session cookie name through this class.
	 * 
	 * @package    Http
	 * @author     Matija Božić <matijabozic@gmx.com>
	 * @license    MIT - http://opensource.org/licenses/MIT
	 */
	
	namespace Core\Http;
	use Core\Http\SessionInterface;
	
	class Session implements SessionInterface
	{
		/**
		 * Starts new or resumes existing session
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function start()
		{
			if(session_start()) {
				return true;
			}
			return false;
		}
		
		/**
		 * End existing session, destroy, unset and delete session cookie
		 * 
		 * @access  public
		 * @return  void
		 */
		
		public function end()
		{
			if($this->status != true) {
				$this->start();
			}
			
			session_destroy();
			session_unset();
			setcookie(session_name(), null, 0, "/");
		}
		
		/**
		 * Set new session item
		 * 
		 * @access  public
		 * @param   mixed
		 * @param   mixed
		 * @return  mixed
		 */
		
		public function set($key, $value)
		{			
			return $_SESSION[$key] = $value;
		}

		/**
		 * Checks if session key is already set
		 * 
		 * @access  public
		 * @param   mixed  - session key
		 * @return  bool 
		 */
		
		public function has($key)
		{
			if(isset($_SESSION[$key])) {
				return true;
			}
			
			return false;
		}	
		
		/**
		 * Get session item
		 * 
		 * @access  public
		 * @param   mixed
		 * @return  mixed
		 */
		
		public function get($key)
		{
			if(!isset($_SESSION[$key])) {
				return false;
			}
			
			return $_SESSION[$key];			
		}		
		
		/**
		 * Return all session items as array
		 * 
		 * @access  public
		 * @return  array
		 */
		
		public function getAll()
		{
			$sessions = array();
			
			foreach($_SESSION as $key => $value) {
				$sessions[$key] = $value;
			}
			
			return $sessions;
		}
		
		/**
		 * Remove session item
		 * 
		 * @access  public
		 * @param   mixed
		 * @return  bool
		 */
		
		public function remove($key)
		{			
			unset($_SESSION[$key]);
			
			if(!isset($_SESSION[$key])) {
				return true;
			}
			
			return false;
		}
		
		/**
		 * Remove all session items
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function removeAll()
		{
			foreach($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			session_unset();
			
			if(sizeof($_SESSION) === 0) {
				return true;
			}
			
			return false;
		}	
		
		/**
		 * Returns encoded session
		 * 
		 * @access  public
		 * @return  string - encoded session
		 */
		
		public function encode()
		{
			return session_encode();
		}			
		
		/**
		 * Decodes session and inserts it into global session variable
		 * 
		 * @access  public
		 * @param   string - encoded session data
		 * @return  bool
		 */
		
		public function decode($data)
		{
			return session_decode($data);
		}	
		
		/**
		 * Set session name
		 * 
		 * @access  public
		 * @param   string
		 * @return  string
		 */
		
		public function setName($name)
		{
			session_name($name);
		}		
		
		/**
		 * Get session cookie name
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getName()
		{
			return session_name();
		}
		
		/**
		 * Set session id
		 * 
		 * @access  public
		 * @param   string
		 * @return  mixed
		 */
		
		public function setId($id)
		{
			return session_id($id);
		}		
				
		/**
		 * Get session id
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getId()
		{
			return session_id();
		}
		
		/**
		 * Update the current session id with a newly generated one 
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function regenerateId()
		{
			return session_regenerate_id(true);
		}
		
		/**
		 * Returns the current session status
		 * 
		 * @access  public
		 * @return  const
		 */
		
		public function status()
		{
			return session_status();
		}
	}

?>