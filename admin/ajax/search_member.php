<?
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action=="search"){
		$res = Array();
		if($_POST["search_type"]!="member_name"){
			$search_value = explode("-",$_POST["search_value"]);
			if(count($search_value)==1)
				$sql = "select a.uid , a.ident_code , b.name , b.nick , b.sex from user a , member b where a.uid = b.uid AND b.".$_POST["search_type"]." = ".$_POST["search_value"]." order by a.uid";
			else
				$sql = "select a.uid , a.ident_code , b.name , b.nick , b.sex from user a , member b where a.uid = b.uid AND b.".$_POST["search_type"]."  BETWEEN ".$search_value[0]." AND ".$search_value[1]." order by a.uid";
		}
		else
			$sql = "select a.uid , a.ident_code , b.name , b.nick , b.sex from user a , member b where a.uid = b.uid AND (b.name like '%".$_POST["search_value"]."%' OR b.nick like '%".$_POST["search_value"]."%') order by a.uid";
		$result = mysqli_query($sqli,$sql);
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i)
			$res[$i] = $row;
		echo json_encode($res);		
	}
	else if($action == "member_data"){
		/*
		$sql = "select a.* , b.* , c.name as city_cate , d.name as city_code, e.name as edu_bg , f.name as job, g.name as faith from user a 
		Inner Join member b on a.uid = b.uid 
		LEFT JOIN code c on b.city_cate = c.id 
		LEFT JOIN code d on b.city_code = d.id 
		LEFT JOIN code e on b.edu_bg = e.id 
		LEFT JOIN code f on b.job = f.id 
		LEFT JOIN code g on b.faith = g.id 
		where a.uid = ".$_POST["uid"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$temp = Array();
		if($row["interest"]!=""){
			$interest = explode("|",$row["interest"]);
			for($i = 0 ; $i < count($interest) ; ++$i){
				$sql = "select name from code where id =".$interest[$i];
				$result = mysqli_query($sqli,$sql);
				$row_temp = mysqli_fetch_array($result);
				$temp[] += $row_temp["name"];
			}
		}
		$row["interest"] = $temp ;
		*/
		$sql = "select a.* , b.* from  user a , member b where a.uid = b.uid AND a.uid = ".$_POST["uid"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		echo json_encode($row);		
	}
	else if($action == "edit_member_data"){
		if($_POST["ident_code"]!="")
			$sql = "update user set ident_code = '".$_POST["ident_code"]."' ,state = '".$_POST["user_state"]."' where uid='".$_POST["uid"]."'";
		else
			$sql = "update user set ident_code = NULL ,state = '".$_POST["user_state"]."' where uid='".$_POST["uid"]."'";
		mysqli_query($sqli,$sql);
		$interest =  implode("|",$_POST['interest']);
		if($_POST['sex']=='0'){
			$sql = "UPDATE member SET name='".$_POST['member_name']."',nick='".$_POST['member_nick']."',sex='".$_POST['sex']."',blood_type='".$_POST['blood_type']."'
			,birth_day='".$_POST['birth_day_y']."-".$_POST['birth_day_m']."-".$_POST['birth_day_d']."',height='".$_POST['height']."',weight='".$_POST['weight']."',city_cate='".$_POST['city_cate']."'
			,city_code='".$_POST['city_code']."',job='".$_POST['job']."',faith='".$_POST['faith']."',edu_bg='".$_POST['edu_bg']."',interest='".$interest."',introduction='".mysqli_real_escape_string($sqli, $_POST['introduction'])."'
			,measure = NULL,edit_date='".date("Y-m-d h:i:s")."' WHERE uid = '".$_POST["uid"]."'";
		}
		else{
			$sql = "UPDATE member SET name='".$_POST['member_name']."',nick='".$_POST['member_nick']."',sex='".$_POST['sex']."',blood_type='".$_POST['blood_type']."'
			,birth_day='".$_POST['birth_day_y']."-".$_POST['birth_day_m']."-".$_POST['birth_day_d']."',height='".$_POST['height']."',weight='".$_POST['weight']."',city_cate='".$_POST['city_cate']."'
			,city_code='".$_POST['city_code']."',job='".$_POST['job']."',faith='".$_POST['faith']."',edu_bg='".$_POST['edu_bg']."',interest='".$interest."',introduction='".mysqli_real_escape_string($sqli, $_POST['introduction'])."'
			,measure = NULL,edit_date='".date("Y-m-d h:i:s")."' WHERE uid = '".$_POST["uid"]."'";
		}
		mysqli_query($sqli,$sql);
		header("Location:../search_member.php" );
	}
	mysqli_close($sqli);
?>