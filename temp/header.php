<div class="header">
	<section>
	<a href="index.php" border="0" title="交友往首页" alt="交友往首页"> <div id="header_logo"></div> </a>
	<div class="index_search">
	<form id="search_form" action="search.php" method="GET">
		<div style="display: inline">
			交友搜寻：
				<select id="search_sex" name="search_sex" class="drop_down">
					<option value="1" > 女性</option>
					<option value="0" > 男性</option>
					<option value="" > 皆可</option>
				</select>

			&nbsp;&nbsp;年龄：
				<select id="search_age0" name="search_age0" class="drop_down">
					<?
						for($i = 18 ; $i <= 60 ; ++$i){
							echo "<option value='".$i."' > ".$i." </option>";
						}
					?>
				</select>&nbsp;～
				<select id="search_age1" name="search_age1" class="drop_down">
					<?
						for($i = 18 ; $i <= 60 ; ++$i){
							echo "<option value='".$i."'  ";
							if($i==60)
								echo "selected";
							echo "> ".$i." </option>";
						}
					?>
				</select>
		</div>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" id="search_btn" name="search_btn" value="開始">
	</form>
	</div>
	</section>
</div>
