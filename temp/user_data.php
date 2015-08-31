<?
	include_once("include/dbinclude.php");
	$sql = "select a.* , b.* from user a, member b where a.uid = b.uid AND a.uid='".$_SESSION["user_id"]."';";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
	// 會員編號
	$member_id = "";
	for($n = 0 ; $n < 7-strlen($_SESSION["user_id"]) ; ++$n)
		$member_id .= "0";
	$member_id .= $_SESSION["user_id"];
	if($row["ident_code"]!=""){
		$member_id .= "-";
		for($n = 0 ; $n < 6-strlen($row["ident_code"]) ; ++$n)
			$member_id .= "0";
		$member_id .= $row["ident_code"];
	}
	function mysql_datetonoyear($date){
		$arr = Array();
		$arr = explode("-",$date);
		return $arr[1]."/".$arr[2];
	}
?>
<div class="user_leftBox">
	<div class="user_account">
		<div class="personal inner_border">
			<div style="width:160px;height:160px;border-radius: 50em;">
				<img src="<? echo $_SESSION["user_photo"]; ?>" data-toggle="modal" data-target="#user_photo_Modal"  data-backdrop="static" data-keyboard=false style="width:160px;height:160px;border-radius:50em;"> <!-- onclick="$('#user_photo_Modal').modal('show');"-->
			</div>
			<div><? echo $_SESSION["user_nick"]; ?></div>
			<div>
				会员编号：
				<? echo $member_id; ?>
			</div>
			<div>
				<img src="include/images/heart0.jpg" style="width:16px;height:16px;"> <? echo $row["fa_count"]; ?>
			</div>
			<a href="user_edit.php">帐户设定</a>
		</div>
		<div class="personal_info inner_border">
		<table>
			<tr>
				<td>性别︰</td>
				<td>
					<?
						if($row["sex"]==0)
							echo "男";
						else
							echo "女";
					?>
				</td>
			</tr>
			<? if($row["sex"]!=0){ ?>
			<tr>
				<td>三围︰</td>
				<td>
					<?
						echo $row["measure"];
					?>
				</td>
			</tr>
			<? } ?>
			<tr>
				<td>所在地︰</td>
				<td>
					<?
						$sql1 = "select name from code where id='".$row["city_cate"]."' ;";
						$result1 = mysqli_query($sqli,$sql1);
						$row1 = mysqli_fetch_array($result1);
						echo $row1["name"];

						$sql1 = "select name from code where id='".$row["city_code"]."' ;";
						$result1 = mysqli_query($sqli,$sql1);
						$row1 = mysqli_fetch_array($result1);
						echo $row1["name"];

					?>
				</td>
			</tr>
			<tr>
				<td>生日︰</td>
				<td>
					<?
						echo $row["birth_day"];
					?>
				</td>
			</tr>
			<tr>
				<td>身高︰</td>
				<td>
					<?
						echo $row["height"]." cm";
					?>
				</td>
			</tr>
			<tr>
				<td>体重︰</td>
				<td>
					<?
						echo $row["weight"]." kg";
					?>
				</td>
			</tr>
			<?
				if($row["sex"]=="1"){
			?>
			<tr>
				<td>三围︰</td>
				<td></td>
			</tr>
			<?
				}
			?>
			<tr>
				<td>血型︰</td>
				<td>
					<?
						echo $row["blood_type"];
					?>
				</td>
			</tr>
			<tr>
				<td>信仰︰</td>
				<td>
					<?
						$sql1 = "select name from code where id='".$row["faith"]."' ;";
						$result1 = mysqli_query($sqli,$sql1);
						$row1 = mysqli_fetch_array($result1);
						echo $row1["name"];
					?>
				</td>
			</tr>
			<tr>
				<td>学历︰</td>
				<td>
					<?
						$sql1 = "select name from code where id='".$row["edu_bg"]."' ;";
						$result1 = mysqli_query($sqli,$sql1);
						$row1 = mysqli_fetch_array($result1);
						echo $row1["name"];
					?>
				</td>
			</tr>
			<tr>
				<td>职业︰</td>
				<td>
					<?
						$sql1 = "select name from code where id='".$row["job"]."' ;";
						$result1 = mysqli_query($sqli,$sql1);
						$row1 = mysqli_fetch_array($result1);
						echo $row1["name"];
					?>
				</td>
			</tr>
			<tr>
				<td>兴趣︰</td>
				<td>
					<?
						$interest = explode("|",$row["interest"]);
						for($i = 0 ; $i < count($interest);++$i){
							$sql1 = "select name from code where id='".$interest[$i]."' ;";
							$result1 = mysqli_query($sqli,$sql1);
							$row1 = mysqli_fetch_array($result1);
							echo $row1["name"]." ";
						}
					?>
				</td>
			</tr>
		</table>
		<a href="user_edit.php">修改资料</a>
		</div>
		<div class="intro">
			<?
				echo $row["introduction"];
			?>
		</div>
	</div>
	<div class="user_match">
		<div>徵友条件</div>
		<?
			$sql_re = "select * from member_require	where uid='".$_SESSION["user_id"]."';";
			$result_re = mysqli_query($sqli,$sql_re);
			$rs_cn_re = mysqli_num_rows($result_re);
			if($rs_cn_re==0){
		?>
		<div>
			<table>
				<tr>
					<td>性别︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>所在地︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>年龄︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>身高︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>体重︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>血型︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>信仰︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>最低学历︰</td>
					<td>不拘</td>
				</tr>
				<tr>
					<td>职业︰</td>
					<td>不拘</td>
				</tr>
			</table>
		</div>
		<div>
			无
		</div>
		<?
			}else{
				$row_re = mysqli_fetch_array($result_re);
		?>
		<div class="match_info inner_border">
			<table>
				<tr>
					<td>性别︰</td>
					<td>
						<?
							if($row_re["re_sex"]=='0')
								echo "男";
							else if($row_re["re_sex"]=='1')
								echo "女";
							else if($row_re["re_sex"]=='2')
								echo "不拘";
						?>
					</td>
				</tr>
				<tr>
					<td>所在地︰</td>
					<td>
						<?
							if($row_re["re_city_cate"]==""){
								echo "不拘";
							}
							else{
								$sql1 = "select name from code where id='".$row_re["re_city_cate"]."' ;";
								$result1 = mysqli_query($sqli,$sql1);
								$row1 = mysqli_fetch_array($result1);
								echo $row1["name"];
								if($row_re["re_city_code"]!=""){
									$sql1 = "select name from code where id='".$row_re["re_city_code"]."' ;";
									$result1 = mysqli_query($sqli,$sql1);
									$row1 = mysqli_fetch_array($result1);
									echo " ".$row1["name"];
								}
							}
						?>
					</td>
				</tr>
				<tr>
					<td>年龄︰</td>
					<td>
						<?
							if($row_re["re_age"]=="18|60")
								echo "不拘";
							else{
								$age = explode("|",$row_re["re_age"]);
								echo $age[0]."~".$age[1];
							}
						?>
					</td>
				</tr>
				<tr>
					<td>身高︰</td>
					<td>
						<?
							if($row_re["re_height"]=="120|220")
								echo "不拘";
							else{
								$height = explode("|",$row_re["re_height"]);
								echo $height[0]."~".$height[1];
							}
						?>
					</td>
				</tr>
				<tr>
					<td>体重︰</td>
					<td>
						<?
							if($row_re["re_weight"]=="30|150")
								echo "不拘";
							else{
								$weight = explode("|",$row_re["re_weight"]);
								echo $weight[0]."~".$weight[1];
							}
						?>
					</td>
				</tr>
				<tr>
					<td>血型︰</td>
					<td>
						<?
							if($row_re["re_blood_type"]=='X')
								echo "不拘";
							else
								echo $row_re["re_blood_type"];
						?>
					</td>
				</tr>
				<tr>
					<td>信仰︰</td>
					<td>
						<?
							if($row_re["re_faith"]=='0')
								echo "不拘";
							else{
								$sql1 = "select name from code where id='".$row_re["re_faith"]."' ;";
								$result1 = mysqli_query($sqli,$sql1);
								$row1 = mysqli_fetch_array($result1);
								echo $row1["name"];
							}
						?>
					</td>
				</tr>
				<tr>
					<td>最低学历︰</td>
					<td>
						<?
							if($row_re["re_edu_bg"]=='0')
								echo "不拘";
							else{
								$sql1 = "select name from code where id='".$row_re["re_edu_bg"]."' ;";
								$result1 = mysqli_query($sqli,$sql1);
								$row1 = mysqli_fetch_array($result1);
								echo $row1["name"];
							}
						?>
					</td>
				</tr>
				<tr>
					<td>职业︰</td>
					<td>
						<?
							if($row_re["re_job"]=='0')
								echo "不拘";
							else{
								$sql1 = "select name from code where id='".$row_re["re_job"]."' ;";
								$result1 = mysqli_query($sqli,$sql1);
								$row1 = mysqli_fetch_array($result1);
								echo $row1["name"];
							}
						?>
					</td>
				</tr>
			</table>
		</div>
		<div class="intro">
			<?
				if($row_re["re_note"]=="")
					echo "无";
				else
					echo $row_re["re_note"];
			?>
		</div>
		<?
			}
		?>
		<a href="user_edit.php">修改资料</a>
	</div>
	<div style="width: 51%;float: left;clear: left;padding-top: 1%">
	<div class="user_gift">
		<div>我的礼物</div>
		<?
			$sql_gift = "select a.*, DATE_FORMAT(b.gift_date,'%Y-%m') as momth , b.* from gift a , point b where a.uid = b.uid AND a.uid='".$_SESSION["user_id"]."';";
			$result_gift = mysqli_query($sqli,$sql_gift);
			$row_gift = mysqli_fetch_array($result_gift);
		?>
		<div>
			<table class="gift_number inner_border">
				<tr>
					<td><img src="include/images/flower.jpg"></td>
					<td><? echo $row_gift["flower_r"]; ?></td>
					<td><img src="include/images/gift.jpg"></td>
					<td><? echo $row_gift["gift_r"]; ?></td>
					<td><img src="include/images/bouquet.jpg"></td>
					<td><? echo $row_gift["bouquet_r"]; ?></td>
				</tr>
				<tr>
					<td><img src="include/images/ring.jpg"></td>
					<td><? echo $row_gift["ring_r"]; ?></td>
					<td><img src="include/images/bracelet.jpg"></td>
					<td><? echo $row_gift["bracelet_r"]; ?></td>
					<td><img src="include/images/gold.jpg"></td>
					<td><? echo $row_gift["gold_r"]; ?></td>
				</tr>
				<tr>
					<td><img src="include/images/crystal.jpg"></td>
					<td><? echo $row_gift["crystal_r"]; ?></td>
					<td><img src="include/images/diamond.jpg"></td>
					<td><? echo $row_gift["diamond_r"]; ?></td>
					<td><img src="include/images/crown.jpg"></td>
					<td><? echo $row_gift["crown_r"]; ?></td>
				</tr>
			</table>
			<div class="gift_point inner_border">
				<div class="font_strong">当月积分︰</div>
				<div class="font_stronger">
					<?
					if(strtotime($row_gift["gift_date"]) >= strtotime(date("Y-m-01 00:00:00")))
						echo $row_gift["month_point"];
					else
						echo 0;
					?>
				</div>
				<section></section>
				<div class="font_strong">累积积分︰</div>
				<div class="font_stronger"><? echo $row_gift["total_point"]; ?></div>
				<section></section>
				<div class="font_strong">全站排名︰</div>
				<div class="font_stronger"></div>
			</div>
			<div>
				<table>
				<?
					$sql1 = "select a.* , b.nick as gr_name ,c.gift_name_ch from gift_record a
					INNER JOIN member b ON a.uid = b.uid LEFT JOIN gift_price as c ON c.gift_name = a.gift_type
					where a.gr_uid='12' order by a.gr_date DESC limit 0,5";
					/*
					$sql1 = "select a.* , b.nick as gr_name from gift_record a , member b
					where a.gr_uid='".$_SESSION["user_id"]."' AND a.uid = b.uid order by a.gr_date DESC limit 0,5;";
					echo $sql1;
					*/
					$result1 = mysqli_query($sqli,$sql1);
					$rs_cn1 = mysqli_num_rows($result1);
					if($rs_cn1 == 0){
						echo "尚未拥有收礼纪录，请加油";
					}
					else{
						while($row1 = mysqli_fetch_array($result1)){
					?>
						<tr>
							<td><? echo mysql_datetonoyear($row1["gr_date"]); ?></td>
							<td><? echo "　".$row1["gr_name"]; ?> 送了你 <? echo $row1["gift_name_ch"]."　　".$row1["gift_count"]."个"; ?></td>
						</tr>
					<?
						}
					}
					?>
				</table>
			</div>
		</div>
	</div>
	<div class="user_album">
		<div>我的相簿</div>
		<?
			$sql1 = "select * from album where uid='".$_SESSION["user_id"]."' order by creat_date limit 0,3;";
			$result1 = mysqli_query($sqli,$sql1);
			$rs_cn1 = mysqli_num_rows($result1);
			if($rs_cn1 == 0){
				echo "尚未建立相簿，快建立起来让大家欣赏～";
			}
			else{
				while($row1 = mysqli_fetch_array($result1)){
		?>
			<div onclick="location.href='user_photo?alb_id=<? echo $row1["alb_id"];?>'" class="albumImgContainer">
				<div class="album_imgSize">
					<img src="update/album_s/<? echo $row1["alb_id"]."/".$row1["alb_cover"]; ?>">
				</div>
				<div>
					<? echo $row1["alb_title"]; ?>
					<?
						if($row1["alb_state"]=='1'){echo "<br/><font style='color:red'>以被管理员设定隐藏</font>";}
					?>
				</div>
				<div>
					<? echo $row1["pho_count"]; ?>
				</div>
			</div>
		<?
				}
			}
		?>
		<a href="user_album.php">＞查看所有</a>
	</div>
	</div>
	<div style="width: 49%;float: left;padding: 1% 0 0 1%">
	<div class="user_favorite">
		<div>我的收藏</div>
		<?
			$sql1 = "select b.photo_url , b.sex , b.uid from favorite a , member b ,user c where a.uid='".$_SESSION["user_id"]."' AND a.fa_uid = b.uid AND a.fa_uid = c.uid AND c.state != 9 limit 0,10;";
			$result1 = mysqli_query($sqli,$sql1);
			$rs_cn1 = mysqli_num_rows($result1);
			if($rs_cn1 == 0){
				echo "尚未拥有收藏";
			}
			else{
				while($row1 = mysqli_fetch_array($result1)){
					$face_photo_url = "";
					if($row1["photo_url"]!="")
						$face_photo_url="update/face_photo/".$row1["photo_url"];
					else
						if($row1["sex"]=="1")
							$face_photo_url="include/images/girl.jpg";
						else
							$face_photo_url="include/images/boy.jpg";
		?>
			<div>
				<div class="favorite_imgContainer">
					<a href="member_data.php?uid=<? echo $row1["uid"]; ?>"><img src="<? echo $face_photo_url; ?>"></a>
				</div>
			</div>
		<?
				}
			}
		?>
		<a href="favorite.php">＞查看所有</a>
	</div>
	<div class="user_shop">
		<div>我的抽屉</div>
		<div>
			<table class="gift_number inner_border">
				<tr>
					<td><img src="include/images/flower.jpg"></td>
					<td><? echo $row_gift["flower_o"]; ?></td>
					<td><img src="include/images/gift.jpg"></td>
					<td><? echo $row_gift["gift_o"]; ?></td>
					<td><img src="include/images/bouquet.jpg"></td>
					<td><? echo $row_gift["bouquet_o"]; ?></td>
				</tr>
				<tr>
					<td><img src="include/images/ring.jpg"></td>
					<td><? echo $row_gift["ring_o"]; ?></td>
					<td><img src="include/images/bracelet.jpg"></td>
					<td><? echo $row_gift["bracelet_o"]; ?></td>
					<td><img src="include/images/gold.jpg"></td>
					<td><? echo $row_gift["gold_o"]; ?></td>
				</tr>
				<tr>
					<td><img src="include/images/crystal.jpg"></td>
					<td><? echo $row_gift["crystal_o"]; ?></td>
					<td><img src="include/images/diamond.jpg"></td>
					<td><? echo $row_gift["diamond_o"]; ?></td>
					<td><img src="include/images/crown.jpg"></td>
					<td><? echo $row_gift["crown_o"]; ?></td>
				</tr>
			</table>
			<div class="gift_point inner_border">
				<div>持有虚拟货币︰<? echo $row_gift["coin"]; ?></div>
				<a href="shop.php">＞购买礼物/储值</a>
			</div>
			<div>
				<table>
				<?
					$sql1 = "select a.* , b.nick as gr_name ,c.gift_name_ch from gift_record a
					INNER JOIN member b ON a.gr_uid = b.uid LEFT JOIN gift_price as c ON c.gift_name = a.gift_type
					 where a.uid='".$_SESSION["user_id"]."' order by a.gr_date DESC limit 0,5;";
					$result1 = mysqli_query($sqli,$sql1);
					$rs_cn1 = mysqli_num_rows($result1);
					if($rs_cn1 == 0){
						echo "尚未拥有送出礼物，赶紧找寻心仪对象送出～";
					}
					else{
						while($row1 = mysqli_fetch_array($result1)){
					?>
						<tr>
							<td><? echo mysql_datetonoyear($row1["gr_date"]); ?></td>
							<td> 你送了 <? echo "　".$row1["gift_name_ch"]."　".$row1["gift_count"]."个"; ?> 给 <? echo "　".$row1["gr_name"]; ?></td>
						</tr>
					<?
						}
					}
					?>
				</table>
			</div>
		</div>
	</div><!--我的抽屜-->
	</div>
</div>
<!--**************塗鴉牆******************-->
<!--iframe src="user_wall.php" width="32%" height="1000px" frameborder="0" scrolling="yes"></iframe scroll-->
<div class="user_rightBox">
	<div class="release_Wrapper">
		<!--發布用-->
		<form id='wall_form' action='ajax/wall.php' method="post" enctype="multipart/form-data">
			<div class="release">
				<img src="<? echo $_SESSION["user_photo"]; ?>" class="small_photo">
				<!--div class="releaseText" onclick="none('wall_default');block('wall_content');Dd('wall_content').focus();">
					<font id="wall_default">你的留言及相片</font>
				</div-->
				<div class="release_Text">
				<textarea id="wall_content" name="wall_content" class="form-control wall_keyin" style="resize:none;"  onkeyup="autogrow(this);" placeholder="你的留言或照片"></textarea><!-- onblur="none(this.id);block('wall_default');Dd(this.id).value='';"-->
				</div>
				<div id="wall_post_div" class="wall_post_imgContainer">
					<img src="include/images/remove.jpg" onclick="Dd('wall_photo').value='';Dd('wall_post_img').src='';none('wall_post_div');" class="release_removeBtn">
					<img id="wall_post_img" class="wall_post_img">
				</div>
				<div style="clear: both"></div>
			</div>
			<input type="hidden" id="wall_action" name="action" value="wall_add">
			<input type="button" class="add" id="wall_add_btn" name="wall_add_btn" onclick="wall_add();" value="发布" >
			<span>
				<input type='file' id="wall_photo" name="wall_photo" accept="image/*" onchange="none('wall_default');block('wall_content');" style="display:none;">
				<img src="include/images/add.jpg" class="add" onclick="$('#wall_photo').click();">
			</span>

		</form>

	</div>
	<div class="show_Wrapper">
		<!--顯示用-->
		<?
			$sql1 = "select * from wall where uid =".$_SESSION["user_id"]." order by creat_date desc limit 0,5;";
			$result1 = mysqli_query($sqli,$sql1);
			$rs_cn1 = mysqli_num_rows($result1);
			if($rs_cn1 == 0){
				echo "尚未发布讯息至涂鸦墙";
			}
			else{
				while($row1 = mysqli_fetch_array($result1)){
			?>
				<div class="Show" id="wall_div<? echo $row1["wa_id"]; ?>">
					<img src="<? echo $_SESSION["user_photo"]; ?>" class="small_photo">
					<span class="nameDate">
						<font class="font_strong"><? echo $_SESSION["user_nick"]; ?></font><? if($row1['wa_state']=='1'){echo "<font style='color:red'>管理员设定隐藏中</font>";}?><br/>
						<font class="font_small"><? echo $row1["creat_date"]; ?></font>
					</span>
					<div class="dropdown show_edit">
						  <button class="btn" type="button" id="dropdownMenu<? echo $row1["wa_id"]; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu edit_menu" aria-labelledby="dropdownMenu<? echo $row1["wa_id"]; ?>">
						    <li><a data-toggle="modal" data-target="#wall_edit_Modal"  data-backdrop="static" data-keyboard=false onclick=wall_edit("<? echo $row1["wa_id"]; ?>");>编辑</a></li>
						    <li><a onclick=wall_remove("<? echo $row1["wa_id"]; ?>");>删除</a></li>
						  </ul>
					</div>
					<?
						$wa_content = $row1["wa_content"];;
						$wa_content = str_replace("\n","<br/>",$wa_content);
					?>
					<div class="show_content">
						<div id="wall_content<? echo $row1["wa_id"]; ?>"><? echo $wa_content; ?></div>
					<? if($row1["wall_photo"]!=null){ ?>
					<div><img src="update/wall_s/<? echo $row1["wall_photo"]; ?>"></div>
					<? }else{ ?>
					<div></div>
					<? } ?></div>
					<div class="show_heart"><img src="include/images/heart0.jpg"> <? echo $row1["wa_jumi_count"]; ?></div>
				</div>
			<?
				}
			}
			?>

	</div>
</div>
<form id='face_photo_form' action='ajax/album.php' method="post" enctype="multipart/form-data">
	<div class="modal fade" id="user_photo_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	      	<div onclick="none('folder_div');none('photo_div');block('file_div');without_chose();Dd('photo_from').value='file_update';">从本地上传</div>
	      	<div onclick="none('file_div');block('folder_div');without_chose();Dd('photo_from').value='album';">从相簿选择</div>
	      	<input type="hidden" id="photo_from" name="photo_from" value="" >
	      	<input type="hidden" id="photo_alive" name="photo_alive" value="" >
	      	<input type="hidden" id="action" name="action" value="face_photo" >
	      	<input type="hidden" id="alb_id" name="alb_id" value="" >
	      	<input type="hidden" id="pho_url" name="pho_url" value="" >
	      </div>
	      <div class="modal-body">
	      	<div id="file_div" style="display:none">
	      		<input type='file' id="imgInp" name="imgInp" />
	      	</div>
	      	<div id="folder_div" style="display:none">
	      		<?
	      			$sql = "select * from album where uid = ".$_SESSION["user_id"];
	      			$result = mysqli_query($sqli,$sql);
	      			while($row = mysqli_fetch_array($result)){
	      		?>
	      			<div onclick="show_phto(<? echo $row["alb_id"]; ?>);" style="float:left;">
	      				<img src="include/images/folder.jpg" style="width:50px;herght:50px;">
	      				<div><? echo $row["alb_title"];?></div>
	      			</div>
	      		<?
	      			}
	      		?>
	      	</div>
	      	<div id="photo_div" style="clear:both;display:none">
	      		<!--div onclick="block('folder_div');none('photo_div');without_chose();"><img src="include/images/back.jpg" style="width:50px;height:50px;"></div-->
	      		<div id="alb_photo">
	      		</div>
	      	</div>
	      	<div style="clear:both;">

		        <div id="user_pho_before" class="container">
							<p>
								<img id="ferret" src="include/images/no_chose.jpg" alt="It's coming right for us!"
								 title="It's coming right for us!" style="float: left; max-width:400px;" />
							</p>
						</div>
						<input type="hidden" id="x1" name="x1" value="" />
						<input type="hidden" id="y1" name="y1" value="" />
						<input type="Hidden" id="x2" name="x2" value="" />
						<input type="hidden" id="y2" name="y2" value="" />
						<input type="Hidden" id="resize_width" name="resize_width" value="" />
						<input type="hidden" id="resize_height" name="resize_height" value="" />
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_changeimg();">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="change_face_photo();">确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<form id='wall_edit_form' action='ajax/wall.php' method="post">
	<div class="modal fade" id="wall_edit_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	      	<h1>涂鸦墙编辑</h1>
	      </div>
	      <div class="modal-body">
	      	<input type="hidden" id="wall_edit_id" name="wall_edit_id" value="">
	      	<input type="hidden" id="action" name="action" value="wall_edit" >
	      	<textarea id="wall_edit_content" name="wall_edit_content" class="form-control" style="resize:none;"  onkeyup="autogrow(this);">
	      	</textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_changeimg();">关闭</button>
	        <button type="submit" class="btn btn-primary">确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<script>
	function wall_edit(wa_id){
		Dd("wall_edit_content").value = Dd("wall_content"+wa_id).innerHTML.replace(/<br>/g, "");
		Dd("wall_edit_id").value = wa_id;
    Dd("wall_edit_content").style.height=(Dd("wall_edit_content").scrollHeight+3)+'px';
	}
	function re_wall_remove(mytext){
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=="1")
			alert(arr[1]);
		else if(arr[0]=="0"){
			Dd("wall_div"+arr[1]).parentNode.removeChild(Dd("wall_div"+arr[1]));
		}
		else
			alert(mytext);
	}
	function wall_remove(wa_id){
		if(!confirm("确定将该涂鸦内容删除？")){
			return false;
		}
		else{
			var str = "";
			str = "action=wall_remove&wa_id="+wa_id;
			CallServer("ajax/wall.php", str, "POST", true, "mytext",re_wall_remove );
		}
	}
	function wall_add(){
		if(Dd("wall_content").value==""&&Dd("wall_photo").value=="")
			alert("尚未选择照片以及输入留言，无法送出");
		else
			Dd("wall_form").submit();
	}
	function autogrow(textarea){
		var adjustedHeight=textarea.clientHeight;
    adjustedHeight=Math.max(textarea.scrollHeight,adjustedHeight);
    if (adjustedHeight > textarea.clientHeight){
        textarea.style.height=(adjustedHeight+3)+'px';
    }
	}
	function change_face_photo(){
		if(Dd("photo_alive").value!="1"){
			alert("尚未选择好照片");
		}
		else{
			Dd("face_photo_form").submit();
		}
	}

	function without_chose(){
		Dd("ferret").src = "include/images/no_chose.jpg";
		Dd("preview_img").src = "include/images/no_chose.jpg";
		Dd("photo_alive").value = "";
		cancel_changeimg();
	}

	function change_preview(alb_id , pho_url){
		Dd("ferret").src = "update/album/"+alb_id+"/"+pho_url;
		Dd("preview_img").src = "update/album/"+alb_id+"/"+pho_url;
		Dd("pho_url").value = pho_url;
		Dd("photo_alive").value = "1";
		Dd("resize_width").value = $("#ferret").width();
	  Dd("resize_height").value = $("#ferret").height();
		cancel_changeimg();
	}

	function re_show_phto(mytext){
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		for(var i = 0 ; i < arr.length ; ++i){
			str += "<div onclick=change_preview("+arr[i].alb_id+",'"+arr[i].pho_url+"'); style='float:left;'><img src='update/album/"+arr[i].alb_id+"/"+arr[i].pho_url+"' style='width:50px;height:50px;'></div>";
		}
		Dd("alb_photo").innerHTML = str;
		/*none("folder_div");*/
		block("photo_div");
		without_chose();
	}
	function show_phto(alb_id){
		Dd("alb_id").value = alb_id;
		var str = "";
		str = "action=alb_photo&alb_id="+alb_id;
    CallServer("ajax/album.php", str, "POST", true, "mytext",re_show_phto );
	}
	function cancel_changeimg(){
		var ias = $('#ferret').imgAreaSelect({ instance: true });
		ias.setOptions({ hide: true });
		ias.update();
	}
	function SaveCropEventHandler(){
	    var x1 = $('input[name="x1"]').val();
	    var x2 = $('input[name="x2"]').val();
	    var y1 = $('input[name="y1"]').val();
	    var y2 = $('input[name="y2"]').val();

	    if (x1.length == 0 && x2.length == 0 && y1.length == 0 && y2.length == 0)
	    {
	        alert('請選擇裁剪區域');
	        return false;
	    }
	    else
	    {
	       	alert(Dd("x1").value);
	    }
	}
	function preview(img, selection) {
    var scaleX = 160 / (selection.width || 1);
    var scaleY = 160 / (selection.height || 1);

    $('#ferret + div > img').css({
        width: Math.round(scaleX * $("#ferret").width()) + 'px',
        height: Math.round(scaleY * $("#ferret").height()) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
    $('input[name="x1"]').val(selection.x1);
    $('input[name="y1"]').val(selection.y1);
    $('input[name="x2"]').val(selection.x2);
    $('input[name="y2"]').val(selection.y2);
	}

	$(document).ready(function () {
	    $('<div><img id="preview_img" src="include/images/no_chose.jpg" style="position: relative;" /><div>')
	        .css({
	            float: 'left',
	            position: 'relative',
	            overflow: 'hidden',
	            width: '160px',
	            height: '160px',
	            borderRadius: '50%'
	        })
	        .insertAfter($('#ferret'));

	    $('#ferret').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview });

	});
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $('#ferret').attr('src', e.target.result);
	            $('#preview_img').attr('src', e.target.result);
	            Dd("resize_width").value = $("#ferret").width();
	            Dd("resize_height").value = $("#ferret").height();
	        }
	        reader.readAsDataURL(input.files[0]);

	    }
	}

	$("#imgInp").change(function(){
			Dd("photo_alive").value = "1";
	    readURL(this);
	});
	$("#wall_photo").change(function(){
	    if (this.files && this.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $('#wall_post_img').attr('src', e.target.result);
	            /*Dd("wall_post_div").width = Dd("wall_post_img").width;
	            alert(Dd("wall_post_div").width);*/
	        }
	        reader.readAsDataURL(this.files[0]);
	    }
	    block('wall_post_div');
	});
</script>