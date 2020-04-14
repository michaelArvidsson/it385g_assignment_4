<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Newspaper article database</title>
</head>
<body>
  
    <form method="POST" action="response_it385g_assignment_4.php" >
    <select name='NEWSPAPER'>
<?php                                                                                                                                                 
        echo "<option value='Empty_Paper'>---";
    function startElement($parser, $entityname, $attributes) {
      if($entityname=="NEWSPAPER"){
        echo "<option value='".$attributes['TYPE']."'>";
        echo $attributes['NAME'];
    }
    //echo $entityname;
    }

    function endElement($parser, $entityname) {
      if($entityname=="NEWSPAPER"){
        echo "</option>";
    }
    }

    function charData($parser, $chardata) {
    }

    $parser = xml_parser_create();
    xml_set_element_handler($parser, "startElement", "endElement");
    xml_set_character_data_handler($parser, "charData");

    $url="https://wwwlab.iit.his.se/gush/XMLAPI/articleservice/papers";
    $data = file_get_contents($url);

    if(!xml_parse($parser, $data, true)){
    printf("<P> Error %s at line %d</P>", xml_error_string(xml_get_error_code($parser)),xml_get_current_line_number($parser));
    }else{
    // print "<br>Parsing Complete!</br>";
    }

    xml_parser_free($parser);
 
?>
</select>
<button>Submit!</button>
          
</body>
</html>