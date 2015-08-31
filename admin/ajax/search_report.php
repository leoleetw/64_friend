<?
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action=="no_check"){
		$res = Array();
		$sql = "select a.*, b.name , b.nick , b.sex , b.photo_url from report a left join member b on a.uid = b.uid where a.state =0 order by a.rep_id";
		$result = mysqli_query($sqli,$sql);
		$n = 0;
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i){
			if($row["rep_type"]=='member'){
				$sql = "select name , nick , sex , photo_url ,uid from member where uid=".$row["rep_target"]." ";
			}
			else if($row["rep_type"]=='album'){
				$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from album a left join member b on a.uid = b.uid where a.alb_id = ".$row["rep_target"];
			}
			else if($row["rep_type"]=='wall'){
				$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from wall a left join member b on a.uid = b.uid where a.wa_id = ".$row["rep_target"];
			}
			$result_target = mysqli_query($sqli,$sql);
			$target_cn = mysqli_num_rows($result_target);
			if($target_cn!=0){
				$row_target = mysqli_fetch_array($result_target) ;
				$res[$n] = $row;
				$res[$n] += Array('target' => $row_target);
				
				$sql_other = "select a.*, b.name , b.nick , b.sex , b.photo_url from report a left join member b on a.uid = b.uid where a.rep_id != ".$row["rep_id"]." AND a.rep_type = '".$row["rep_type"]."' AND a.rep_target = '".$row["rep_target"]."'";
				$result_other = mysqli_query($sqli,$sql_other);
				$other_cn = mysqli_num_rows($result_other);
				/*
				$other = Array();
				for($m = 0 ; $m < $row_other = mysqli_fetch_array($result_other) ; ++$m){
					$other[$m] =  $row_other;
				}
				*/
				$res[$n] += Array('other' => $other_cn);
				$n++;
			}
			else{
				$sql = "delete from report where rep_id=".$row["rep_id"];
				mysqli_query($sqli,$sql);
			}
		}
		echo json_encode($res);
	}
	else if($action == "show_report"){
		$res = Array();
		$temp = Array();
		$sql = "select a.*, b.name , b.nick , b.sex , b.photo_url from report a left join member b on a.rep_target = b.uid where a.rep_type = '".$_POST["rep_type"]."' AND a.rep_target = '".$_POST["rep_target"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$res = $row;
		if($_POST["rep_type"]=='member'){
			$sql = "select name , nick , sex , photo_url ,uid from member where uid=".$_POST["rep_target"]." ";
		}
		else if($_POST["rep_type"]=='album'){
			$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from album a left join member b on a.uid = b.uid where a.alb_id = ".$_POST["rep_target"];
		}
		else if($_POST["rep_type"]=='wall'){
			$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from wall a left join member b on a.uid = b.uid where a.wa_id = ".$_POST["rep_target"];
		}
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$res += Array('target' => $row);
		$sql = "select a.*, b.name , b.nick , b.sex , b.photo_url from report a left join member b on a.uid = b.uid where a.rep_type = '".$_POST["rep_type"]."' AND a.rep_target = '".$_POST["rep_target"]."'";
		$result = mysqli_query($sqli,$sql);
		for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
			$temp[$i] =  $row;
		}
		$res += Array('other' => $temp);
		echo json_encode($res);
	}
	mysqli_close($sqli);
?>