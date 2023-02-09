
<?php
// http://localhost/ScottRohanCodingAsst/asstMain.php 
require_once ("./asstInclude.php");
require_once("clsDeleteSunglassRecord.php");



function displayMainForm()
{
    echo"<form action = ? method=post>";
    echo DisplayButton("f_CreateTable", "","img\createtable.png"); 
    echo DisplayButton("f_AddRecord", "","img\addrecord.png"); 
    echo DisplayButton("f_DeleteRecord", "","img\deleterecord.png"); 
    echo DisplayButton("f_DisplayData", "","img\displaydata.png");
    echo"</form>";
}


function createTableForm($mysqlObj, $TableName) //working
{
echo"<form action = ? method=post>";
$BrandName = "BrandName varchar(10)";
$DateManufactured = "DateManufactured date";
$Camera = "Camera Int";
$Colour = "Colour varchar(15)";
$stmt = $mysqlObj->prepare("DROP TABLE IF EXISTS $TableName");
$stmt->execute();
$stmt = $mysqlObj->prepare("Create Table $TableName($BrandName, 
    $DateManufactured, $Camera, $Colour, primary key (BrandName))");
if ($stmt == false) 
{	
    echo "Prepare failed on query $stmt";
    exit;
}
$CreateResult = $stmt->execute();
if ($CreateResult) 
    echo "$TableName table created.";
else
    echo "Can't create table $TableName. Execute failed: 
        (" . $stmt->errno . ") " . $stmt->error;

$stmt->close();
echo "<br>";

    echo DisplayButton("f_Home", "","img\home.png");
    echo"</div>";
    echo "</form>";
}

function addRecordForm($mysqlObj, $TableName)
{
    echo "<form action = ? method=post>";
    echo "<div class=\"datapair\">";
    DisplayLabel("", "Brand Name");
    DisplayTextbox("text", "", "f_BrandName",15,"Benz");
    echo"</div>";

    echo "<div class=\"datapair\">";
    DisplayLabel("","Date");
    DisplayTextbox("date","" ,"f_Date", 10,"2011-12-12");
    echo"</div>";

    echo "<div class=\"datapair\">";
    DisplayLabel("", "Camera");

    DisplayTextbox("radio","radio1", "f_Camera", 35, "5MP");
    DisplayLabel("radio1"," 5MP");
    
    DisplayTextbox("radio","radio2", "f_Camera", 35, "10MP");
    DisplayLabel("radio2", " 10MP");
    echo"</div>";


    echo "<div class=\"datapair\">";
    DisplayLabel("", "Select colour");
    DisplayTextbox("color", "colour","f_Colour","#ff0000");
    echo"</div>";


    echo DisplayButton("f_Save", "","img\save.png");
    echo DisplayButton("f_Home", "","img\home.png"); 

    echo"</form>";

}

function saveRecordToTableForm($mysqlObj, $TableName)
{
    echo"<form action = ? method=post>";
    $BrandName = $_POST["f_BrandName"];
    $DateManufactured = $_POST["f_Date"];
    $Camera = $_POST["f_Camera"];
    $Colour = $_POST["f_Colour"];



    
$stmt = $mysqlObj->prepare("INSERT INTO $TableName VALUES (?,?,?,?)");
    $stmt->bind_param("ssis",  
    $BrandName, $DateManufactured, $Camera, $Colour);
    if ($stmt->execute()) 
        echo "<p>Record successfully added to Sunglasses</p>";
    else
        echo "<p>Unable to add record to Sunglasses: (" . $stmt->errno . ") " . 
        $stmt->error . "</p>";
    $stmt->close();



    echo DisplayButton("f_Home","","img\home.png"); 
    echo"</form>";


}

function DisplayDataForm($mysqlObj,$TableName)
{
echo"<form action = ? method=post>";


$SelectString = "Select * from $TableName "; 
$stmt = $mysqlObj->prepare($SelectString) ; 
$stmt->bind_result($BrandName, $DateManufactured, $Camera, $Colour);

    echo "<table border='1'>
    <tr>
    <th>BrandName</th>
    <th>DateManufactured</th>
    <th>Camera</th>
    <th>Colour</th>
    </tr>";


$stmt->execute();
while ($stmt->fetch())

        {
        echo "<tr>";
        echo "<td>" . $BrandName . "</td>";
        echo "<td>" . $DateManufactured . "</td>";
        echo "<td>" . $Camera . "</td>";
        echo "<td>" . $Colour . "</td>";
        echo "</tr>";
        }



    $stmt->close();
    echo DisplayButton("f_Home", "","img\home.png"); 
    echo"</form>";
}

function deleteRecordForm($mysqlObj,$TableName)
{
    echo "<form action = ? method=post>";
echo "<div class=\"datapair\">";

    DisplayLabel("", "The deletion is final");
    DisplayTextbox("text", "brand", "f_BName",15,"");
    
    echo "<br>";
    echo DisplayButton("f_IssueDelete", "","img\delete.png"); 
    echo "\n";
    echo DisplayButton("f_Home", "","img\home.png"); 

    echo"</form>";
    echo"</div>";


}

function IssueDeleteForm($mysqlObj,$TableName)
{
    echo "<form action = ? method=POST>";
    echo "<div class=\"datapair\">";

    $brandName = $_POST["f_BName"];

    $classDelete = new clsDeleteSunglassRecord();

    $returnClass = $classDelete->deleteTheRecord($mysqlObj, $TableName, $brandName);
    if($returnClass > 0)
    echo "<p>". $brandName . " record deleted \n";

    if ($returnClass==0)
    echo "<p>". $brandName . " does not exist \n";

    echo DisplayButton("f_Home", "","img\home.png");

    echo"</div>";
    echo"</form>";



}




// main
date_default_timezone_set ('America/Toronto');
$mysqlObj = createConnectionObject(); 
$TableName = "sunglasses"; 

// writeHeaders call  
WriteHeaders();
if (isset($_POST['f_CreateTable']))
createTableForm($mysqlObj,$TableName);

else if (isset($_POST['f_Save'])) saveRecordtoTableForm($mysqlObj,$TableName) ;
else if (isset($_POST['f_AddRecord'])) addRecordForm($mysqlObj,$TableName) ;	   
    else if (isset($_POST['f_DeleteRecord'])) deleteRecordForm($mysqlObj,$TableName) ;	 
        else if (isset($_POST['f_DisplayData'])) displayDataForm ($mysqlObj,$TableName);
        else if (isset($_POST['f_IssueDelete'])) issueDeleteForm ($mysqlObj,$TableName);
            else displayMainForm();
if (isset($mysqlObj)) $mysqlObj->close();
writeFooters();



?>