<?php     
    include_once("/sql.php");
	if(isset($_POST['addproj']))
{
   	$note=$_POST['note'];
   	$oringinPrice=$_POST['oringinPrice'];
   	$projName=$_POST['projName'];
	$projNo=$_POST['projNo'];
	$b1=addproj($note, $oringinPrice, $projName,$projNo);
	echo json_encode($b1);
}

if(isset($_POST['getprodata']))
{
	$id=$_POST['getprodata'];
	$b1=queryproj($id);
	echo json_encode($b1);
}
if(isset($_POST['alterproj']))
{
	//die("123");
	$id=$_POST['id'];
   	$note=$_POST['note'];
   	$oringinPrice=$_POST['oringinPrice'];
   	$projName=$_POST['projName'];
	$projNo=$_POST['projNo'];
	$b1=alterproj($id,$note, $oringinPrice, $projName,$projNo);
	echo json_encode($b1);
}
if(isset($_POST['getproid']))
{
	$id=$_POST['getproid'];
	//die("12");
	$b1=delproj($id);
	echo json_encode($b1);
}
?>
	