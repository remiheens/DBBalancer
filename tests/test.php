<?php

spl_autoload_register(function($className){
	$className = ltrim($className, '\\');
	$fileName  = '';
	$namespace = '';
	if ($lastNsPos = strripos($className, '\\'))
	{
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
 
	require '../lib/'.$fileName;
});


use \DBBalancer\DBBalancer;
use \DBBalancer\DBServer;

$balancer = new DBBalancer(array(
	'write' => array(
		new DBServer('192.168.1.11',3306,'remi','imer')
	),
	'read' => array(
		new DBServer('192.168.1.197',3306,'remi','imer',5)
	)
));

$balancer->addReadServer(new DBServer('192.168.1.11',3306,'remi','imer',1));



$server = $balancer->pickRead();
mysql_connect($server->getHost().':'.$server->getPort(), $server->getUser(), $server->getPassword()) or die(mysql_error());
mysql_select_db('remi');
$q = mysql_query('SELECT COUNT(*) as nb FROM post;');
$obj = mysql_fetch_object($q);
mysql_close();

print $obj->nb.' post in db '.(string)$server."\n";

for($i=0;$i<=10000;$i++)
{
	$server = $balancer->pickWrite();
	mysql_connect($server->getHost().':'.$server->getPort(), $server->getUser(), $server->getPassword()) or die(mysql_error());
	mysql_select_db('remi');
	mysql_query('INSERT INTO post(title) VALUES("article #'.$i.'");');
	mysql_close();

	$server = $balancer->pickRead();
	mysql_connect($server->getHost().':'.$server->getPort(), $server->getUser(), $server->getPassword()) or die(mysql_error());
	mysql_select_db('remi');
	$q = mysql_query('SELECT COUNT(*) as nb FROM post;');
	$obj = mysql_fetch_object($q);
	mysql_close();
}

print "test finish\n";