<?
	include_once("include/dbinclude.php");
	$sql = "select a.* , b.coin from gift a , point b where a.uid='".$_SESSION["user_id"]."' AND a.uid=b.uid;";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result) ;
	function get_dis($gift_type){
		global $sqli;
		$sql = "select * from gift_price where gift_name='".$gift_type."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		if($row["gift_price_o"]==$row["gift_price_d"]){ //非特價品
			return false;
		}
		else{ //有設定特價品 判定時間
			$start = $row["discount_begin_date"]." 00:00:00";
			$end = $row["discount_end_date"]." 23:59:59";
			strtotime("now");
			if((strtotime($start) <= strtotime("now") )&& (strtotime($end) >= strtotime("now") )){ //時間中
				return true;
			}
			else{ //非時間
				return false;
			}
		}
	}
	function get_price($gift_type){
		global $sqli;
		$sql = "select * from gift_price where gift_name='".$gift_type."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		if($row["gift_price_o"]==$row["gift_price_d"]){ //非特價品
			echo $row["gift_price_o"];
		}
		else{ //有設定特價品 判定時間
			$start = $row["discount_begin_date"]." 00:00:00";
			$end = $row["discount_end_date"]." 23:59:59";
			strtotime("now");
			if((strtotime($start) <= strtotime("now") )&& (strtotime($end) >= strtotime("now") )){ //時間中
				echo $row["gift_price_d"];
			}
			else{ //非時間
				echo $row["gift_price_o"];
			}
		}
	}
?>
<div class="edit_nav">
	<a href="user_edit.php">修改资料</a>
	<a href="favorite.php">我的收藏</a>
	<a href="user_album.php">我的相簿</a>
	<a href="#">积分兑换</a>
	<a href="shop.php">购买礼物/储值</a>
</div>
<section class="shop_leftNav">
	<div><? echo $_SESSION["user_nick"]; ?></div>
	<div>我的点数︰<font id="existing_coin" class="font_stronger"><? echo $row["coin"]; ?></font></div>
	<a href="shop.php">ICU商城</a><br/>
		<input type="radio" name="shopItem" value=""/ onclick="$('.item_grop').isotope({ filter: '*' })">全部商品<br/>
		<input type="radio" name="shopItem" value=""/ onclick="$('.item_grop').isotope({ filter: '.gift' })">精选礼物<br/>
		<input type="radio" name="shopItem" value=""/ onclick="$('.item_grop').isotope({ filter: '.discount' })">限时优惠<br/>
		<input type="radio" name="shopItem" value=""/>我要曝光<br/>
	<a href="saving.php">储值</a>
</section>
<div class="shop_rightBox">
	<div class="shop_wrapper">
		<h4>ICU商城</h4>
		<form id='shop_form' action='ajax/shop.php' method="post">
			<div class="item_grop">
				<!--花-->
				<div class="shop_itemContainer <? if(get_dis('flower')){echo "discount";}?> gift">
					<div>
						<h5>鮮花</h5>
						<img src="include/images/flower.jpg">
						<input type="hidden" id="flower_price" name="flower_price" value="<? get_price('flower');?>">
						<font id="flower_font">点数︰</font>
						<select id="flower_count" name="flower_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--礼物-->
				<div class="shop_itemContainer <? if(get_dis('flower')){echo "discount";}?> gift">
					<div>
						<h5>礼盒</h5>
						<img src="include/images/gift.jpg">
						<input type="hidden" id="gift_price" name="gift_price" value="<? get_price('gift');?>">
						<font id="gift_font">点数︰</font>
						<select id="gift_count" name="gift_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--花束-->
				<div class="shop_itemContainer <? if(get_dis('bouquet')){echo "discount";}?> gift">
					<div>
						<h5>花束</h5>
						<img src="include/images/bouquet.jpg">
						<input type="hidden" id="bouquet_price" name="bouquet_price" value="<? get_price('bouquet');?>">
						<font id="bouquet_font">点数︰</font>
						<select id="bouquet_count" name="bouquet_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--戒指-->
				<div class="shop_itemContainer <? if(get_dis('ring')){echo "discount";}?> gift">
					<div>
						<h5>戒指</h5>
						<img src="include/images/ring.jpg">
						<input type="hidden" id="ring_price" name="ring_price" value="<? get_price('ring');?>">
						<font id="ring_font">点数︰</font>
						<select id="ring_count" name="ring_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--手环-->
				<div class="shop_itemContainer <? if(get_dis('bracelet')){echo "discount";}?> ">
					<div>
						<h5>手环</h5>
						<img src="include/images/bracelet.jpg">
						<input type="hidden" id="bracelet_price" name="bracelet_price" value="<? get_price('bracelet');?>">
						<font id="bracelet_font">点数︰</font>
						<select id="bracelet_count" name="bracelet_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--黄金-->
				<div class="shop_itemContainer <? if(get_dis('gold')){echo "discount";}?> ">
					<div>
						<h5>黄金</h5>
						<img src="include/images/gold.jpg">
						<input type="hidden" id="gold_price" name="gold_price" value="<? get_price('gold');?>">
						<font id="gold_font">点数︰</font>
						<select id="gold_count" name="gold_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--水晶-->
				<div class="shop_itemContainer <? if(get_dis('crystal')){echo "discount";}?> ">
					<div>
						<h5>水晶</h5>
						<img src="include/images/crystal.jpg">
						<input type="hidden" id="crystal_price" name="crystal_price" value="<? get_price('crystal');?>">
						<font id="crystal_font">点数︰</font>
						<select id="crystal_count" name="crystal_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--钻石-->
				<div class="shop_itemContainer <? if(get_dis('diamond')){echo "discount";}?> ">
					<div>
						<h5>钻石</h5>
						<img src="include/images/diamond.jpg">
						<input type="hidden" id="diamond_price" name="diamond_price" value="<? get_price('diamond');?>">
						<font id="diamond_font">点数︰</font>
						<select id="diamond_count" name="diamond_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<!--皇冠-->
				<div class="shop_itemContainer <? if(get_dis('crown')){echo "discount";}?> ">
					<div>
						<h5>皇冠</h5>
						<img src="include/images/crown.jpg">
						<input type="hidden" id="crown_price" name="crown_price" value="<? get_price('crown');?>">
						<font id="crown_font">点数︰</font>
						<select id="crown_count" name="crown_count" onchange="change_coin();">
							<?
								for($i=0; $i <= 50;++$i){
									echo "<option value='".$i."'> ".$i."</option>";
								}
							?>
						</select>
					</div>
				</div>

			</div>
			<div>
				合计︰<font id="total_coin">0</font>交友币
			</div>
			<div>
				<input type="hidden" id="action" name="action" value="shop_gift">
				<input type="button" id="shop_btn" name="shop_btn" value="兑换" onclick="go_shop();">
			</div>
		</form>
	</div>
	<div class="shop_detail">
		<h4>购买纪录</h4>
		<table>
			<tr>
				<th>时间</th>
				<th>内容</th>
				<th>合计点数</th>
			</tr>
			<?
				$sql = "select * from shop_record where uid = ".$_SESSION["user_id"];
				$result = mysqli_query($sqli,$sql);
				while($row = mysqli_fetch_array($result)){
					$str = "";
					$arr = Array();
					$arr = explode("|",$row["sr_item"]);
					for($i = 0 ; $i < count($arr) ; $i+=2){
						if($arr[$i]=='flower')
							$str .= "花 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='gift')
							$str .= "礼物 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='bouquet')
							$str .= "花束 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='ring')
							$str .= "戒指 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='bracelet')
							$str .= "手环 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='gold')
							$str .= "黄金 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='crystal')
							$str .= "水晶 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='diamond')
							$str .= "钻石 ".$arr[$i+1]."个 ";
						else if($arr[$i]=='crown')
							$str .= "皇冠 ".$arr[$i+1]."个 ";
					}
			?>
			<tr>
				<td><? echo $row["sr_date"]; ?></td>
				<td><? echo $str; ?></td>
				<td><? echo $row["sr_coin"]; ?></td>
			</tr>
			<?
				}
			?>
		</table>
	</div>
</div>
<script>
	$( document ).ready(function() {
		var str = "点数︰";
		Dd("flower_font").innerHTML = str+Dd("flower_price").value;
		Dd("gift_font").innerHTML = str+Dd("gift_price").value;
		Dd("bouquet_font").innerHTML = str+Dd("bouquet_price").value;
		Dd("ring_font").innerHTML = str+Dd("ring_price").value;
		Dd("bracelet_font").innerHTML = str+Dd("bracelet_price").value;
		Dd("gold_font").innerHTML = str+Dd("gold_price").value;
		Dd("crystal_font").innerHTML = str+Dd("crystal_price").value;
	  Dd("diamond_font").innerHTML = str+Dd("diamond_price").value;
	  Dd("crown_font").innerHTML = str+Dd("crown_price").value;
	});
	function go_shop(){
		if(parseInt(Dd("total_coin").innerHTML) == 0){
			return false;
		}
		else if(parseInt(Dd("existing_coin").innerHTML) < parseInt(Dd("total_coin").innerHTML)){
			alert("目前金额不足，请前往储值");
		}
		else{
			Dd("shop_form").submit();
		}
	}
	function change_coin(){
		var coin = 0;
		coin += parseInt(Dd("flower_count").value)*Dd("flower_price").value;
		coin += parseInt(Dd("gift_count").value)*Dd("gift_price").value;
		coin += parseInt(Dd("bouquet_count").value)*Dd("bouquet_price").value;
		coin += parseInt(Dd("ring_count").value)*Dd("ring_price").value;
		coin += parseInt(Dd("bracelet_count").value)*Dd("bracelet_price").value;
		coin += parseInt(Dd("gold_count").value)*Dd("gold_price").value;
		coin += parseInt(Dd("crystal_count").value)*Dd("crystal_price").value;
		coin += parseInt(Dd("diamond_count").value)*Dd("diamond_price").value;
		coin += parseInt(Dd("crown_count").value)*Dd("crown_price").value;
		Dd("total_coin").innerHTML = coin;
	}
</script>