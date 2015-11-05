<?php
$con=mysql_connect("localhost","root","") or die('Could not connect: ' . mysql_error());
mysql_query("set names 'utf8'",$con);
mysql_select_db("ims",$con);
function addproj($note, $oringinPrice, $projName,$projNo)
{
	$sql="SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name='proj'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$id=$row['AUTO_INCREMENT'];
	$sql="INSERT INTO proj (note, oringinPrice, projName,projNo) VALUES ('$note', '$oringinPrice', '$projName','$projNo')";
	$result = mysql_query($sql);
	//$sql1="select id,projName from proj order by id limit 1";
	//$result1 = mysql_query($sql1);
	//$row = mysql_fetch_array($result1);
	$black=array(
				 'id'=>$id,
				 'projName'=>$projName
	);
	return $black; 
}
function delproj($id)
{
	$sql="DELETE FROM proj WHERE id='$id'";
	return 1;
}
function alterproj($id,$note, $oringinPrice, $projName,$projNo)
{
	$sql="UPDATE proj SET id='$id',note='$note',oringinPrice='$oringinPrice',projName='$projName',projNo='$projNo' WHERE id='$id'";
	$result=mysql_query($sql);
	return 1;
}
function getpidList()
{
	//die("123");
	$sql="select id,projName from proj ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$id=$row['id'];
	$projName=$row['projName'];
	while($row = mysql_fetch_array($result)){
		$id = $id."||".$row['id'];
		$projName = $projName."||".$row['projName'];
	}
	//var_dump($id);
	$backValue=array('id'=>$id,'projName'=>$projName);
	return $backValue;
}
function queryproj($id)
{
	$sql="select * from proj where id='$id'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=1){
		$backValue=array('error'=>'01002');
		return $backValue;
	}
	$row = mysql_fetch_array($result);
	
	/*$black=array(
				'id'=>$row['id'],
				'projName'=>$row['projNo'],
				'oringinPrice'=>$row['oringinPrice'],
				'note'=>$row['note'],
				'projNo'=>$row['projNo']
	);
	die($row['id']);*/
	return $row;
}
?>