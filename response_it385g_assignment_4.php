<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
  div {
    width:500px;
    
    border:1px solid black;
  }
  h3 {
    color:lightcoral;
    width:300px;
  }
  </style>
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
    //echo "<tr><th>Name</th><th>Type</th><th>Article</th>><th>DESCRIPTION</th><th>Article</th></tr>";
    function startElement($parser, $entityname, $attributes) {
      if($entityname=="ARTICLES"){
      }else if($entityname=="NEWSPAPER"){
        echo "<tr>";
        echo "<td>";
        echo $attributes['NAME'];
        echo "</td>";
        echo "<td>";
        echo $attributes['TYPE'];
        echo "</td>";
        echo "<td><table>";      
      }else if($entityname=="ARTICLE"){
        echo "<tr>";
        echo "<td>";
        echo $attributes['ID'];
        echo "</td>";
        echo "<td>";
        echo $attributes['DESCRIPTION'];
        echo "</td>";
        echo "<td>";
      }else if($entityname=="HEADING"){
        echo "<h3>";
      }else if($entityname=="STORY"){
        echo "<div>";
      }
     //echo $entityname;
     }
     
    function endElement($parser, $entityname) {
      if($entityname=="NEWSPAPER"){
        echo "</table></td></tr>";
      }else if($entityname=="ARTICLE"){
        //echo "</td><td><table>";
        echo "</td></tr>";
      }else if($entityname=="HEADING"){  
          echo "</h3>";
      }else if($entityname=="STORY"){  
        echo "</div>";
      }
    }
     
    function charData($parser, $chardata) {
      $chardata=trim($chardata);
       if($chardata=="") return; 
       echo $chardata;
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