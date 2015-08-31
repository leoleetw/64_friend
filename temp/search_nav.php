<div class="searchTOP_bg">
<section>
<form id="search_form" action="search.php" method="GET">
	<div style="width:800px;">
		<table width=100%>
			<tr>
				<td width="10%" style="text-align:right">交友条件：</td>
				<td width="50%">
					<div class="form-group">
						<select id="search_sex" name="search_sex" class="drop_down" style="width:30%;display:inline;">
							<option value="1" <? if($_GET["search_sex"]=="1"){echo "selected"; } ?>> 女性</option>
							<option value="0" <? if($_GET["search_sex"]=="0"){echo "selected"; } ?>> 男性</option>
							<option value="" <? if($_GET["search_sex"]==""){echo "selected"; } ?>> 皆可</option>
						</select>
						<select id="search_age0" name="search_age0" class="drop_down" style="width:30%;display:inline;">
							<?
								for($i = 18 ; $i <= 60 ; ++$i){
									echo "<option value='".$i."' ";
									if($_GET["search_age0"]==$i)
										echo "selected";
									echo "> ".$i." </option>";
								}
							?>
						</select>～
						<select id="search_age1" name="search_age1" class="drop_down" style="width:30%;display:inline;">
							<?
								for($i = 18 ; $i <= 60 ; ++$i){
									echo "<option value='".$i."' ";
									if($_GET["search_age1"]==$i)
										echo "selected";
									if($_GET["search_age1"]=="" && $i==60)
										echo "selected";
									echo " > ".$i." </option>";
								}
							?>
						</select>
					</div>
				</td>
				<td width="10%" style="text-align:right">血型：</td>
				<td width="30%">
					<select id="search_blood_type" name="search_blood_type" class="drop_down">
						<option value="" <? if($_GET["search_blood_type"]==""){echo "selected"; } ?>> 不拘</option>
						<option value="A" <? if($_GET["search_blood_type"]=="A"){echo "selected"; } ?>> A</option>
						<option value="B" <? if($_GET["search_blood_type"]=="B"){echo "selected"; } ?>> B</option>
						<option value="O" <? if($_GET["search_blood_type"]=="O"){echo "selected"; } ?>> O</option>
						<option value="AB" <? if($_GET["search_blood_type"]=="AB"){echo "selected"; } ?>> AB</option>
					</select>
				</td>
			</tr>
			<tr>
    		<td style="text-align:right">身高︰</td>
    		<td>
    			<div class="form-group">
	    			<select id="search_height0" name="search_height0" class="drop_down" style="width:47%;display:inline;">
							<option value=""> 以下</option>
							<?
								for($i=120 ; $i <= 220;++$i){
									echo "<option value='".$i."' ";
									if($_GET["search_height0"]==$i)
										echo "selected";
									echo "> ".$i."cm </option>";
								}
							?>
						</select>～
						<select id="search_height1" name="search_height1" class="drop_down" style="width:47%;display:inline;">
							<option value=""> 以上</option>
							<?
								for($i=120 ; $i <= 220;++$i){
									echo "<option value='".$i."' ";
									if($_GET["search_height1"]==$i)
										echo "selected";
									echo " > ".$i."cm </option>";
								}
							?>
						</select>
					</div>
    		</td>
    		<td style="text-align:right">学历：</td>
				<td>
					<select id="search_edu_bg" name="search_edu_bg" class="drop_down">
						<option value=""> 不拘</option>
						<?
							$sql = "select * from code where type='edu_bg';";
							$result = mysqli_query($sqli,$sql);
							while($row_option = mysqli_fetch_array($result)){
								echo "<option value='".$row_option["id"]."' ";
								if($_GET["search_edu_bg"]==$row_option["id"])
									echo "selected";
								echo "> ".$row_option["name"]."</option>";
							}
						?>
					</select>
				</td>
	    </tr>
	    <tr>
    		<td style="text-align:right">体重︰</td>
    		<td>
    			<div class="form-group">
	    			<select id="search_weight0" name="search_weight0" class="drop_down" style="width:47%;display:inline;">
							<option value="">以下</option>
							<?
								for($i=30 ; $i <= 150;++$i){
									echo "<option value='".$i."' ";
									if($_GET["search_weight0"]==$i)
										echo "selected";
									echo " > ".$i."kg </option>";
								}
							?>
						</select>～
						<select id="search_weight1" name="search_weight1" class="drop_down" style="width:47%;display:inline;">
							<option value="">以上</option>
							<?
								for($i=30 ; $i <= 150;++$i){
									echo "<option value='".$i."' ";
									if($_GET["search_weight1"]==$i)
										echo "selected";
									echo " > ".$i."kg </option>";
								}
							?>
						</select>
					</div>
    		</td>
    		<td style="text-align:right">职业：</td>
				<td>
					<select id="search_job" name="search_job" class="drop_down">
						<option value=""> 不拘</option>
						<?
							$sql = "select * from code where type='job';";
							$result = mysqli_query($sqli,$sql);
							while($row_option = mysqli_fetch_array($result)){
								echo "<option value='".$row_option["id"]."' ";
								if($_GET["search_job"]==$row_option["id"])
									echo "selected";
								echo "> ".$row_option["name"]."</option>";
							}
						?>
					</select>
				</td>
    	</tr>
	    <tr>
    		<td style="text-align:right">所在地︰</td>
    		<td>
    			<div class="form-group">
	    			<select id="search_city_cate" name="search_city_cate" class="drop_down" style="width:45%;display:inline;">
							<option value> 不拘</option>
							<?
								$search_city_cate = "";
								$sql = "select * from code where type='city';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($_GET["search_city_cate"]==$row_option["id"]){
										echo "selected";
										$search_city_cate = $row_option["value"];
									}
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
						<select id="search_city_code" name="search_city_code" class="drop_down" style="width:45%;display:inline;">
							<option value=""> 不拘</option>
							<?
								if($_GET["search_city_cate"]!=""){
									$sql = "select * from code where type='city".$search_city_cate."';";
									$result = mysqli_query($sqli,$sql);
									while($row_option = mysqli_fetch_array($result)){
										echo "<option value='".$row_option["id"]."' ";
										if($_GET["search_city_code"]==$row_option["id"]){
											echo "selected";
											$search_city_cate = $row_option["value"];
										}
										echo " > ".$row_option["name"]."</option>";
									}
								}
							?>
						</select>
					</div>
    		</td>
    		<td style="text-align:right">信仰：</td>
    		<td>
    			<div class="form-group">
	    			<select id="search_faith" name="search_faith" class="drop_down">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='faith';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($_GET["search_faith"]==$row_option["id"])
										echo "selected";
									echo "> ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</div>
    		</td>
    	</tr>
	  </table>
	<input type="button" id="search_btn" name="search_btn" value="開始">
</form>
</section>
</div>
<script>
	$("#advance_btn").click(function(e){
		/*
		if(Dd("advance_div").style.display=="none")
			block("advance_div");
		else
			none("advance_div");
		*/
		if(Dd("advance_div").style.display=="none")
			$("#advance_div").slideDown(500);

		else
			$("#advance_div").slideUp(500);

	}
	);
	$("#search_btn").click(function(e){
		/*
		if((Dd("search_weight1").value!="" && Dd("search_weight0").value!="")&& parseInt(Dd("search_weight0").value)>parseInt(Dd("search_weight1").value))
			alert("範圍前面不得大於後面");
		else
		*/
			Dd("search_form").submit();
	});
	function re_search_city_code(mytext){
		//alert(mytext);
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		str = "<option value='' > 不拘 </option>";
		for(var i = 0 ; i < arr.length ; ++i){
			str += "<option value='"+arr[i].value+"' > "+arr[i].name+"</option>";
		}
		Dd("search_city_code").innerHTML = str;
	}
  $("#search_city_cate").change(function(e) {
  		var str = "";
  		str = "action=city_code&city_cate="+Dd("search_city_cate").value;
      CallServer("ajax/code.php", str, "POST", true, "mytext",re_search_city_code );
  });
</script>