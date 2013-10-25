<?php

namespace DBBalancer\Tests;

use \DBBalancer\DBServer;

class DBServerTest extends \PHPUnit_Framework_TestCase
{
	
	public function testGetWeight()
	{
		$dbserver = new DBServer('localhost',3306,'root','');
		$this->assertEquals(1,$dbserver->getWeight());
	}

	public function testGetPort()
	{
		$dbserver = new DBServer('localhost',3306,'root','');
		$this->assertEquals(3306,$dbserver->getPort());
	}

	public function testGetHost()
	{
		$dbserver = new DBServer('localhost',3306,'root','');
		$this->assertEquals('localhost',$dbserver->getHost());
	}

	public function testGetUser()
	{
		$dbserver = new DBServer('localhost',3306,'root','');
		$this->assertEquals('root',$dbserver->getUser());
	}
	public function testGetPassword()
	{
		$dbserver = new DBServer('localhost',3306,'root','');
		$this->assertEquals('',$dbserver->getPassword());
	}

}

?>