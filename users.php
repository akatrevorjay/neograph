<?php
include '_data.php';

function print_neato ($users, $servers) {
	$ret = "graph G {\n";
	$ret .= "overlap=false;\n";
	#"overlap=ortho,fontsize=2,splines=compound;\n";
	
	foreach ($users as $n => $u) {
		if (!isset($servers[ $u[servid] ])) {
			continue;
		}
		$s = $servers[ $u[servid] ];

		$opts .= 'fontcolor='
			.( ($u[mode_lo] == 'Y' && $u[online] == 'Y') ?
			'green' : (($u[online] == 'N') ? 'grey' : 'black') )
			.',';
		$opts .= 'shape=none';

		$ret .= "\t\"".$u[nick]."\" [$opts];\n";
		unset($opts);

		$ret .= "\t\"".$u[nick]."\" -- \"".$s[server]."\";\n";
			#." -- ".$u[realnick]." <br>";
	}
	
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
case "pre":
	print "<pre>".print_neato($data[users], $data[servers])."</pre";
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
default:
	print print_neato($data[users], $data[servers]);
	break;
}

?>
