<?
	include_once("include/dbinclude.php");
?>
<div id="memberG">
	<section>
		<?
			$sql = "select a.uid , a.photo_url from member a , point b , user c where a.sex=1 and a.uid = b.uid and a.uid=c.uid order by b.week_point DESC , login_date DESC limit 0,16 ";
			$result = mysqli_query($sqli,$sql);
		?>
      <div class="photo_wrapper">
      	<?
      		$i = 0 ;
      		while($row = mysqli_fetch_array($result)){
      			$i++;
						if($row["uid"]==$_SESSION["user_id"]){
      	?>
          		<div class="photo01" onclick="location.href='user_data.php'"><img src="<? echo $_SESSION["user_photo"]; ?>"></div>
        <? 
        
        		}else{ 
        			
      			$face_photo_url = "";
						if($row["photo_url"]!="")
							$face_photo_url="update/face_photo/".$row["photo_url"];
						else
							$face_photo_url="include/images/girl.jpg";
        ?>
        			<div class="photo01" onclick="location.href='member_data.php?uid=<? echo $row["uid"];?>'"><img src="<? echo $face_photo_url; ?>"></div>
        <? 
        
        		}
        	}
        ?>
        <? for( $n = $i ; $n < 18 ; ++$n){ ?>
        	<div class="photo01"><img src="include/images/girl.jpg"></div>
        <? } ?>
      </div>
      <div class="hot">
     	  <div class="hotPhoto"></div>
      </div>
    </section>
</div>
<div id="memberB">
	<section>
		<?
			$sql = "select a.uid , a.photo_url from member a , point b , user c where a.sex=0 and a.uid = b.uid and a.uid=c.uid order by b.week_point DESC , login_date DESC limit 0,16 ";
			$result = mysqli_query($sqli,$sql);
		?>
        <div class="photo_wrapper">
		        <?
		      		$i = 0 ;
		      		while($row = mysqli_fetch_array($result)){
		      			$i++;
								if($row["uid"]==$_SESSION["user_id"]){
		      	?>
		          		<div class="photo01" onclick="location.href='user_data.php'"><img src="<? echo $_SESSION["user_photo"]; ?>"></div>
		        <? 
		        
		        		}else{
		      			$face_photo_url = "";
								if($row["photo_url"]!="")
									$face_photo_url="update/face_photo/".$row["photo_url"];
								else
									$face_photo_url="include/images/boy.jpg";
		        ?>
		        			<div class="photo01" onclick="location.href='member_data.php?uid=<? echo $row["uid"];?>'"><img src="<? echo $face_photo_url; ?>"></div>
		        <? 
		        
		        		}
		        	}
		        ?>

           <? for( $n = $i ; $n < 18 ; ++$n){ ?>
          	<div class="photo01""><img src="include/images/girl.jpg"></div>
          	<? } ?>
        </div>
        <div class="hot">
        	<div class="hotPhoto"></div>
        </div>
    </section>
</div>
