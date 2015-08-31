<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "log_in"){
		if($_SESSION["login_error_count"]=="")
			$_SESSION["login_error_count"]=0;
		else if($_SESSION["login_error_count"]==5)
			$_SESSION["login_error_count"]=0;
		$sql = "select * from user where acc='".mysqli_real_escape_string($sqli, $_POST["login_acc"])."' AND pwd='".encrypt($_POST["login_pwd"])."';";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result) ;
		if($rs_cn==0){
			$_SESSION["login_error_count"]+=1;
			$_SESSION["login_error_time"]=date("Y-m-d h:i:s");
			
			
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="帐号密码资讯错误，当前错误次数 ".$_SESSION["login_error_count"]."，错误次数达到五次将暂停15分钟无法登入网站！！";
			$_SESSION["msg"]=$sql;
			header("Location: ../index.php");
		}
		else if($row["state"]==0){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="帐号尚未进行开通，请先至信箱收信！！";
			header("Location: ../index.php");
		}
		else if($row["state"]==9){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="帐号以被停权，如有疑问，请联络官方！！";
			header("Location: ../index.php");
		}
		else{
			$_SESSION["user_id"]=$row["uid"];
			$sql = "select * from member where uid = '".$row["uid"]."';";
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result) ;
			
			$_SESSION["user_nick"]=$row["nick"];
			$photo_url = "";
			if($row["photo_url"]!="")
				$face_photo_url="update/face_photo/".$row["photo_url"];
			else{
				if($row["sex"]=="0")
					$face_photo_url="include/images/boy.jpg";
				else
					$face_photo_url="include/images/girl.jpg";
			}
			$_SESSION["user_photo"]=$face_photo_url;
			header("Location: ../index.php");
		}
	}
	if($action == "log_out"){
		session_destroy();
		header("Location: ../index.php");
	}
?>