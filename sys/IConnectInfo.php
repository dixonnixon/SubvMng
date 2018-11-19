<?php
interface IConnectInfo
{
	const HOST = "99-WORKER\SQLEXP";
	const UNAME = "sa";
	const PW = "xxx";

	const DBNAME = "SubvMng";
	
	public static function doConnect($test);
}
?>