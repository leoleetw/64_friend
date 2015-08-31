<?
	include_once("../include/dbinclude.php");
	
	if($_SESSION["user_id"]==""){
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="请先登入会员";
		header("Location: ../index.php");
	}
	
	function get_price($gift_type){
		global $sqli;
		$sql = "select * from gift_price where gift_name='".$gift_type."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		if($row["gift_price_o"]==$row["gift_price_d"]){ //非特價品
			return $row["gift_price_o"];
		}
		else{ //有設定特價品 判定時間
			$start = $row["discount_begin_date"]." 00:00:00";
			$end = $row["discount_end_date"]." 23:59:59";
			strtotime("now");
			if((strtotime($start) <= strtotime("now") )&& (strtotime($end) >= strtotime("now") )){ //時間中
				return $row["gift_price_d"];
			}
			else{ //非時間
				return $row["gift_price_o"];
			}
		}
	}
	
	
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "shop_gift"){
		$sr_item = "";
		$flower_price = 0;
		$gift_price = 0;
		$bouquet_price = 0;
		$ring_price = 0;
		$bracelet_price = 0;
		$gold_price = 0;
		$crystal_price = 0;
		$diamond_price = 0;
		$crown_price = 0;
		
		if(intval($_POST["flower_count"])!=0){
			$flower_price = (intval($_POST["flower_count"])*intval(get_price('flower')));
			if($sr_item == "")
				$sr_item .= "flower|".intval($_POST["flower_count"]);
			else
				$sr_item .= "|flower|".intval($_POST["flower_count"]);
		}
		if(intval($_POST["gift_count"])!=0){
			$gift_price = (intval($_POST["gift_count"])*intval(get_price('gift')));
			if($sr_item == "")
				$sr_item .= "gift|".intval($_POST["gift_count"]);
			else
				$sr_item .= "|gift|".intval($_POST["gift_count"]);
		}
		if(intval($_POST["bouquet_count"])!=0){
			$bouquet_price = (intval($_POST["bouquet_count"])*intval(get_price('bouquet')));
			if($sr_item == "")
				$sr_item .= "bouquet|".intval($_POST["bouquet_count"]);
			else
				$sr_item .= "|bouquet|".intval($_POST["bouquet_count"]);
		}
		if(intval($_POST["ring_count"])!=0){
			$ring_price = (intval($_POST["ring_count"])*intval(get_price('ring')));
			if($sr_item == "")
				$sr_item .= "ring|".intval($_POST["ring_count"]);
			else
				$sr_item .= "|ring|".intval($_POST["ring_count"]);
		}
		if(intval($_POST["bracelet_count"])!=0){
			$bracelet_price = (intval($_POST["bracelet_count"])*intval(get_price('bracelet')));
			if($sr_item == "")
				$sr_item .= "bracelet|".intval($_POST["bracelet_count"]);
			else
				$sr_item .= "|bracelet|".intval($_POST["bracelet_count"]);
		}
		if(intval($_POST["gold_count"])!=0){
			$gold_price = (intval($_POST["gold_count"])*intval(get_price('gold')));
			if($sr_item == "")
				$sr_item .= "gold|".intval($_POST["gold_count"]);
			else
				$sr_item .= "|gold|".intval($_POST["gold_count"]);
		}
		if(intval($_POST["crystal_count"])!=0){
			$crystal_price = (intval($_POST["crystal_count"])*intval(get_price('crystal')));
			if($sr_item == "")
				$sr_item .= "crystal|".intval($_POST["crystal_count"]);
			else
				$sr_item .= "|crystal|".intval($_POST["crystal_count"]);
		}
		if(intval($_POST["diamond_count"])!=0){
			$diamond_price = (intval($_POST["diamond_count"])*intval(get_price('diamond')));
			if($sr_item == "")
				$sr_item .= "diamond|".intval($_POST["diamond_count"]);
			else
				$sr_item .= "|diamond|".intval($_POST["diamond_count"]);
		}
		if(intval($_POST["crown_count"])!=0){
			$crown_price = (intval($_POST["crown_count"])*intval(get_price('crown')));
			if($sr_item == "")
				$sr_item .= "crown|".intval($_POST["crown_count"]);
			else
				$sr_item .= "|crown|".intval($_POST["crown_count"]);
		}
			
		$total = ($flower_price+$gift_price+$bouquet_price+$ring_price+$bracelet_price+$gold_price+$crystal_price+$diamond_price+$crown_price);
		$sql = "select coin from point where uid='".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		if(intval($row["coin"]) < $total){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="礼物购买失败!请勿利用bug";
			header("Location: ../user_data.php");
		}
		else{
			$sql = "update point set coin = coin-".$total." where uid='".$_SESSION["user_id"]."'";
			if(!mysqli_query($sqli,$sql)){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="礼物购买失败!";
				header("Location: ../user_data.php");
			}
			else{
				$sql = "update gift set ";
				$sql .= " flower_o = flower_o + ".intval($_POST["flower_count"]);
				$sql .= ", gift_o = gift_o + ".intval($_POST["gift_count"]);
				$sql .= ", bouquet_o = bouquet_o + ".intval($_POST["bouquet_count"]);
				$sql .= ", ring_o = ring_o + ".intval($_POST["ring_count"]);
				$sql .= ", bracelet_o = bracelet_o + ".intval($_POST["bracelet_count"]);
				$sql .= ", gold_o = gold_o + ".intval($_POST["gold_count"]);
				$sql .= ", crystal_o = crystal_o + ".intval($_POST["crystal_count"]);
				$sql .= ", diamond_o = diamond_o + ".intval($_POST["diamond_count"]);
				$sql .= ", crown_o = crown_o + ".intval($_POST["crown_count"]);
				$sql .= " where uid='".$_SESSION["user_id"]."'";
				if(!mysqli_query($sqli,$sql)){
					$sql = "update point set coin = coin+".$total." where uid='".$_SESSION["user_id"]."'";
					mysqli_query($sqli,$sql);
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="礼物购买失败!";
					header("Location: ../user_data.php");
				}
				else{
					$sql = "INSERT INTO shop_record( uid, sr_item, sr_coin , sr_date) VALUES ('".$_SESSION["user_id"]."','".$sr_item."', ".$total.",'".date("Y-m-d H:i:s")."')";
					mysqli_query($sqli,$sql);
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="礼物购买成功!";
					header("Location: ../user_data.php");
				}
			}
		}
		
	}
?>