<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "send_gift"){
		$score = 0.0;
		if($_POST["gift_type"]=="flower"){
			$score = (0.001*intval($_POST["gift_count"]));
		}
		else{
			$sql = "select gift_price_o from gift_price where gift_name='".$_POST["gift_type"]."'";
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
			$score = intval($row["gift_price_o"])*intval($_POST["gift_count"]);
		}
		//送禮對象處理
		$now = date("Y-m-d H:i:s");
		$month_score = 0;
		$week_score = 0;
		$sql = "select * , DATE_FORMAT(gift_date,'%Y-%m') as momth , DATE_FORMAT(gift_date,'%Y') as year from point where uid='".$_POST["gift_uid"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		//----儲存資料用------//
		$gift_date = $row["gift_date"];
		$total_point = $row["total_point"];
		$month_point = $row["month_point"];
		$week_point = $row["week_point"];
		//--------------//
		//本周判定
		$this_week = intval(date("W"));
		$gift_week = intval(date("W",strtotime($gift_date)));
		if(date("Y") == $row["year"]){
			if($this_week == $gift_week)
				$week_score = intval($week_point)+$score;
			else
				$week_score = $score;
		}
		else{
			$week_score = $score;
		}
		//本月判定
		if(strtotime($gift_date) >= strtotime(date("Y-m-01 00:00:00"))){ //直接增加分數
			$month_score = intval($month_point)+$score;
		}
		else{
			$month_score = $score;
		}
		$sql = "update point set total_point = total_point + ".$score." , month_point = ".$month_score." , week_point = ".$week_score." , gift_date = '".$now."' where uid =".$_POST["gift_uid"];
		if(!mysqli_query($sqli,$sql)){
			$sql = "update point set total_point = ".$total_point." , month_point = ".$month_point." , week_point = ".$week_point." , gift_date = '".$gift_date."' where uid =".$_POST["gift_uid"];
			mysqli_query($sqli,$sql);
			echo "1|送礼失败";
		}
		else{
			//对方礼物增加
			$sql = "update gift set ".$_POST["gift_type"]."_r = ".$_POST["gift_type"]."_r + ".$_POST["gift_count"]." where uid =".$_POST["gift_uid"];
			mysqli_query($sqli,$sql);
			//自己礼物减少
			$sql = "update gift set ".$_POST["gift_type"]."_o = ".$_POST["gift_type"]."_o -  ".$_POST["gift_count"]." where uid =".$_SESSION["user_id"];
			mysqli_query($sqli,$sql);
			
			//增加纪录
			$sql = "INSERT INTO gift_record(uid, gr_uid, gift_type, gift_count, gr_date) 
			VALUES (".$_SESSION["user_id"].",".$_POST["gift_uid"].",'".$_POST["gift_type"]."',".$_POST["gift_count"].",'".$now."')";
			mysqli_query($sqli,$sql);
			
			echo "0|送礼成功";
		}
	}
?>