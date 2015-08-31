<?
	include_once("include/dbinclude.php");
	$uid = isset($_POST["uid"]) ? $_POST['uid'] : $_GET['uid'] ;
	$sql1 = "select alb_id , alb_title , pho_count , alb_cover from album where uid='".$uid."' AND alb_state = 0 order by creat_date desc;";
		$result1 = mysqli_query($sqli,$sql1);
		$rs_cn1 = mysqli_num_rows($result1);
		if($rs_cn1 == 0){
			echo "尚未建立相簿，快建立起来让大家欣赏～";
		}
		else{
			while($row1 = mysqli_fetch_array($result1)){
	?>
		<div id="alb<? echo $row1["alb_id"]; ?>" class="albumImgContainer">
			<div class="album_imgSize">
				<? if($row1["alb_cover"] != ""){ ?>
				<img src="update/album_s/<? echo $row1["alb_id"]."/".$row1["alb_cover"]; ?>" onclick="location.href='photo.php?alb_id=<? echo $row1["alb_id"]; ?>'">
				<? }else{ ?>
				<img src="include/images/no_chose.jpg" onclick="location.href='photo.php?alb_id=<? echo $row1["alb_id"]; ?>'">
				<? } ?>
			</div>
			<div>
				<? echo $row1["alb_title"]; ?>
			</div>
			<div>
				<? echo $row1["pho_count"]; ?><font class="font_small">张</font>
			</div>
		</div>
	<?
			}
		}
	?>