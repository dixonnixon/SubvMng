<?php
interface IConnectInfo
{
	const HOST = "srv1800db02";
	const UNAME = "sa";
	const PW = "1[H.yltkm$";

	const DBNAME = "SubvMng";
	
	public static function doConnect($test);
}
?>