<?
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action=="search"){
		$res = Array();
		if($_POST["search_type"]=="uid"||$_POST["search_type"]=="alb_id"){
			$search_value = explode("-",$_POST["search_value"]);
			if(count($search_value)==1)
				$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from album a left join member b on a.uid = b.uid where a.".$_POST["search_type"]." = ".$_POST["search_value"]." order by a.alb_id";
			else
				$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from album a left join member b on a.uid = b.uid where a.".$_POST["search_type"]."  BETWEEN ".$search_value[0]." AND ".$search_value[1]." order by a.alb_id";
		}
		else if($_POST["search_type"]=="member_name")
			$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from album a left join member b on a.uid = b.uid where (b.name like '%".$_POST["search_value"]."%' OR b.nick like '%".$_POST["search_value"]."%') order by a.alb_id";
		else if($_POST["search_type"]=="alb_title")
			$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from album a left join member b on a.uid = b.uid where a.alb_title like '%".$_POST["search_value"]."%' order by a.alb_id";
		$result = mysqli_query($sqli,$sql);
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i){
			$res[$i] = $row;
		}
		echo json_encode($res);		
	}
	else if($action == "alb_photo"){
		$res = Array();
		$photo = Array();
		$sql = "select b.alb_state,b.alb_title , b.alb_id , a.uid , a.name , a.nick , a.sex , a.photo_url from member a , album b where a.uid = b.uid AND b.alb_id=".$_POST["alb_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$res = $row;
		$sql = "select * from photo where alb_id = ".$_POST["alb_id"]." order by pho_id";
		$result = mysqli_query($sqli,$sql);
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i){
			$photo[$i] = $row;
		}
		$res += Array('photo' => $photo);
		echo json_encode($res);		
	}
	else if($action == "change_state"){
		$sql = "update album set alb_state = ".$_POST['state']." where alb_id =".$_POST['alb_id'];
		if(!mysqli_query($sqli,$sql))
			echo "1|更新失敗";
		else
			echo "0|成功更新";
	}
	mysqli_close($sqli);
?>