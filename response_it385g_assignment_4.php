<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
    table {
      background-color: #e2ddeb;
      margin: auto;
      border-collapse: collapse;
    }
    #tbl {
      box-shadow: 2px 3px 3px 2px;
    }
    th {
      font-size: 25px;
      padding:0px;
    }
    #article {
      width: 500px;
      /* border: 1px solid black; */
      margin: 10px;
      padding: 10px;
      box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2), 0px 5px 15px 0px rgba(0, 0, 0, 0.6);
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
      margin-bottom:0px;
      margin-top:10px;
    }
    h4 {
      color:darkslategrey;
    }
    p {
      color: darkslategrey;
      box-shadow: 0px 0px 3px 0px grey;
      margin-top:0px;
      margin-bottom: 20px;
    }  
  </style>
</head>
<body>
<h1 id='head'>Newspaper article database</h1>
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

    function startElement($parser, $entityname, $attributes){
      global $lastelement;
      if ($entityname == "ARTICLES") {
      } else if ($entityname == "NEWSPAPER") {
          echo "<tr>";
          echo "<td style='padding:5px; border-right:0px;'>";
          echo "<h4 style='transform: rotate(-90deg); font-size: 25px;'>";
          echo $attributes['NAME'];
          echo "</td>"; 
          echo "<td style='padding:5px; border-right:0px;'>";
          echo "<h4 style='white-space:nowrap;'>Subscribers: ";
          echo $attributes['SUBSCRIBERS'];
          echo "<h4 style='white-space:nowrap;'>Edition: ";
          echo $attributes['TYPE'];
          echo "<td style='border-left:0px;'><table>";
      } else if ($entityname == "ARTICLE") {
        //conditional styling
          if($attributes['DESCRIPTION']=="News"){
                echo "<tr style='background:#b3cdf5;' >";          
          }else{
                echo "<tr style='background:#acd1a7;' >";          
          }
          echo "<td style='padding:5px; border:1px solid black;'>";
          echo "<span style='color:darkslategrey; margin-left:15px;margin-right:160px;'>";
          echo $attributes['DESCRIPTION'];
          echo "</span>";
          echo "<span style='color:darkslategrey; margin-right:auto; margin-left:auto;'>";
          echo $attributes['TIME'];
          echo "</span>";
          echo "<span style='color:darkslategrey; margin-left:150px;'>ID: ";
          echo $attributes['ID'];
          echo "</span>";
          echo"<div id='article'>";
      } else if ($entityname == "HEADING") {
          echo "<h3>";
      } else if ($entityname == "STORY") {
          echo "<p>";
      }
      if($entityname!="TEXT") $lastelement=$entityname;
    }
      
    function endElement($parser, $entityname){
      if ($entityname == "NEWSPAPER") {
          echo "</div></table></td></tr>";
      } else if ($entityname == "NAME") {
          echo "</h4>";
      } else if ($entityname == "TYPE") {
          echo "</h4>";
      } else if ($entityname == "SUBSCRIBERS") {
          echo "</h4></td>";
      } else if ($entityname == "ARTICLE") {
          echo "</td></tr>";
      } else if ($entityname == "HEADING") {
          echo "</h3>";
      } else if ($entityname == "STORY") {
          echo "</p>";
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