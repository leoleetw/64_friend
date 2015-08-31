<?
	include_once("include/dbinclude.php");
	$uid = isset($_POST["uid"]) ? $_POST['uid'] : $_GET['uid'] ;
	$sql = "select a.* , b.uid as favorite ,c.rep_id as report from  member a
	LEFT JOIN favorite as b ON a.uid=b.fa_uid AND b.uid = '".$_SESSION["user_id"]."'
	LEFT JOIN report as c ON a.uid=c.rep_target AND c.uid = '".$_SESSION["user_id"]."' AND c.rep_type = 'member'
	where a.uid='".$uid."';";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
	$nick = $row["nick"];
	function mysql_datetonoyear($date){
		$arr = Array();
		$arr = explode("-",$date);
		return $arr[1]."/".$arr[2];
	}
?>
<div class="user_leftBox">
	<div class="user_account">
		<div class="personal inner_border">
			<div>
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
				<img src="<? echo $face_photo_url; ?>" style="width:160px;height:160px;border-radius:50em;"> <!-- onclick="$('#user_photo_Modal').modal('show');"-->
			</div>
			<div><? echo $nick; ?></div>
			<div>
				会员编号：
				<?
					for($n = 0 ; $n < 7-strlen($row["uid"]) ; ++$n)
						echo "0";
					echo $row["uid"];
					if($row["ident_code"]!=""){
						echo "-";
						for($n = 0 ; $n < 6-strlen($row["ident_code"]) ; ++$n)
							echo "0";
						echo $row["ident_code"];
					}
				?>
			</div>
			<div class="heart">
					<?
						$heart_img = "";
						if($row["favorite"]==""){
					?>
							<input type="hidden" id="fa_state" name="fa_state" value="1">
							<img id="heart_img" src="include/images/heart1.jpg" onclick="add_favorite(<? echo $row["uid"]; ?>);">
					<?	}else{ ?>
							<input type="hidden" id="fa_state" name="fa_state" value="0">
							<img id="heart_img" src="include/images/heart0.jpg" onclick="add_favorite(<? echo $row["uid"]; ?>);">
					<? } ?>
					<font id="fa_count"><? echo $row["fa_count"]; ?></font>
					<img src="include/images/send_gift.jpg" data-toggle="modal" data-target="#send_gift_Modal"  data-backdrop="static" data-keyboard=false>
			</div>
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
		</div>
		<div class="dropdown">
		  <button class="btn" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
		  	<? if($row["report"]!=""){ ?>
		  	<li><a onclick="alert('此会员以被你检举，请勿再次点击')">检举</a></li>
		  	<? }else{ ?>
		    <li><a data-toggle="modal" data-target="#member_report_Modal"  data-backdrop="static" data-keyboard=false onclick=member_report("<? echo $row["uid"]; ?>");>检举</a></li>
		  	<? } ?>
		  </ul>
		</div>
		<div>
			<?
				echo $row["introduction"];
			?>
		</div>
	</div>
	<div class="user_match">
		<div>徵友条件</div>
		<?
			$sql_re = "select *  from member_require where uid='".$uid."';";
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
		<div>
			<table class="match_info inner_border">
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
		<div>
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
	</div>
	<div class="member_album">
		<div>个人相簿</div>
		<?
			$sql1 = "select * from album where uid='".$uid."' AND alb_state = 0 order by creat_date limit 0,3;";
			$result1 = mysqli_query($sqli,$sql1);
			$rs_cn1 = mysqli_num_rows($result1);
			if($rs_cn1 == 0){
				echo "尚未建立相簿，快建立起来让大家欣赏～";
			}
			else{
				while($row1 = mysqli_fetch_array($result1)){
		?>
			<div class="albumImgContainer">
				<div class="album_imgSize">
					<img src="update/album_s/<? echo $row1["alb_id"]."/".$row1["alb_cover"]; ?>" onclick="location.href='photo.php?alb_id=<? echo $row1["alb_id"]; ?>'">
				</div>
				<div class="font_strong">
					<? echo $row1["alb_title"]; ?>
				</div>
				<div>
					<? echo $row1["pho_count"]; ?>
				</div>
			</div>
		<?
				}
			}
		?>
		<a href="album.php?uid=<? echo $uid; ?>">＞查看所有</a>
	</div>
	<div class="member_gift">
		<div>个人礼物</div>
		<?
			$sql_gift = "select a.*, DATE_FORMAT(b.gift_date,'%Y-%m') as momth ,b.* from gift a , point b where a.uid = b.uid AND a.uid='".$uid."';";
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
				<div class="font_stronger"><? echo $row_gift["total_point"];?></div>
				<section></section>
				<div class="font_strong">全站排名︰</div>
				<div class="font_stronger"></div>
			</div>
			<div>
				<table>
				<?
					$sql1 = "select a.* , b.nick as gr_name from gift_record a , member b where a.gr_uid='".$uid."' AND a.uid = b.uid order by a.gr_date DESC limit 0,5;";
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
							<td><? echo $row1["gr_name"]; ?> 送了 <? echo $nick." ".$row1["gift_type"]."　　".$row1["gift_count"]."个"; ?> </td>
						</tr>
					<?
						}
					}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="user_rightBox">
	<!--顯示用-->
	<div class="show_Wrapper">
		<?
			$sql1 = "select a.* , b.uid as jumi, c.rep_id as report from wall a
			LEFT JOIN jumi as b ON a.wa_id=b.jumi_target AND b.uid = '".$_SESSION["user_id"]."' AND b.jumi_type='wall'
			LEFT JOIN report as c ON a.wa_id=c.rep_target AND c.uid = '".$_SESSION["user_id"]."' AND c.rep_type='wall'
			where a.uid =".$uid." AND a.wa_state = 0 order by creat_date desc limit 0,5;";
			$result1 = mysqli_query($sqli,$sql1);
			$rs_cn1 = mysqli_num_rows($result1);
			if($rs_cn1 == 0){
				echo "尚未发布讯息至涂鸦墙";
			}
			else{
				while($row1 = mysqli_fetch_array($result1)){
			?>
				<div class="Show" id="wall_div<? echo $row1["wa_id"]; ?>">
					<div><img src="<? echo $face_photo_url; ?>" class="small_photo"></div>
					<span class="nameDate">
						<div class="font_strong"><? echo $nick; ?></div>
						<div class="font_small"><? echo $row1["creat_date"]; ?></div>
					</span>
					<div class="dropdown show_edit">
					  	<button class="btn" type="button" id="dropdownMenu<? echo $row1["wa_id"]; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					    <span class="caret"></span>
					  	</button>
					  	<ul class="dropdown-menu" aria-labelledby="dropdownMenu<? echo $row1["wa_id"]; ?>">
					  	<? if($row1["report"]!=""){ ?>
					  	<li><a onclick="alert('此贴文以被你检举，请勿再次点击')">检举</a></li>
					  	<? }else{ ?>
					    <li><a data-toggle="modal" data-target="#wall_report_Modal"  data-backdrop="static" data-keyboard=false onclick=wall_report("<? echo $row1["wa_id"]; ?>");>检举</a></li>
					  	<? } ?>
					  	</ul>
					</div>
					<div id="wall_content<? echo $row1["wa_id"]; ?>" class="show_content"><? echo $row1["wa_content"]; ?>
					<? if($row1["wall_photo"]!=null){ ?>
					<div><img src="update/wall_s/<? echo $row1["wall_photo"]; ?>"></div>
					<? } ?></div>
					<div>
						<?
							if($row1["jumi"]==""){
						?>
							<input type="hidden" id="jumi_wall<? echo $row1["wa_id"]; ?>" name="jumi_wall<? echo $row1["wa_id"]; ?>" value="1" >
							<img id="jumi_img<? echo $row1["wa_id"]; ?>" src="include/images/heart1.jpg" onclick="jumi_wall('<? echo $row1["wa_id"]; ?>');">
						<?
							}else{
						?>
							<input type="hidden" id="jumi_wall<? echo $row1["wa_id"]; ?>" name="jumi_wall<? echo $row1["wa_id"]; ?>" value="0" >
							<img id="jumi_img<? echo $row1["wa_id"]; ?>" src="include/images/heart0.jpg" onclick="jumi_wall('<? echo $row1["wa_id"]; ?>');">
						<? }?>
						<font id="wa_jumi_count<? echo $row1["wa_id"]; ?>"><? echo $row1["wa_jumi_count"]; ?></font> 喜欢这个贴文
					</div>
				</div>
			<?
				}
			}
			?>
	</div>
</div>
<form id='member_report_form' action='ajax/report.php' method="post">
	<div class="modal fade" id="member_report_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	      	<h1>检举会员</h1>
	      </div>
	      <div class="modal-body">
	      	<input type="hidden" id="member_report_id" name="member_report_id" value="<? echo $uid; ?>">
	      	<input type="hidden" id="action" name="action" value="member_report" >
	      	<font>检举理由（100字内）︰</font>
	      	<textarea id="member_report_content" name="member_report_content" class="form-control" style="resize:none;"  onkeyup="autogrow(this);" ></textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="send_report('member');">确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<form id='wall_report_form' action='ajax/report.php' method="post">
	<div class="modal fade" id="wall_report_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	      	<h1>检举涂鸦墙</h1>
	      </div>
	      <div class="modal-body">
	      	<input type="hidden" id="wall_report_id" name="wall_report_id" value="">
	      	<input type="hidden" id="action" name="action" value="wall_report" >
	      	<font>检举理由（100字内）︰</font>
	      	<textarea id="wall_report_content" name="wall_report_content" class="form-control" style="resize:none;"  onkeyup="autogrow(this);" ></textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="send_report('wall');">确定</>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<form id='send_gift_form' action='ajax/gift.php' method="post">
	<div class="modal fade" id="send_gift_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	      	<h1>送禮</h1>
	      </div>
	      <div class="modal-body">
	      	<div>
		      	<input type="hidden" id="action" name="action" value="send_gift" >
		      	<?
		      		$sql_gift = "select * from gift where uid = ".$_SESSION["user_id"];
		      		$result_gift = mysqli_query($sqli,$sql_gift);
							$row_gift = mysqli_fetch_array($result_gift);
		      	?>
		      	<table>
							<tr>
								<td><img src="include/images/flower.jpg" onclick="gift_select('flower');"></td>
								<td><div id="flower_count"><? echo $row_gift["flower_o"]; ?></div></td>
								<td><img src="include/images/gift.jpg" onclick="gift_select('gift');"></td>
								<td><div id="gift_count"><? echo $row_gift["gift_o"]; ?></div></td>
								<td><img src="include/images/bouquet.jpg" onclick="gift_select('bouquet');"></td>
								<td><div id="bouquet_count"><? echo $row_gift["bouquet_o"]; ?></div></td>
							</tr>
							<tr>
								<td><img src="include/images/ring.jpg" onclick="gift_select('ring');"></td>
								<td><div id="ring_count"><? echo $row_gift["ring_o"]; ?></div></td>
								<td><img src="include/images/bracelet.jpg" onclick="gift_select('bracelet');"></td>
								<td><div id="bracelet_count"><? echo $row_gift["bracelet_o"]; ?></div></td>
								<td><img src="include/images/gold.jpg" onclick="gift_select('gold');"></td>
								<td><div id="gold_count"><? echo $row_gift["gold_o"]; ?></div></td>
							</tr>
							<tr>
								<td><img src="include/images/crystal.jpg" onclick="gift_select('crystal');"></td>
								<td><div id="crystal_count"><? echo $row_gift["crystal_o"]; ?></div></td>
								<td><img src="include/images/diamond.jpg" onclick="gift_select('diamond');"></td>
								<td><div id="diamond_count"><? echo $row_gift["diamond_o"]; ?></div></td>
								<td><img src="include/images/crown.jpg" onclick="gift_select('crown');"></td>
								<td><div id="crown_count"><? echo $row_gift["crown_o"]; ?></div></td>
							</tr>
						</table>
					</div>
					<div>
						<img id="send_gift_img" src="">
						<input type="hidden" id="send_gift_type" name="send_gift_type" value="">
						<select id="send_gift_count" name="send_gift_count" style="display:none"></select>
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_changeimg();">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="send_gift();">确定</button>
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
	function wall_report(wa_id){
		Dd("wall_report_id").value=wa_id;
	}

	function re_send_gift(mytext){
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=='1'){
			alert(arr[1]);
		}
		else if(arr[0]=="0"){
			history.go(0);
		}
		else{
			alert(mytext);
		}

	}
	function send_gift(){
		if(Dd("send_gift_type").value==""||Dd("send_gift_count").value=="0"){
			return false;
		}
		else{
			var str = "";
			str = "action=send_gift&gift_type="+Dd("send_gift_type").value+"&gift_count="+Dd("send_gift_count").value+"&gift_uid=<? echo $uid; ?>";
			CallServer("ajax/gift.php", str, "POST", true, "mytext",re_send_gift );
		}
	}


	function gift_select(gift_type){
		if(parseInt(Dd(gift_type+"_count").innerHTML)!=0){
			Dd("send_gift_img").src = "include/images/"+gift_type+".jpg";
			Dd("send_gift_type").value = gift_type;
			var str = "";
			for(var i = 0 ; i <= parseInt(Dd(gift_type+"_count").innerHTML); ++i)
				str += "<option value='"+i+"'> "+i+"</option>";
			Dd("send_gift_count").innerHTML = str;
			block("send_gift_count");
		}
		else{
			Dd("send_gift_img").src = "";
			Dd("send_gift_type").value = "";
			Dd("send_gift_count").innerHTML = str;
			none("send_gift_count");
		}
	}


	function re_add_favorite(mytext){
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=='1'){
			alert(arr[1]);
		}
		else if(arr[0]=="0"){
			if(arr[1]=="0"){
				Dd("fa_state").value="0";
				Dd("fa_count").innerHTML = (parseInt(Dd("fa_count").innerHTML)+1);
				Dd("heart_img").src = "include/images/heart0.jpg";
			}
			else if(arr[1]=="1"){
				Dd("fa_state").value="1";
				Dd("fa_count").innerHTML = (parseInt(Dd("fa_count").innerHTML)-1);
				Dd("heart_img").src = "include/images/heart1.jpg";
			}
		}
		else{
			alert(mytext);
		}
	}
	function add_favorite(fa_uid){
		var str = "";
		if(Dd("fa_state").value=="1"){ //增加最愛
			str = "action=add&fa_uid="+fa_uid;
		}
		else if(Dd("fa_state").value=="0"){ //移除最愛
			str = "action=remove&fa_uid="+fa_uid;
		}
		CallServer("ajax/favorite.php", str, "POST", true, "mytext",re_add_favorite );
	}


	function re_jumi_wall(mytext){
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=="1"){
			alert(arr[1]);
		}
		else if(arr[0]=="0"){
			if(Dd("jumi_wall"+arr[1]).value=="1"){ //將要JUMI
				Dd("jumi_wall"+arr[1]).value="0";
				Dd("jumi_img"+arr[1]).src="include/images/heart0.jpg";
				Dd("wa_jumi_count"+arr[1]).innerHTML = (parseInt(Dd("wa_jumi_count"+arr[1]).innerHTML)+1);
			}
			else if(Dd("jumi_wall"+arr[1]).value=="0"){ //取消JUMI
				Dd("jumi_wall"+arr[1]).value="1";
				Dd("jumi_img"+arr[1]).src="include/images/heart1.jpg";
				Dd("wa_jumi_count"+arr[1]).innerHTML = (parseInt(Dd("wa_jumi_count"+arr[1]).innerHTML)-1);
			}
		}
		else{
			alert(mytext);
		}
	}
	function jumi_wall(wa_id){
		var str = "";
		if(Dd("jumi_wall"+wa_id).value=="1"){ //將要JUMI
			str = "action=jumi&wa_id="+wa_id;
		}
		else if(Dd("jumi_wall"+wa_id).value=="0"){ //取消JUMI
			str = "action=bujumi&wa_id="+wa_id;
		}
		CallServer("ajax/wall.php", str, "POST", true, "mytext",re_jumi_wall );
	}
</script>