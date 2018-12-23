<?php
interface IConnectInfo
{
	const HOST = "99-WORKER\SQLEXP";
	const UNAME = "sa";
	const PW = "P@ssw0rd";

	const DBNAME = "SubvMngI1";
	
	public static function doConnect($test);
}
?>