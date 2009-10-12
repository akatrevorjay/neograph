<?php
// ~ _data.php
// NeoGraph
// @trevorj
// Neoturbine
//
include '_data.php';

function print_neato ($users, $chans, $map) {
	$ret = "graph G {\n";
	$ret .= "overlap=false;\n";
	#"overlap=ortho,fontsize=2,splines=compound;\n";
	
	foreach ($map as $chanid => $chan_users) {
		$c = $chans[ $chanid ];

		$opts = "shape=egg,";
		($c[currentusers]  > 0) &&
			$opts .= "style=filled,";

		$ret .= "\t\"" . $c[channel] . "\" ["
			. substr($opts, 0, -1)
			."];\n";

		foreach (array_keys($chan_users) as $nickid) {
			$u = $users[ $nickid ];

			$opts = 'fontcolor='
				.( ($u[mode_lo] == 'Y' && $u[online] == 'Y') ?
				'green' : ( ($u[online] == 'N') ? 'grey' : 'black') )
				. ',';
			$opts .= 'shape=none';

			$ret .= "\t\t\"" . $u[nick] . "\" [$opts];\n";
			$ret .= "\t\t\"" . $u[nick] . "\" -- \""
				. $c[channel] . "\";\n";
		}
	}
	
	$ret .= "}\n";
	return $ret;
}

# backasswards-compat
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
	print "<pre>".print_neato($data[users], $data[channels], $data[ison][channels])."</pre";
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
	print print_neato($data[users], $data[channels], $data[ison][channels]);
	break;
}

?>
