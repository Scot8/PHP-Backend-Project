<?php

// http://localhost/ScottRohanCodingAsst/asstInclude.php


require_once("./clsDeleteSunglassRecord.php");
function WriteHeaders(/*$Heading="Welcome",$TitleBar="MySite"*/)
{
echo "
   <!doctype html>
   <html lang- \"en\">
   <head>
       <meta charset = \"UTF-8\">
       <link rel =\"stylesheet\" type = \"text/css\" href=\"styles.css\"/>
   </head>
   <body>\n

   ";
}
function DisplayLabel($for, $prompt)
{
    if ($for == "")
    echo "<label>".$prompt."</label>";
    else
    echo "<label = \"$for\">".$prompt."</label>";
}
function DisplayTextbox($htmltype, $id, $Name, $Size, $Value=0)
{
    
    
    
    if ($htmltype == "radio" && $id == "radio1")
    echo" <input type = \"$htmltype\" id = \"$id\" name = \"$Name\" Size = $Size value =  \"$Value\" checked>";
    
    else    
    echo" <input type = \"$htmltype\" id = \"$id\" name = \"$Name\" Size = $Size value =  \"$Value\">";

  
    //echo" <input type = date name = \"$Name\" Size = $Size value =  \"$Value\" CHECKED>";
   


     
        /*echo" <input type = radio name=\"age1\" value= \"$Value\" CHECKED>";
  //<label for="age1">5 MP</label><br>
  echo "<input type = radio name = \"age\" value = \"$Value\">";
  //<label for="age2">10 MP</label><br>  
  echo "<input type= radio name= \"age2\" value = \"$Value\">";*/
  

   
    //echo" <input type = color name = \"$Name\" Size = $Size value =  \"$Value\">";


}
function DisplayImage($Filename, $alt, $height, $width)
{
    echo "<img src = \"$Filename\" height=\"$height\" width=\"$width\" alt=\"$alt\"/>";
}

function DisplayButton($Name, $text, $Filename = "", $alt = ""){

    
    if($Filename == "")
    {  
        echo "<button type=Submit name=\"$Name\">$text</button>";
    }
    else
    {
        echo "<button type=Submit name=\"$Name\">$text";
        echo DisplayImage($Filename,$alt,40,100);
        echo"</button>";

    }


}
function DisplayContactInfo()
{
    echo "<a href = mailto:rohanjamesscott@student.sl.on.ca>rohanjamesscott@student.sl.on.ca</a>";
}
function WriteFooters()
{

    echo "</body>\n";
    echo "</html>\n";
}

function CreateConnectionObject()
{
    $fh = fopen('auth.txt','r');
    $Host =  trim(fgets($fh));
    $UserName = trim(fgets($fh));
    $Password = trim(fgets($fh));
    $Database = trim(fgets($fh));
    $Port = trim(fgets($fh)); 
    fclose($fh);
    $mysqlObj = new mysqli($Host, $UserName, $Password,$Database,$Port);
    // if the connection and authentication are successful, 
    // the error number is 0
    // connect_errno is a public attribute of the mysqli class.
    if ($mysqlObj->connect_errno != 0) 
    {
     echo "<p>Connection failed. Unable to open database $Database. Error: "
              . $mysqlObj->connect_error . "</p>";
     // stop executing the php script
     
     exit;
    }
    return ($mysqlObj);
}

?>








