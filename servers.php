<?php
// ~ _data.php
// NeoGraph
// @trevorj
// Neoturbine
//
include '_data.php';

function print_neato ($servers) {
	$ret = "graph G {\n";
	$ret .= "overlap=false;\n";
	#"overlap=ortho,fontsize=2,splines=compound;\n";
	
	foreach ($servers as $servid => $s) {
		$ls = $servers[ $s[linkedto] ];

		($s[currentusers] > 0) &&
			$opts .= "shape=egg,style=filled,";
		($s[online] == 'N') &&
			$opts .= "style=filled,fillcolor=red,";

		$ret .= "\t\"".$s[server]."\" [".substr($opts, 0, -1)."];\n";
		unset($opts);

		if (isset($servers[ $s[linkedto] ])) {
			$ret .= "\t\"".$s[server]."\" -- \"".$ls[server]."\";\n";
		}
	}
	
	$ret .= "}\n";
	return $ret;
}

# backwards-compat
if (isset($_REQUEST['type'])) {
	$_REQUEST['format'] = $_REQUEST['type'];
}

switch ($_REQUEST['format']) {
case "html":
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
case "pre":
	echo "<pre>";
default:
	print print_neato($data[servers]);
	break;
}

?>
