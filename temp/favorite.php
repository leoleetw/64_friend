<?
	include_once("include/dbinclude.php");
	$sql = "select a.* , b.nick ,b.photo_url from favorite a , member b ,user c where a.uid='".$_SESSION["user_id"]."' AND a.fa_uid=b.uid  AND a.fa_uid = c.uid AND c.state != 9 ;";
	$result = mysqli_query($sqli,$sql);
?>
<div class="edit_nav">
	<a href="user_edit.php">修改资料</a>
	<a href="favorite.php">我的收藏</a>
	<a href="user_album.php">我的相簿</a>
	<a href="#">积分兑换</a>
	<a href="shop.php">购买礼物/储值</a>
</div>
<div>
<?
	while($row = mysqli_fetch_array($result)){
?>
	<div class="favorite_wrapper">
		<div id="div_<? echo $row["fa_uid"];?>" class="favorite_Container">
			<img class="favorite_remove" src="include/images/remove.jpg" onclick="remove_favorite(<? echo $_SESSION["user_id"]; ?> , <? echo $row["fa_uid"];?>);">
			<div >
				<?
					$photo_url = "";
					if($row["photo_url"]!="")
						$face_photo_url="update/face_photo/".$row["photo_url"];
					else
						if($row["sex"]=="0")
							$face_photo_url="include/images/boy.jpg";
						else
							$face_photo_url="include/images/girl.jpg";
				?>
				<img src="<? echo $face_photo_url; ?>" onclick="location.href='member_data.php?uid=<? echo $row["fa_uid"];?>'" class="favorite_imgSize">
			</div>
			<? echo $row["nick"]; ?>
		</div>
	</div>
<?
	}
?>
</div>
<script>
	function re_remove_favorite(mytext){
		var arr = mytext.split("|");
		if(arr[0]=="0"){
			$( "#div_"+arr[2] ).remove();
		}
		else
			alert("发生错误");
	}
	function remove_favorite(uid,fa_uid){
		var str = "";
		str = "action=remove&fa_uid="+fa_uid;
    CallServer("ajax/favorite.php", str, "POST", true, "mytext",re_remove_favorite );
	}
</script>