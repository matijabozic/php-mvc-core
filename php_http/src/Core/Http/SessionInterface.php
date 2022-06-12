<?php

	namespace Core\Http;

	interface SessionInterface
	{
		public function start();
		public function end();
		public function set($key, $value);
		public function has($key);
		public function get($key);
		public function getAll();
		public function remove($key);
		public function removeAll();
		public function encode();
		public function decode($data);
		public function setName($name);	
		public function getName();
		public function setId($id);
		public function getId();
		public function regenerateId();
		public function status();
	}

?>