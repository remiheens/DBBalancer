<?php

namespace DBBalancer\Tests;

use \DBBalancer\DBBalancer;
use \DBBalancer\DBServer;

class DBBalancerTest extends \PHPUnit_Framework_TestCase
{
	public function testAddReadServerIsTrue()
	{
		$dbbalancer = new DBBalancer();

		$dbserver = new DBServer('localhost',3306,'root','');
		$add = $dbbalancer->addReadServer($dbserver);
		$this->assertTrue($add);
	}

	public function testAddWriteServerIsTrue()
	{
		$dbbalancer = new DBBalancer();
		$dbserver = new DBServer('localhost',3306,'root','');
		$add = $dbbalancer->addWriteServer($dbserver);
		$this->assertTrue($add);
	}

	public function testPickReadIsDBServerInstance()
	{
		$dbbalancer = new DBBalancer();
		$dbbalancer->addWriteServer(new DBServer('localhost',3306,'root',''));
 		$dbbalancer->addReadServer(new DBServer('localhost',3306,'root',''));

		$this->assertInstanceOf('DBBalancer\DBServer',$dbbalancer->pickRead());
	}

	public function testPickWriteIsDBServerInstance()
	{
		$dbbalancer = new DBBalancer();
		$dbbalancer->addWriteServer(new DBServer('localhost',3306,'root',''));
 		$dbbalancer->addReadServer(new DBServer('localhost',3306,'root',''));

		$this->assertInstanceOf('DBBalancer\DBServer',$dbbalancer->pickRead());
	}

}
?>