<style>
/*
.image-upload > input
{
    display: none;
}
*/
</style>
<?
	include_once("include/dbinclude.php");
	$sql1 = "select alb_id , alb_title, alb_cover , pho_count from album where uid='".$_SESSION["user_id"]."' order by creat_date ;";
	$result1 = mysqli_query($sqli,$sql1);
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
	while($row1 = mysqli_fetch_array($result1)){
	?>
		<div id="alb<? echo $row1["alb_id"]; ?>" class="albumImgContainer">
			<div><img src="include/images/remove.jpg" onclick="delete_alb('<? echo $row1["alb_id"] ?>')"></div>
			<div class="album_imgSize">
				<? if($row1["alb_cover"] != ""){ ?>
				<img src="update/album/<? echo $row1["alb_id"]."/".$row1["alb_cover"]; ?>" onclick="location.href='user_photo.php?alb_id=<? echo $row1["alb_id"]; ?>'">
				<? }else{ ?>
				<img src="include/images/no_chose.jpg" onclick="location.href='user_photo.php?alb_id=<? echo $row1["alb_id"]; ?>'" style="width:130px;height:130px;">
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
	?>
	<div class="albumImgContainer">
		<img src="include/images/add.jpg"  data-toggle="modal" data-target="#user_album_Modal"  data-backdrop="static" data-keyboard=false  style="width:100px;height:100px;">
	</div>
</div>
<form id='album_form' action='ajax/album.php' method="post" enctype="multipart/form-data">
	<div class="modal fade" id="user_album_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	相簿名称<input type="text" id="alb_title" name="alb_title" class="form-contorl">
	      	<input type="hidden" id="album_cover" name="album_cover" value="">
	      	<input type="hidden" id="action" name="action" value="add_album">
	      </div>
	      <div class="modal-body">
	      	<div id="new_alb_div">
	      		<div id="files" class="files"></div>
	      		<div class="image-upload">
						    <label for="file-input">
						        <img src="include/images/add.jpg" style="width:50px;">
						    </label>
						    <input id="fileupload" type="file" name="files[]" multiple onchange="javascript:setImagePreviews();" accept="image/*">
						</div>
				    <div id="progress" class="progress">
				        <div class="progress-bar progress-bar-success"></div>
				    </div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="add_album();">确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<script>
		function re_delete_alb(mytext){
			var arr = new Array();
			arr = mytext.split("|");
			if(arr[0]=="1"){
				alert(arr[1]);
			}
			else if(arr[0]=="0"){
				Dd("alb"+arr[1]).parentNode.removeChild(Dd("alb"+arr[1]));
			}
			else{
				alert(mytext);
			}
		}

		function delete_alb(alb_id){
			if(!confirm("确定删除该相簿？")){
				;
			}
			else{
				var str = "";
	  		str = "action=remove_album&alb_id="+alb_id;
	      CallServer("ajax/album.php", str, "POST", true, "mytext",re_delete_alb );
			}
		}
		function add_album(){
			if(Dd("alb_title").value=="")
				alert("相簿未命名，不可新增");
			else
				Dd("album_form").submit();
		}
		function change_focus(i,count){
			for(var n = 0 ; n < count ; ++n)
				Dd("img_div"+n).style="border:#FFF";
			Dd("img_div"+i).style="border:#0CF";
			Dd("album_cover").value=i;
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