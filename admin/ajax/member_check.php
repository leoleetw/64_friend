<?
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action=="pass"){
		$sql = "select * from member_check where u_id = '".$_POST['u_id']."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn != 1){
			echo "1|資料蒐尋錯誤";
		}
		else{
			$row = mysqli_fetch_array($result) ;
			$sql = "UPDATE member SET name='".$row['name']."',state='2',sex='".$row['sex']."',photo_url='".$row['name']."',blood_type='".$row['blood_type']."'
					,birth_day='".$row['birth_day']."',height='".$row['height']."',weight='".$row['weight']."',city_code='".$row['city_cate']."|".$row['city_code']."',job='".$row['job']."'
					,faith='".$row['faith']."',edu_bg='".$row['edu_bg']."',school='".$row['school']."',introduction='".$row['introduction']."',views='".$row['name']."'
					WHERE u_id = '".$_POST['u_id']."'";
			if(!mysqli_query($sqli,$sql)){
				echo "1|資料更新失敗";
			}
			else{
				echo "0|".$_POST['row_index'];
			}
		}
	}
	else if($action=="fail"){
		$sql = "UPDATE member state='3' WHERE u_id = '".$_POST['u_id']."'";
		if(!mysqli_query($sqli,$sql)){
			echo "1|資料更新失敗";
		}
		else{
			echo "0|".$_POST['row_index'];
		}
	}
	//echo json_encode($res);		
?>