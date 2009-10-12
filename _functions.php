<?php
// ~ _functions.php
// NeoGraph
// @trevorj
// Neoturbine
//

##
## print_r in XML form
##
function print_r_xml($arr,$first=true) {
  $output = "";
  if ($first) $output .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<data>\n";
  foreach($arr as $key => $val) {
    if (is_numeric($key)) $key = "arr_".$key; // <0 is not allowed
    switch (gettype($val)) {
      case "array":
        $output .= "<".htmlspecialchars($key)." type='array' size='".count($val)."'>".
          print_r_xml($val,false)."</".htmlspecialchars($key).">\n"; break;
      case "boolean":
        $output .= "<".htmlspecialchars($key)." type='bool'>".($val?"true":"false").
          "</".htmlspecialchars($key).">\n"; break;
      case "integer":
        $output .= "<".htmlspecialchars($key)." type='integer'>".
          htmlspecialchars($val)."</".htmlspecialchars($key).">\n"; break;
      case "double":
        $output .= "<".htmlspecialchars($key)." type='double'>".
          htmlspecialchars($val)."</".htmlspecialchars($key).">\n"; break;
      case "string":
        $output .= "<".htmlspecialchars($key)." type='string' size='".strlen($val)."'>".
          htmlspecialchars($val)."</".htmlspecialchars($key).">\n"; break;
      default:
        $output .= "<".htmlspecialchars($key)." type='unknown'>".gettype($val).
          "</".htmlspecialchars($key).">\n"; break;
    }
  }
  if ($first) $output .= "</data>\n";
  return $output;
}

##
## print_r in HTML with COOL JS oooh.
##
function print_r_html($arr, $style = "display: none; margin-left: 10px;") {
  static $i = 0; $i++;
  echo "\n<div id=\"array_tree_$i\" class=\"array_tree\">\n";
  foreach($arr as $key => $val)
  { switch (gettype($val))
    { case "array":
        echo "<a onclick=\"document.getElementById('";
        echo "array_tree_element_".$i."').style.display = ";
        echo "document.getElementById('array_tree_element_$i";
        echo "').style.display == 'block' ?";
        echo "'none' : 'block';\"\n";
        echo "name=\"array_tree_link_$i\" href=\"#array_tree_link_$i\">".htmlspecialchars($key)."</a><br />\n";
        echo "<div class=\"array_tree_element_\" id=\"array_tree_element_$i\" style=\"$style\">";
        echo print_r_html($val);
        echo "</div>";
      break;
      case "integer":
        echo "<b>".htmlspecialchars($key)."</b> => <i>".htmlspecialchars($val)."</i><br />";
      break;
      case "double":
        echo "<b>".htmlspecialchars($key)."</b> => <i>".htmlspecialchars($val)."</i><br />";
      break;
      case "boolean":
        echo "<b>".htmlspecialchars($key)."</b> => ";
        if ($val)
        { echo "true"; }
        else
        { echo "false"; }
        echo  "<br />\n";
      break;
      case "string":
        echo "<b>".htmlspecialchars($key)."</b> => <code>".htmlspecialchars($val)."</code><br />";
      break;
      default:
        echo "<b>".htmlspecialchars($key)."</b> => ".gettype($val)."<br />";
      break; }
    echo "\n"; }
  echo "</div>\n";
}

?>
