<?php

namespace DBBalancer;

class DBBalancer {
	
	private $servers;

	public function __construct($servers = array())
	{
		$this->servers = array(
			'read' => array(),
			'write' => array()
		);

		if(isset($servers['read']) && !empty($servers['read']))
		{
			foreach($servers['read'] as $entry)
			{
				if(true === $this->_verifyServer($entry))
				{
					$this->servers['read'][] = $entry;
				}
			}
		}

		if(isset($servers['write']) && !empty($servers['write']))
		{
			foreach($servers['write'] as $entry)
			{
				if(true === $this->_verifyServer($entry))
				{
					$this->servers['write'][] = $entry;
				}
			}
		}
	}

	public function addReadServer(DBServer $server)
	{
		return $this->_addServer($server, 'read');
	}

	public function addWriteServer(DBServer $server)
	{
		return $this->_addServer($server, 'write');
	}

	public function pickRead()
	{
		return $this->_pick('read');
	}

	public function pickWrite()
	{
		return $this->_pick('write');
	}

	private function _pick($type)
	{
		$server = null;
		if(isset($type) && ($type === 'read' || $type === 'write'))
		{
			if(count($this->servers[$type]) > 0 )
			{
				$servers = $this->_shuffle($this->servers[$type]);
				$key = array_rand($servers);
				$server = $servers[$key];
			}

		}
		return $server;
	}

	private function _shuffle($servers)
	{

		$size = count($servers);
		$server = null;
		for($i = 0; $i < $size; $i++) {
			$server = $servers[$i];
			for ($weight = 1; $weight < $server->getWeight(); $weight++) {
				$servers[] = $server;
			}
		}
		shuffle($servers);
		return $servers;
	}

	private function _addServer($server,$type)
	{
		$flag = false;
		if(true === $this->_verifyServer($server))
		{
			$this->servers[$type][] = $server;
			$flag = true;
		}
		return $flag;
	}

	private function _verifyServer($server)
	{
		if(false === ($server instanceof DBServer))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
