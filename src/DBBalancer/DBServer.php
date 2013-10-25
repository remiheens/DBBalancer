<?php

namespace DBBalancer;

class DBServer
{
	private $host;
	private $port;
	private $user;
	private $password;
	private $weight;

	public function __construct($host, $port, $user, $password, $weight = 1)
	{
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->password = $password;
		$this->weight = $weight;
	}

	public function getWeight()
	{
		return $this->weight;
	}

	public function getHost()
	{
		return $this->host;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getPort()
	{
		return $this->port;
	}

	public function __toString()
	{
		return '['.$this->user.'@'.$this->host.']';
	}
}