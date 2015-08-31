<?
	include_once("include/dbinclude.php");
	$sql = "select a.uid , a.sex , a.photo_url , a.nick  ,(year( from_days( datediff( now( ), a.birth_day )))+1) as age
	,b.name as city_cate_name ,c.name as city_code_name , d.uid as favorite from member a
	inner join user z on a.uid = z.uid AND z.state != 9
	LEFT JOIN code as b ON a.city_cate=b.id
	LEFT JOIN code as c ON a.city_code=c.id
	LEFT JOIN favorite as d ON a.uid=d.fa_uid AND d.uid='".$_SESSION["user_id"]."'";
	if($_GET["search_age0"]==""&&$_GET["search_age1"]=="")
		$sql .=" where (year( from_days( datediff( now( ), a.birth_day )))+1) BETWEEN '18' AND '60'";
	else
		$sql .=" where (year( from_days( datediff( now( ), a.birth_day )))+1) BETWEEN '".$_GET["search_age0"]."' AND '".$_GET["search_age1"]."'";
	if($_GET["search_sex"]!="")
		$sql .=" and a.sex = '".$_GET["search_sex"]."'";
	if($_GET["search_blood_type"]!="")
		$sql .=" and a.blood_type = '".$_GET["search_blood_type"]."'";
	if($_GET["search_faith"]!="")
		$sql .=" and a.faith = '".$_GET["search_faith"]."'";
	if($_GET["search_job"]!="")
		$sql .=" and a.job = '".$_GET["search_job"]."'";
	if($_GET["search_edu_bg"]!="")
		$sql .=" and a.edu_bg >= '".$_GET["search_edu_bg"]."'";
	if($_GET["search_height0"]!="" && $_GET["search_height1"]!="")
		$sql .=" and a.height BETWEEN '".$_GET["search_height0"]."' AND '".$_GET["search_height1"]."'";
	else if($_GET["search_height0"]!="" && $_GET["search_height1"]=="")
		$sql .=" and a.height >= '".$_GET["search_height0"]."' ";
	else if($_GET["search_height0"]=="" && $_GET["search_height1"]!="")
		$sql .=" and a.height <= '".$_GET["search_height1"]."' ";
	if($_GET["search_weight0"]!="" && $_GET["search_weight1"]!="")
		$sql .=" and a.weight BETWEEN '".$_GET["search_weight0"]."' AND '".$_GET["search_weight1"]."'";
	else if($_GET["search_weight0"]!="" && $_GET["search_weight1"]=="")
		$sql .=" and a.weight >= '".$_GET["search_weight0"]."' ";
	else if($_GET["search_weight0"]=="" && $_GET["search_weight1"]!="")
		$sql .=" and a.weight <= '".$_GET["search_weight1"]."' ";
	if($_GET["search_city_code"]!="")
		$sql .=" and a.city_code = '".$_GET["search_city_code"]."'";
	else if($_GET["search_city_cate"]!="")
		$sql .=" and a.city_cate = '".$_GET["search_city_cate"]."'";

	$sql .= " and a.uid != '".$_SESSION["user_id"]."' order by uid desc limit 0,40;";
	$result = mysqli_query($sqli,$sql);
?>
<div>
	<?
		while($row = mysqli_fetch_array($result)){
	?>
		<div id="theGrid" class="search_profileWrapper">
			<section class="grid">
				<!--a class="grid__item" href="member_data.php?uid=<? echo $row["uid"];?>"-->
				<div class="meta meta--preview">
						<?
							$face_photo_url = "";
							if($row["photo_url"]!="")
								$face_photo_url="update/face_photo/".$row["photo_url"];
							else{
								if($row["sex"]=="0")
									$face_photo_url="include/images/boy.jpg";
								else
									$face_photo_url="include/images/girl.jpg";
							}
						?>
						<a href='member_data.php?uid=<? echo $row["uid"];?>' class="animsition-link"><img src="<? echo $face_photo_url; ?>" style="border-Radius:50%;" class="animsition" data-animsition-out="zoom-out-lg"></a>
				</div>
				<span class="category">
						<? echo $row["nick"]."/".$row["age"]."岁"; ?>
				</span>
				<div class="heart">
						<?
							$heart_img = "";
							if($row["favorite"]==""){
						?>
								<img id="heart_img<? echo $row["uid"]; ?>" src="include/images/heart1.jpg" onclick="add_favorite(<? echo $row["uid"]; ?>);">
						<?	}else{ ?>
								<img id="heart_img<? echo $row["uid"]; ?>" src="include/images/heart0.jpg" onclick="remove_favorite(<? echo $row["uid"]; ?>);">
						<? } ?>
				</div>
				<span class="category">
						所在地︰<? echo $row["city_cate_name"]." ".$row["city_code_name"]; ?>
				</span>
				<!--/a-->
			</section>
		</div>
	<?
		}
	?>
</div>

<script>
	function re_add_favorite(mytext){
		var arr = mytext.split("|");
		if(arr[0]=="1"){
			alert(arr[1]);
		}
		else if(arr[0]=="0"){
			Dd("heart_img"+arr[2]).src="include/images/heart0.jpg";
			Dd("heart_img"+arr[2]).setAttribute( "onClick", "javascript: remove_favorite("+arr[2]+");" );
		}
		else{
			alert(mytext);
		}
	}
	function add_favorite(fa_uid){
		var str = "";
		str = "action=add&fa_uid="+fa_uid;
    CallServer("ajax/favorite.php", str, "POST", true, "mytext",re_add_favorite );
	}
	function re_remove_favorite(mytext){
		var arr = mytext.split("|");
		if(arr[0]=="1"){
			alert(arr[1]);
		}
		else if(arr[0]=="0"){
			Dd("heart_img"+arr[2]).src="include/images/heart1.jpg";
			Dd("heart_img"+arr[2]).setAttribute( "onClick", "javascript: add_favorite("+arr[2]+");" );;
		}
		else{
			alert(mytext);
		}
	}
	function remove_favorite(fa_uid){
		var str = "";
		str = "action=remove&fa_uid="+fa_uid;
    CallServer("ajax/favorite.php", str, "POST", true, "mytext",re_remove_favorite );
	}
	$(document).ready(function() {

		  $(".animsition").animsition({

		    inClass               :   'fade-in',
		    outClass              :   'fade-out',
		    inDuration            :    500,//1500
		    outDuration           :    300,//800
		    linkElement           :   '.animsition-link',
		    // e.g. linkElement   :   'a:not([target="_blank"]):not([href^=#])'
		    loading               :    true,
		    loadingParentElement  :   'body', //animsition wrapper element
		    loadingClass          :   'animsition-loading',
		    unSupportCss          : [ 'animation-duration',
		                              '-webkit-animation-duration',
		                              '-o-animation-duration'
		                            ],
		    //"unSupportCss" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
		    //The default setting is to disable the "animsition" in a browser that does not support "animation-duration".

		    overlay               :   false,

		    overlayClass          :   'animsition-overlay-slide',
		    overlayParentElement  :   'body'
		  });
		});
</script>

