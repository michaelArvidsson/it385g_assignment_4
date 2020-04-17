<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Newspaper article database</title>
  <style>
  body {
      background-color: slategray;
      margin:0px;
    }
    #head {
        background-color: #e2ddeb;;
        color:darkslategrey;
        font-size: 200%;
        font-weight: bold;
        letter-spacing: 5px;
        text-align: center;
        text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
        padding:10px;
        margin-top:0px;
        margin-bottom:20px;
    }
  form {
        width:600px;
        background-color: #e2ddeb;
        padding:50px;
        margin:auto;      
        box-shadow: 2px 2px 4px 2px;
    }
  #form_body {
        Width:400px;
        margin:auto;
        font-weight:bold;
        font-size:15px;
    }
    label {
      margin-right:10px;
    }
  </style>
</head>
<body>
    <h1 id='head'>Newspaper article database</h1>
    <form method="POST" action="response_it385g_assignment_4.php" >
    <div id=form_body>
    <label>Select Your newspaper </label><select name='NEWSPAPER'>
<?php                                                                                                                                                 
        echo "<option value=''>---";
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
<input style='margin-left:10px'; type='submit' name='submitbutton' value='Submit!'>
</div>          
</body>
</html>