<?
	include_once("include/dbinclude.php");
	$alb_id = isset($_POST["alb_id"]) ? $_POST['alb_id'] : $_GET['alb_id'] ;
	$sql = "select a.alb_title , a.uid , a.creat_date ,a.alb_state ,b.rep_id as report from album a
	left join report b on b.uid='".$_SESSION["user_id"]."' AND b.rep_target = ".$alb_id." AND rep_type = 'album'
	where a.alb_id='".$alb_id."' order by a.creat_date ;";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
	if($row["alb_state"]!="0"){
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="该相簿被管理员设定隐藏";
		header("Location: member_data.php?uid=".$row["uid"]);
	}
	$alb_title = $row["alb_title"];
	$creat_date = $row["creat_date"];
	$report = $row["report"];
	$sql = "select a.pho_id , a.pho_url , a.pho_jumi_count , b.uid as jumi from photo a LEFT JOIN jumi as b ON a.pho_id=b.jumi_target AND b.uid = '".$_SESSION["user_id"]."' AND jumi_type='photo' where alb_id='".$alb_id."'  order by pho_id desc ;";
	$result = mysqli_query($sqli,$sql);
?>
<div>
<?
	$maxwidth = 140;
	$maxheight = 140;
	while($row = mysqli_fetch_array($result)){
	?>
		<div id="pho<? echo $row["pho_id"] ?>" class="photo_ImgContainer">
			<div class="photo_shadow"  onmouseover="$(this).stop().animate({'opacity':1},100);" onmouseout="$(this).stop().animate({'opacity':0});">
				<div class="photo_jumi">
				<?
					if($row["jumi"]==""){
				?>
					<input type="hidden" id="jumi_photo<? echo $row["pho_id"]; ?>" name="jumi_photo<? echo $row["pho_id"]; ?>" value="1" >
					<img id="jumi_img<? echo $row["pho_id"]; ?>" src="include/images/heart1.jpg" onclick="jumi_photo('<? echo $row["pho_id"]; ?>');">
				<?
					}else{
				?>
					<input type="hidden" id="jumi_photo<? echo $row["pho_id"]; ?>" name="jumi_photo<? echo $row["pho_id"]; ?>" value="0" >
					<img id="jumi_img<? echo $row["pho_id"]; ?>" src="include/images/heart0.jpg" onclick="jumi_photo('<? echo $row["pho_id"]; ?>');">
				<? }?>
				<font id="pho_jumi_count<? echo $row["pho_id"]; ?>"><? echo $row["pho_jumi_count"]; ?></font>
				</div>
			</div>
			<div>
				<?
					list($width, $height, $type, $attr) = getimagesize("update/album_s/".$alb_id."/".$row["pho_url"]);
					if($width > $height){
						$new_width = $width * ($maxheight / $height);
						echo "<img src='update/album_s/".$alb_id."/".$row["pho_url"]."' style='width:".$new_width."px;height:".$maxheight."px;margin-left:-".(($new_width-$maxwidth)/2)."px;'>";
					}
					else if($width < $height){
						$new_height = $height * ($maxwidth / $width);
						echo "<img src='update/album_s/".$alb_id."/".$row["pho_url"]."' style='width:".$maxwidth."px;height:".$new_height."px;margin-top:-".(($new_height-$maxheight)/2)."px;'>";
					}
					else
						echo "<img src='update/album_s/".$alb_id."/".$row["pho_url"]."' style='width:".$maxwidth."px;height:".$maxheight."px;'>";
				?>
			</div>
		</div>
	<?
	}
	?>
</div>
<div class="dropdown">
  <button class="btn" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
  	<? if($report!=""){ ?>
  	<li><a onclick="alert('此相簿以被你检举，请勿再次点击')">检举</a></li>
  	<? }else{ ?>
    <li><a data-toggle="modal" data-target="#album_report_Modal"  data-backdrop="static" data-keyboard=false>检举</a></li>
  	<? } ?>
  </ul>
</div>
<form id='album_report_form' action='ajax/report.php' method="post">
	<div class="modal fade" id="album_report_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	      	<h1>检举相簿</h1>
	      </div>
	      <div class="modal-body">
	      	<input type="hidden" id="album_report_id" name="album_report_id" value="<? echo $alb_id; ?>">
	      	<input type="hidden" id="action" name="action" value="album_report" >
	      	<font>检举理由（100字内）︰</font>
	      	<textarea id="album_report_content" name="album_report_content" class="form-control" style="resize:none;"  onkeyup="autogrow(this);" ></textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="send_report('album');">确定</>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<script>
	function send_report(target_type){
		if(Dd(target_type+"_report_content").value.length > 100 || Dd(target_type+"_report_content").value.length==0){
			alert("检举内容不得超过100字或为空");
		}
		else{
			Dd(target_type+"_report_form").submit();
		}
	}
	function re_jumi_photo(mytext){
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=="1"){
			alert(arr[1]);
		}
		else if(arr[0]=="0"){
			if(Dd("jumi_photo"+arr[1]).value=="1"){ //將要JUMI
				Dd("jumi_photo"+arr[1]).value="0";
				Dd("jumi_img"+arr[1]).src="include/images/heart0.jpg";
				Dd("pho_jumi_count"+arr[1]).innerHTML = (parseInt(Dd("pho_jumi_count"+arr[1]).innerHTML)+1);
			}
			else if(Dd("jumi_photo"+arr[1]).value=="0"){ //取消JUMI
				Dd("jumi_photo"+arr[1]).value="1";
				Dd("jumi_img"+arr[1]).src="include/images/heart1.jpg";
				Dd("pho_jumi_count"+arr[1]).innerHTML = (parseInt(Dd("pho_jumi_count"+arr[1]).innerHTML)-1);
			}
		}
		else{
			alert(mytext);
		}
	}
	function jumi_photo(pho_id){
		var str = "";
		if(Dd("jumi_photo"+pho_id).value=="1"){ //將要JUMI
			str = "action=jumi&pho_id="+pho_id;
		}
		else if(Dd("jumi_photo"+pho_id).value=="0"){ //取消JUMI
			str = "action=bujumi&pho_id="+pho_id;
		}
		CallServer("ajax/album.php", str, "POST", true, "mytext",re_jumi_photo );
	}
</script>