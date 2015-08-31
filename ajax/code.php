<?
	include_once("../include/dbinclude.php");
	$res = Array();
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == 'city_code'){
		$sql = "select value from code where id=".$_POST["city_cate"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$sql = "select * from code where type='city".$row["value"]."';";
		$result = mysqli_query($sqli,$sql);
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i){
			$res[$i] = $row;
		}
		//echo $sql;
		echo json_encode($res);		
	}
?>