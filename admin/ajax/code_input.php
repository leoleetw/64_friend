<?
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action=="top_add"){
		$sql = "INSERT INTO code( type, name, value, seq) VALUES ('".$_POST["type"]."','".$_POST["name"]."','','0')";
		if(!mysqli_query($sqli,$sql)){ //新增失敗
			echo "1|新增失敗!";
		}
		else{ //新增成功
			echo "0|新增成功!";
		}
		
	}
	if($action=="top_update"){
		$sql = "select * from code where id='".$_POST["id"]."';";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$sql = "update code set type='".$_POST["type"]."' , name='".$_POST["name"]."' where type='".$row["type"]."' AND name='".$row["name"]."';";
		if(!mysqli_query($sqli,$sql)){ //更新失敗
			echo "1|更新失敗!";
		}
		else{ //更新成功
			echo "0|更新成功!";
		}
		
	}
	if($action=="show_down"){
		$res = Array();
		$sql = "select * from code where type='".$_POST["type"]."' AND seq != 0 order by seq;";
		$result = mysqli_query($sqli,$sql);
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i){
			$res[$i] = $row;
		}
		echo json_encode($res);		
	}
	
	if($action == "check_acc"){ // 判定重复帐号
		$acc = $_POST["acc"];
		$sql = "select * from user where acc='".mysqli_real_escape_string($sqli, $acc)."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		echo $rs_cn;
	}
	if($action == "verify"){ // 帐号注册邮件开通
		$sql = "select * from user where u_id='".mysqli_real_escape_string($sqli, $_GET["u_id"])."' AND verify_code='".mysqli_real_escape_string($sqli, $_GET["verify_code"])."';";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn!=1){
			echo "帐号资讯发生问题，请提交email至官方网站获得帮助";
		}
		else{
			$row = mysqli_fetch_array($result) ;
			if($row["state"]!=0){
				echo "此帐号以获得会员开通资格，请勿重复点击网址";
			}
			else{
				$sql = "update user set state=1 where u_id='".$_GET["u_id"]."';";
				if(!mysqli_query($sqli,$sql)){
					echo "会员帐号资格开通失败，请提交email至官方网站获得帮助";
				}
				else{
					echo "恭喜您，会员资格开通成功，三秒後画面将转至首页，请重新登入";
					header("Refresh: 3; url= ../index.php");
				}
			}
		}
	}
?>