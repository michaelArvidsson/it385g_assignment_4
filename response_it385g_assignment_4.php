<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <pre>
<table border='1'>
<?php                                                                                                                                                 
    if (isset($_POST['NEWSPAPER'])) {
      $edition = $_POST['NEWSPAPER'];
    } else {
      $edition ="";
    } 
    print_r($_POST);
    //print_r($edition);
    function startElement($parser, $entityname, $attributes) {
      if($entityname=="ARTICLE"){
        echo "<tr>";
        echo "<td>".$attributes['ID']."</td>";
        echo "<td>".$attributes['TIME']."</td>";
        echo "<td>".$attributes['DESCRIPTION']."</td>";
        echo "<td><table>";
      }else if($entityname==""){
        echo "<tr>";
        echo "<td>".$attributes['TYPE => Morning_edition']."</td>";
        echo "<td><table>";      
    }
     //echo $entityname;
     }
     
    function endElement($parser, $entityname) {
      if($entityname=="ARTICLE"){
        echo "</table></td>";
        echo "</tr>";
      }else if($entityname==""){
        echo "</td></tr>";
      }
     }
     
    function charData($parser, $chardata) {
     }
     
     $parser = xml_parser_create();
     xml_set_element_handler($parser, "startElement", "endElement");
     xml_set_character_data_handler($parser, "charData");
     
     $url="https://wwwlab.iit.his.se/gush/XMLAPI/articleservice/articles?paper=".$edition;
     $data = file_get_contents($url);
     
     if(!xml_parse($parser, $data, true)){
     printf("<P> Error %s at line %d</P>", xml_error_string(xml_get_error_code($parser)),xml_get_current_line_number($parser));
     }else{
     // print "<br>Parsing Complete!</br>";
     }
     
     xml_parser_free($parser);
      
     ?>
</table>
    </pre>                                                                                                                  
</body>
</html>