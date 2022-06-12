<?php

    /**
     * This file is part of MVC Core framework
     * (c) Matija Božić, www.matijabozic.com
     * 
	 * This is Route class, represents matched route.
	 * 
	 * @package    Router
	 * @author     Matija Božić <matijabozic@gmx.com>
	 * @license    
     */

	namespace Core\Router;
	
	class Route
	{
		/**
		 * Route class
		 * 
		 * @access  protected
		 * @var     string
		 */
		 
		protected $class;
		
		/**
		 * Route method
		 * 
		 * @access  protected
		 * @var     string
		 */
		 
		protected $method;
	
		/**
		 * Routes method arguments
		 * 
		 * @access  protected
		 * @var     array
		 */
	
		protected $args;	
		
		/**
		 * Route constructor
		 * 
		 * @access  public
		 * @param   string
		 * @param   string
		 * @param   array
		 */
		
		public function __construct($class, $method, array $args = array())
		{
			$this->class = $class;
			$this->method = $method;
			$this->args = $args;
		}
		
		/**
		 * Set route class
		 * 
		 * @access  public
		 * @param   string
		 * @return  void
		 */
		
		public function setClass($class)
		{
			$this->class = $class;
		}
		
		/**
		 * Get route class
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getClass()
		{
			return $this->class;
		}
		
		/**
		 * Check if route class is set
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function hasClass()
		{
			if(isset($this->class)) {
				return true;	
			}
			return false;
		}
		
		/**
		 * Set route method
		 * 
		 * @access  public
		 * @param   string
		 * @return  void
		 */
		
		public function setMethod($method)
		{
			$this->method = $method;
		}
		
		/**
		 * Get route method
		 * 
		 * @access  public
		 * @return  string
		 */
		
		public function getMethod()
		{
			return $this->method;
		}
		
		/**
		 * Check if route method is set
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function hasMethod()
		{
			if(isset($this->method)) {
				return true;
			}
			return false;
		}
		
		/**
		 * Set route method arguments
		 * 
		 * @access  public
		 * @param   array
		 * @return  void
		 */
		
		public function setArgs(array $args)
		{
			$this->args = $args;	
		}
		
		/**
		 * Get route method arguments
		 * 
		 * @access  public
		 * @return  array
		 */
		
		public function getArgs()
		{
			return $this->args;
		}
		
		/**
		 * Check if route method arguments is set
		 * 
		 * @access  public
		 * @return  bool
		 */
		
		public function hasArgs()
		{
			if(isset($this->args)) {
				return true;	
			}
			return false;
		}
		
		/**
		 * Add additional argument to args
		 * 
		 * @access  public
		 * @param   string
		 * @param   mixed
		 * @return  void
		 */
		
		public function addArg($name, $value)
		{
			$this->args[$name] = $value;
		}
	}

?>