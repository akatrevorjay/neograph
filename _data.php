<?php
// ~ _data.php
// NeoGraph
// @trevorj
// Neoturbine
//
include '_functions.php';
include '_config.php';

/* check connection */
if (mysqli_connect_errno()) {
#    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

#users
if ($result = $mysqli->query(
	"SELECT u.nickid,u.nick,u.online,u.servid,u.mode_lo FROM user AS u")) {
	while ($row = $result->fetch_assoc()) {
		$nickid = $row[nickid];
		unset($row[nickid]);

		// remove crappy chars
		$row[nick] = preg_replace('/[^a-z0-9_]/i', '_', $row[nick]);
		// 30 char max
		$row[nick] = substr($row[nick], 0, 30);

		$data[users][ $nickid ] = $row;
	}
}

#channels
if ($result = $mysqli->query("SELECT chanid,channel,currentusers FROM chan AS c")) {
	while ($row = $result->fetch_assoc()) {
		$chanid = $row[chanid];
		unset($row[chanid]);

		$data[channels][ $chanid ] = $row;
	}
}

#servers
if ($result = $mysqli->query("SELECT servid, server, linkedto, currentusers, online FROM server AS s")) {
	while ($row = $result->fetch_assoc()) {
		$servid = $row[servid];
		unset($row[servid]);

		$data[servers][ $servid ] = $row;
	}
}

#ison
if ($result = $mysqli->query("SELECT nickid, chanid FROM ison AS i")) {
	while ($row = $result->fetch_assoc()) {
		#$data[ison][raw][] = $row;
		$data[ison][users][ $row[nickid] ][ $row[chanid] ] = 1;
		$data[ison][channels][ $row[chanid] ][ $row[nickid] ] = 1;
	}
}

$mysqli->close();

#var_dump($data);
#var_dump($data[servers]);
#exit;

switch ($_REQUEST['data_type']) {
case 'html':
	print_r_html($data);
	break;
case "xml":
	Header("Content-Type: text/xml");
	print print_r_xml($data);
	break;
case "print":
case "print_r":
	print "<pre>";
	print_r($data);
	print "</pre>";
	break;
case "serialize":
case "php":
	print serialize($data);
	break;
}

?>
