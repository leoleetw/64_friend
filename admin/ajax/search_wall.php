<?
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action=="search"){
		$res = Array();
		if($_POST["search_type"]=="uid"||$_POST["search_type"]=="wa_id"){
			$search_value = explode("-",$_POST["search_value"]);
			if(count($search_value)==1)
				$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from wall a left join member b on a.uid = b.uid where a.".$_POST["search_type"]." = ".$_POST["search_value"]." order by a.wa_id";
			else
				$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from wall a left join member b on a.uid = b.uid where a.".$_POST["search_type"]."  BETWEEN ".$search_value[0]." AND ".$search_value[1]." order by a.wa_id";
		}
		else if($_POST["search_type"]=="member_name")
			$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from wall a left join member b on a.uid = b.uid where (b.name like '%".$_POST["search_value"]."%' OR b.nick like '%".$_POST["search_value"]."%') order by a.wa_id";
		else if($_POST["search_type"]=="wa_content")
			$sql = "select a.* , b.name , b.nick , b.sex , b.photo_url from wall a left join member b on a.uid = b.uid where a.wa_content like '%".$_POST["search_value"]."%' order by a.wa_id";
		$result = mysqli_query($sqli,$sql);
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i){
			$row["wa_content"] = str_replace("\n","<br>",$row['wa_content']);
			$res[$i] = $row;
		}
		echo json_encode($res);		
	}
	else if($action=='change_state'){
		$sql = "update wall set wa_state = '".$_POST['show']."' where wa_id =".$_POST['wa_id'];
		if(!mysqli_query($sqli,$sql))
			echo "1|更新失敗";
		else
			echo "0|成功更新";
	}
	mysqli_close($sqli);
?>