<?
	include_once("include/dbinclude.php");
	$sql = "select a.* , b.coin from gift a , point b where a.uid='".$_SESSION["user_id"]."' AND a.uid=b.uid;";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result) ;
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
		<h4>储值商品</h4>
		<form id='shop_form' action='ajax/shop.php' method="post">
			<div class="item_grop">
				<!--50点数-->
				<div class="shop_itemContainer">
					<div>
						<h5>50点数</h5>
						<img src="include/images/flower.jpg">
						<font id="flower_font">RMK︰</font>
						<input type="submit" id="" name="" value="购买">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="shop_detail">
		<h4>购买纪录</h4>
		<table>
			<tr>
				<td>时间</td>
				<td>内容</td>
				<td>合计点数</td>
			</tr>
		</table>
	</div>
</div>
<script>
	$( document ).ready(function() {
		var str = "RMK︰";
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