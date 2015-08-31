<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	
	if($action == "member_data"){ // 资料更新
			$interest =  implode("|",$_POST['interest']);
			/* 可改生日
			if($_POST['sex']=='0'){
				$sql = "UPDATE member SET nick='".$_POST['nick']."',sex='".$_POST['sex']."',measure = NULL,blood_type='".$_POST['blood_type']."'
				,birth_day='".$_POST['birth_day_y']."-".$_POST['birth_day_m']."-".$_POST['birth_day_d']."',height='".$_POST['height']."',weight='".$_POST['weight']."',city_cate='".$_POST['city_cate']."'
				,city_code='".$_POST['city_code']."',job='".$_POST['job']."',faith='".$_POST['faith']."',edu_bg='".$_POST['edu_bg']."',interest='".$interest."',introduction='".mysqli_real_escape_string($sqli, $_POST['introduction'])."'
				,measure = NULL,edit_date='".date("Y-m-d h:i:s")."' WHERE uid = '".$_SESSION["user_id"]."'";
			}
			else{
				$sql = "UPDATE member SET nick='".$_POST['nick']."',sex='".$_POST['sex']."',measure = NULL,blood_type='".$_POST['blood_type']."'
				,birth_day='".$_POST['birth_day_y']."-".$_POST['birth_day_m']."-".$_POST['birth_day_d']."',height='".$_POST['height']."',weight='".$_POST['weight']."',city_cate='".$_POST['city_cate']."'
				,city_code='".$_POST['city_code']."',job='".$_POST['job']."',faith='".$_POST['faith']."',edu_bg='".$_POST['edu_bg']."',interest='".$interest."',introduction='".mysqli_real_escape_string($sqli, $_POST['introduction'])."'
				,measure = NULL,edit_date='".date("Y-m-d h:i:s")."' WHERE uid = '".$_SESSION["user_id"]."'";
			}
			*/
			//不可改生日
			if($_POST['sex']=='0'){
				$sql = "UPDATE member SET nick='".$_POST['nick']."',sex='".$_POST['sex']."',measure = NULL,blood_type='".$_POST['blood_type']."'
				,height='".$_POST['height']."',weight='".$_POST['weight']."',city_cate='".$_POST['city_cate']."'
				,city_code='".$_POST['city_code']."',job='".$_POST['job']."',faith='".$_POST['faith']."',edu_bg='".$_POST['edu_bg']."',interest='".$interest."',introduction='".mysqli_real_escape_string($sqli, $_POST['introduction'])."'
				,measure = NULL,edit_date='".date("Y-m-d h:i:s")."' WHERE uid = '".$_SESSION["user_id"]."'";
			}
			else{
				$sql = "UPDATE member SET nick='".$_POST['nick']."',sex='".$_POST['sex']."',measure = NULL,blood_type='".$_POST['blood_type']."'
				,height='".$_POST['height']."',weight='".$_POST['weight']."',city_cate='".$_POST['city_cate']."'
				,city_code='".$_POST['city_code']."',job='".$_POST['job']."',faith='".$_POST['faith']."',edu_bg='".$_POST['edu_bg']."',interest='".$interest."',introduction='".mysqli_real_escape_string($sqli, $_POST['introduction'])."'
				,measure = NULL,edit_date='".date("Y-m-d h:i:s")."' WHERE uid = '".$_SESSION["user_id"]."'";
			}
			$_SESSION["user_nick"] = $_POST['nick'];
			mysqli_query($sqli,$sql);
			header("Location:../user_data.php" );
	}
	else if($action == "member_require_add"){
		$sql = "INSERT INTO member_require(uid, re_sex, re_city_cate, re_city_code, re_age, re_height, re_weight, re_blood_type, re_faith, re_edu_bg, re_job, re_note)
		values ('".$_SESSION["user_id"]."','".$_POST['re_sex']."','".$_POST['re_city_cate']."','".$_POST['re_city_code']."','".$_POST['re_age0']."|".$_POST['re_age1']."'
		,'".$_POST['re_height0']."|".$_POST['re_height1']."','".$_POST['re_weight0']."|".$_POST['re_weight1']."','".$_POST['re_blood_type']."','".$_POST['re_faith']."'
		,'".$_POST['re_edu_bg']."','".$_POST['re_job']."','".mysqli_real_escape_string($sqli, $_POST['re_note'])."')";
		mysqli_query($sqli,$sql);
		header("Location:../user_data.php" );
	}
	else if($action == "member_require_edit"){
		$sql = "UPDATE member_require SET re_sex='".$_POST['re_sex']."',re_city_cate='".$_POST['re_city_cate']."',re_city_code='".$_POST['re_city_code']."',re_age='".$_POST['re_age0']."|".$_POST['re_age1']."'
		,re_height='".$_POST['re_height0']."|".$_POST['re_height1']."',re_weight='".$_POST['re_weight0']."|".$_POST['re_weight1']."',re_blood_type='".$_POST['re_blood_type']."'
		,re_faith='".$_POST['re_faith']."',re_edu_bg='".$_POST['re_edu_bg']."',re_job='".$_POST['re_job']."',re_note='".mysqli_real_escape_string($sqli, $_POST['re_note'])."' WHERE uid='".$_SESSION["user_id"]."'";
		mysqli_query($sqli,$sql);
		//echo $sql;
		header("Location:../user_data.php" );
	}
	
?>