<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "member_report"){ // 会员检举
		$sql = "INSERT INTO report( uid, rep_type, rep_target, note, state) values
		 ('".$_SESSION["user_id"]."' , 'member' , '".$_POST["member_report_id"]."' , '".mysqli_real_escape_string($sqli, $_POST["member_report_content"])."' , '0')";
	
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="会员检举失敗";
			header("Location: ../member_data.php?uid=".$_POST["member_report_id"]);
			
		}
		else{
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="会员检举成功，管理员将会查看";
			header("Location: ../member_data.php?uid=".$_POST["member_report_id"]);
		}
	}
	else if($action == "wall_report"){ //檢舉塗鴉牆
		$sql = "select uid from wall where wa_id='".$_POST["wall_report_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$uid = $row["uid"];
		$sql = "INSERT INTO report( uid, rep_type, rep_target, note, state) values
		 ('".$_SESSION["user_id"]."' , 'wall' , '".$_POST["wall_report_id"]."' , '".mysqli_real_escape_string($sqli, $_POST["wall_report_content"])."' , '0')";
	
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="涂鸦墙检举失敗";
			header("Location: ../member_data.php?uid=".$uid);
			
		}
		else{
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="涂鸦墙检举成功，管理员将会查看";
			header("Location: ../member_data.php?uid=".$uid);
		}
	}
	else if($action == "album_report"){ //檢舉相簿
		$sql = "select uid from album where alb_id='".$_POST["album_report_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$uid = $row["uid"];
		$sql = "INSERT INTO report( uid, rep_type, rep_target, note, state) values
		 ('".$_SESSION["user_id"]."' , 'album' , '".$_POST["album_report_id"]."' , '".mysqli_real_escape_string($sqli, $_POST["album_report_content"])."' , '0')";
	
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="相簿检举失敗";
			header("Location: ../album.php?uid=".$uid);
			
		}
		else{
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="相簿检举成功，管理员将会查看";
			header("Location: ../album.php?uid=".$uid);
		}
	}
?>