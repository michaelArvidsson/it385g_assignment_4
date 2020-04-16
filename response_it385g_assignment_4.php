<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body {
      background-color: slategray;
    }
    table {
      background-color: #e2ddeb;
      margin: auto;
    }

    #tbl {
      box-shadow: 2px 3px 3px 2px;
    }
    th {
      font-size: 25px;
      padding:0px;
    }
    div {
      width: 500px;
      /* border: 1px solid black; */
      margin: 10px;
      padding: 10px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.5);
    }
    #tbl2 {
      font-weight:normal;
      font-size:15px;
      text-decoration: underline;
    }
    h3 {
      color: darkslategray;
      text-align:center;
      text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
    }
    p {
      color: darkslategrey;
      box-shadow: 0px 0px 3px 0px grey;
      margin-top:0px;
      margin-bottom: 10px;
    }
    
  </style>
</head>
<body>
<table id=tbl border='1'>
<?php
    //check value from form
    if (isset($_POST['NEWSPAPER'])) {
        $edition = $_POST['NEWSPAPER'];
    } 
    // check if empty value
    if (empty($edition)) {
        $edition = "Morning_Edition";
    }

    $lastelement="";

    echo "<tr><th>Name</th><th>Subscribers</th><th>Type</th><th>Article</th></tr>";
    function startElement($parser, $entityname, $attributes){
      global $lastelement;
      if ($entityname == "ARTICLES") {
      } else if ($entityname == "NEWSPAPER") {
          echo "<tr>";
          echo "<td style='font-weight:bold; padding:5px;'>";
          echo $attributes['NAME'];
          echo "</td>";
          echo "<td style='font-weight:bold; padding:5px;'>";
          echo $attributes['SUBSCRIBERS'];
          echo "</td>";
          echo "<td style='font-weight:bold; padding:5px;'>";
          echo $attributes['TYPE'];
          echo "</td>";
          echo "<td><table>";
          echo "<tr><th id='tbl2'>ID</th><th id='tbl2'>Description</th><th id='tbl2'>Article name</th></tr>";
      } else if ($entityname == "ARTICLE") {
        //conditional styling
          if($attributes['DESCRIPTION']=="News"){
                echo "<tr style='background:#b3cdf5;' >";          
          }else{
                echo "<tr style='background:#acd1a7;' >";          
          }
          echo "<td style='padding:5px; border:1px solid black;'>";
          echo $attributes['ID'];
          echo "</td>";
          echo "<td style='text-align:center; border:1px solid black;'>";
          echo $attributes['DESCRIPTION'];
          echo "</td>";
          echo "<td style='border:1px solid black;'>";
      } else if ($entityname == "HEADING") {
          echo "<h3>";
      } else if ($entityname == "STORY") {
          echo "<div><p>";
      }
      if($entityname!="TEXT") $lastelement=$entityname;
    }
      
    function endElement($parser, $entityname){
      if ($entityname == "NEWSPAPER") {
          echo "</table></td></tr>";
      } else if ($entityname == "ARTICLE") {
          echo "</td></tr>";
      } else if ($entityname == "HEADING") {
          echo "</h3>";
      } else if ($entityname == "STORY") {
          echo "</p></div>";
      }
    }

    function charData($parser, $chardata){
      global $lastelement;
      $chardata = trim($chardata);
      if ($chardata == "") return;
      if($lastelement=="STORY"){
        echo"<p style='color:darkslategrey;'>".$chardata."</p>";
        }
      else{
      echo $chardata;
      }
    }

    $parser = xml_parser_create();
    xml_set_element_handler($parser, "startElement", "endElement");
    xml_set_character_data_handler($parser, "charData");

    $url = "https://wwwlab.iit.his.se/gush/XMLAPI/articleservice/articles?paper=" . $edition;
    $data = file_get_contents($url);

    if (!xml_parse($parser, $data, true)) {
      printf("<P> Error %s at line %d</P>", xml_error_string(xml_get_error_code($parser)), xml_get_current_line_number($parser));
    } else {
      // print "<br>Parsing Complete!</br>";
    }

    xml_parser_free($parser);

?>
</table>
</body>

</html>