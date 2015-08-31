<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "add"){
		if($_SESSION["user_id"]==""){
			echo "1|请先登入会员";
		}
		else{
			$sql = "INSERT INTO favorite(uid, fa_uid) VALUES ('".$_SESSION["user_id"]."','".$_POST["fa_uid"]."')";
			if(!mysqli_query($sqli,$sql)){
				echo "1|资料更新错误".$sql;
			}
			else{
				$sql = "update member set fa_count = fa_count+1 where uid='".$_POST["fa_uid"]."'";
				if(!mysqli_query($sqli,$sql)){
					$sql = "delete from favorite where uid='".$_SESSION["user_id"]."' AND fa_uid = '".$_POST["fa_uid"]."'";
					mysqli_query($sqli,$sql);
					echo "1|资料更新错误";
				}
				else{
					echo "0|0|".$_POST["fa_uid"];
				}
			}
		}
	}
	if($action == "remove"){
		$sql = "delete from favorite where uid='".$_SESSION["user_id"]."' AND fa_uid = '".$_POST["fa_uid"]."'";
		mysqli_query($sqli,$sql);
		$sql = "update member set fa_count = fa_count-1 where uid = '".$_POST["fa_uid"]."'";
		mysqli_query($sqli,$sql);
		echo "0|1|".$_POST["fa_uid"];
	}
?>