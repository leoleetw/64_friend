<?
	include_once("include/dbinclude.php");
	$sql = "select alb_title , uid , creat_date from album where alb_id='".$_GET["alb_id"]."' order by creat_date ;";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
	if($row["uid"]!=$_SESSION["user_id"]){
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="請勿進入別人的相簿!";
		header("Location: user_album.php");
	}
	else{
		$alb_title = $row["alb_title"];
		$creat_date = $row["creat_date"];
	}
?>
<div class="edit_nav">
	<a href="user_edit.php">修改资料</a>
	<a href="favorite.php">我的收藏</a>
	<a href="user_album.php">我的相簿</a>
	<a href="#">积分兑换</a>
	<a href="shop.php">购买点数</a>
</div>
<div>
	<div> <? echo $alb_title; ?></div>
	<div> <? echo $creat_date; ?></div>
	<div data-toggle="modal" data-target="#cover_Modal"  data-backdrop="static" data-keyboard=false>相簿封面设定</div>
	<div data-toggle="modal" data-target="#title_Modal"  data-backdrop="static" data-keyboard=false>相簿名称变更</div>
	<div>
		<?
			$maxwidth = 140;
			$maxheight = 140;
			$sql = "select pho_id , pho_url , pho_jumi_count from photo where alb_id='".$_GET["alb_id"]."'  order by pho_id desc ;";
			$result = mysqli_query($sqli,$sql);
			for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
		?>
			<div id="pho<? echo $row["pho_id"] ?>" class="photo_ImgContainer">
				<div class="photo_shadow"  onmouseover="$(this).stop().animate({'opacity':1},100);" onmouseout="$(this).stop().animate({'opacity':0});">
					<img class="photo_remove" src="include/images/remove.jpg" onclick="delete_pho('<? echo $row["pho_id"] ?>')">
					<div class="photo_jumi"><img src="include/images/heart0.jpg"><? echo $row["pho_jumi_count"]; ?></div>
				</div>
				<?
					list($width, $height, $type, $attr) = getimagesize("update/album_s/".$_GET["alb_id"]."/".$row["pho_url"]);
					if($width > $height){
						$new_width = $width * ($maxheight / $height);
						echo "<img src='update/album_s/".$_GET["alb_id"]."/".$row["pho_url"]."' style='width:".$new_width."px;height:".$maxheight."px;margin-left:-".(($new_width-$maxwidth)/2)."px;'>";
					}
					else if($width < $height){
						$new_height = $height * ($maxwidth / $width);
						echo "<img src='update/album_s/".$_GET["alb_id"]."/".$row["pho_url"]."' style='width:".$maxwidth."px;height:".$new_height."px;margin-top:-".(($new_height-$maxheight)/2)."px;'>";
					}
					else
						echo "<img src='update/album_s/".$_GET["alb_id"]."/".$row["pho_url"]."' style='width:".$maxwidth."px;height:".$maxheight."px;'>";
				?>
			</div>
		<?
		}
		?>
		<input type="hidden" id="photo_count" name="photo_count" value="<? echo $i; ?>">
		<div class="photo_add">
			<section class="add_btn" data-toggle="modal" data-target="#user_photo_Modal"  data-backdrop="static" data-keyboard=false>
		</div>
	</div>
</div>
<!--相簿封面设定-->
	<div class="modal fade" id="cover_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<input type="hidden" id="alb_cover" name="alb_cover" value="" >
	      	<?
	      		$sql = "select alb_cover from album where alb_id=".$_GET["alb_id"];
	      		$result = mysqli_query($sqli,$sql);
	      		$row = mysqli_fetch_array($result);
	      		$alb_cover = $row["alb_cover"];
						$sql = "select pho_id , pho_url , pho_jumi_count from photo where alb_id='".$_GET["alb_id"]."'  order by pho_id desc ;";
						$result = mysqli_query($sqli,$sql);
						$rs_cn = mysqli_num_rows($result);
						$cover_count = $rs_cn;
						for($i=0 ; $i < $row = mysqli_fetch_array($result) ;++$i){
							if($row["pho_url"]==$alb_cover){
					?>
						<div id="cover<? echo $i; ?>" style="padding:5px;border-width:1px;border-color:#000;border-style:solid;" onclick="change_cover_hover(<? echo $i.",".$row["pho_id"]?>);">
					<?
						}else{
					?>
						<div id="cover<? echo $i; ?>" style="padding:5px;border-width:1px;border-color:#FFF;border-style:solid;" onclick="change_cover_hover(<? echo $i.",".$row["pho_id"]?>);">
					<? } ?>
								<img src="update/album_s/<? echo $_GET["alb_id"]."/".$row["pho_url"] ?>" style="width:50px;height:50px;">
						</div>
					<?
					}
					?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="change_cover();">确定</button>
	      </div>
	    </div>
	  </div>
	</div>
<!--上传图片-->
<form id='photo_form' action='ajax/album.php' method="post" enctype="multipart/form-data">
	<div class="modal fade" id="user_photo_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<input type="hidden" id="action" name="action" value="add_pho" >
	      	<input type="hidden" id="alb_id" name="alb_id" value="<? echo $_GET["alb_id"]; ?>" >
	      	<div id="new_alb_div">
	      		<div id="files" class="files"></div>
	      		<div class="image-upload">
						    <label for="file-input">
						        <img src="include/images/add.jpg" style="width:50px;">
						    </label>
						    <input id="fileupload" type="file" name="files[]" multiple onchange="javascript:setImagePreviews();" accept="image/*">
						</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="add_pho();">确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<!--變更相簿名稱-->
<div class="modal fade" id="title_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<input type="text" id="alb_title" name="alb_title" value="<? echo $alb_title; ?>" class="form-control">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="change_title();">确定</button>
	      </div>
	    </div>
	  </div>
	</div>
<script>
		function re_change_title(mytext){
			$("#title_Modal").modal("hide");
			if(mytext == "0"){
				alert("相簿名稱更新完成");
			}
			else{
				alert(mytext);
			}
		}
		function change_title(){
			var str = "";
	  	str = "action=change_title&alb_id=<? echo $_GET["alb_id"]; ?>&alb_title="+Dd("alb_title").value;
			CallServer("ajax/album.php", str, "POST", true, "mytext",re_change_title );
		}
		function re_change_cover(mytext){
			$("#cover_Modal").modal("hide");
			if(mytext == "0"){
				alert("相簿封面更新完成");
			}
			else{
				alert(mytext);
			}
		}
		function change_cover(){
			var str = "";
	  	str = "action=set_cover&alb_id=<? echo $_GET["alb_id"]; ?>&pho_id="+Dd("alb_cover").value;
			CallServer("ajax/album.php", str, "POST", true, "mytext",re_change_cover );
		}

		function change_cover_hover(member , pho_id){
			for(var i = 0 ; i < <? echo $cover_count; ?> ; ++i){
				Dd("cover"+i).style.borderColor = "#FFF";
			}
			Dd("cover"+member).style.borderColor = "#000";
			Dd("alb_cover").value = pho_id;
		}

		function re_delete_pho(mytext){
			var arr = new Array();
			arr = mytext.split("|");
			if(arr[0]=="1"){
				alert(arr[1]);
			}
			else if(arr[0]=="0"){
				Dd("pho"+arr[1]).parentNode.removeChild(Dd("pho"+arr[1]));
			}
			else{
				alert(mytext);
			}
		}

		function delete_pho(pho_id){
			if(!confirm("确定删除该照片？")){
				;
			}
			else{
				var str = "";
	  		str = "action=remove_pho&pho_id="+pho_id;
	      CallServer("ajax/album.php", str, "POST", true, "mytext",re_delete_pho );
			}
		}

		function add_pho(){
			if(Dd("fileupload").value==""){
				$("#user_photo_Modal").modal("hide");
			}
			else{
				Dd("photo_form").submit();
			}
		}

    //下面用于多图片上传预览功能

    function setImagePreviews(avalue) {

        var docObj = document.getElementById("fileupload");

        var dd = document.getElementById("files");

        dd.innerHTML = "";

        var fileList = docObj.files;

        for (var i = 0; i < fileList.length; i++) {

            dd.innerHTML += "<div id='img_div"+i+"' style='float:left;padding:5px;'  onclick='change_focus("+i+","+fileList.length+")' > <img id='img" + i + "'/> </div>";

            var imgObjPreview = document.getElementById("img"+i);

            if (docObj.files && docObj.files[i]) {

                //火狐下，直接设img属性

                imgObjPreview.style.display = 'block';

                imgObjPreview.style.width = '150px';

                imgObjPreview.style.height = '180px';

                //imgObjPreview.src = docObj.files[0].getAsDataURL();

                //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式

                imgObjPreview.src = window.URL.createObjectURL(docObj.files[i]);

            }

            else {

                //IE下，使用滤镜

                docObj.select();

                var imgSrc = document.selection.createRange().text;

                alert(imgSrc)

                var localImagId = document.getElementById("img" + i);

                //必须设置初始大小

                localImagId.style.width = "150px";

                localImagId.style.height = "180px";

                //图片异常的捕捉，防止用户修改后缀来伪造图片

                try {

                    localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";

                    localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;

                }

                catch (e) {

                    alert("您上传的图片格式不正确，请重新选择!");

                    return false;

                }

                imgObjPreview.style.display = 'none';

                document.selection.empty();

            }

        }

        return true;

    }
</script>