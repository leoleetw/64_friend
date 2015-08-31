<?
	include_once("../include/dbinclude.php");
	
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "wall_add"){ //新增塗鴉牆
		$sql = "INSERT INTO wall( uid, wa_content, creat_date) VALUES
		('".$_SESSION["user_id"]."' , '".mysqli_real_escape_string($sqli, $_POST["wall_content"])."' , '".date("Y-m-d H:i:s")."')";
		mysqli_query($sqli,$sql);
		$wa_id = mysqli_insert_id($sqli);
		if($_FILES["wall_photo"]["tmp_name"]!=""){
			$subname = Array();
			$subname = explode(".",$_FILES["wall_photo"]["name"]);
			$wa_photo_url = $wa_id.".".$subname[count($subname)-1];
			move_uploaded_file($_FILES["wall_photo"]["tmp_name"], "../update/wall/".$wa_photo_url);
			list($width,$height,$type,$attr)=getimagesize("../update/wall/".$wa_photo_url);
			$max_width = 368;
			$max_height = 380;
			if($width > $max_width || $height > $max_height){//做縮圖
				if($width > $max_width){
					$proportion = $max_width/$width;
					$new_width = $max_width;
					$new_height = $height*$proportion;
					$thumb = imagecreatetruecolor($new_width, $new_height);
					switch ($type) {
		        case 1: $source = imagecreatefromgif("../update/wall/".$wa_photo_url); break;
		        case 2: $source = imagecreatefromjpeg("../update/wall/".$wa_photo_url);  break;
		        case 3: 
		        	$source = imagecreatefrompng("../update/wall/".$wa_photo_url);
		        	$c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);//拾取一個完全透明的顏色
							imagealphablending($thumb ,false);//關閉混合模式，以便透明顏色能覆蓋原畫布
							imagefill($thumb , 0 , 0, $c);//填充
							imagesavealpha($thumb ,true); 
		        	break;
		        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		      }
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					switch ($type) {
		        case 1: imagegif($thumb,"../update/wall_s/".$wa_photo_url); break;
		        case 2: imagejpeg($thumb,"../update/wall_s/".$wa_photo_url , 100);  break;
		        case 3: imagepng($thumb,"../update/wall_s/".$wa_photo_url); break;
		        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		      }
					list($width,$height,$type,$attr)=getimagesize("../update/wall_s/".$wa_photo_url);
					if($height > $max_height){
						$proportion = $max_height/$height;
						$new_height = $max_height;
						$new_width = $width*$proportion;
						$thumb = imagecreatetruecolor($new_width, $new_height);
						switch ($type) {
			        case 1:	$source = imagecreatefromgif("../update/wall_s/".$wa_photo_url); 	break;
			        case 2: $source = imagecreatefromjpeg("../update/wall_s/".$wa_photo_url);  break;
			        case 3: 
			        	$source = imagecreatefrompng("../update/wall_s/".$wa_photo_url);
			        	$c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);
								imagealphablending($thumb ,false);
								imagefill($thumb , 0 , 0, $c);
								imagesavealpha($thumb ,true); 
			        	break;
			        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
			      }
						imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						switch ($type) {
			        case 1: imagegif($thumb,"../update/wall_s/".$wa_photo_url); break;
			        case 2: imagejpeg($thumb,"../update/wall_s/".$wa_photo_url , 100);  break;
			        case 3: imagepng($thumb,"../update/wall_s/".$wa_photo_url); break;
			        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
			      }
					}
				}
				else if($height > $max_height){
					$proportion = $max_height/$height;
					$new_height = $max_height;
					$new_width = $width*$proportion;
					$thumb = imagecreatetruecolor($new_width, $new_height);
					switch ($type) {
		        case 1:	$source = imagecreatefromgif("../update/wall/".$wa_photo_url);	break;
		        case 2: $source = imagecreatefromjpeg("../update/wall/".$wa_photo_url);  break;
		        case 3: 
		        $source = imagecreatefrompng("../update/wall/".$wa_photo_url); 
		        $c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);
						imagealphablending($thumb ,false);
						imagefill($thumb , 0 , 0, $c);
						imagesavealpha($thumb ,true);
		        break;
		        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		      }
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					switch ($type) {
		        case 1: imagegif($thumb,"../update/wall_s/".$wa_photo_url); break;
		        case 2: imagejpeg($thumb,"../update/wall_s/".$wa_photo_url , 100);  break;
		        case 3: imagepng($thumb,"../update/wall_s/".$wa_photo_url); break;
		        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		      }
				}
			}
			else{//直接複製
				copy("../update/wall/".$wa_photo_url, "../update/wall_s/".$wa_photo_url);
			}
			$sql1 = "update wall set wall_photo ='".$wa_photo_url."' where wa_id='".$wa_id."';";
			mysqli_query($sqli,$sql1);
		}
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="涂鸦墙发布成功!";
		header("Location: ../user_data.php");
	}
	else if($action == "wall_remove"){ // 刪除塗鴉牆
		$sql = "select wall_photo from wall where wa_id=".$_POST["wa_id"];
		//echo $sql;
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$wall_photo = $row["wall_photo"];
		$sql = "delete from wall where wa_id =".$_POST["wa_id"];
		if(!mysqli_query($sqli,$sql)){
			echo "1|删除涂鸦墙失败，请联系官网处理";
		}
		else{
			if($wall_photo != null){
				rename("../update/wall/".$wall_photo, "../update/remove/wall_".$wall_photo);
				unlink("../update/wall_s/".$wall_photo);
			}
			echo "0|".$_POST["wa_id"];
		}
	}
	else if($action == "wall_edit"){ //編輯塗鴉牆
		$sql = "update wall set wa_content='".mysqli_real_escape_string($sqli, $_POST["wall_edit_content"])."' ,edit_date = '".date("Y-m-d H:i:s")."' where wa_id ='".$_POST["wall_edit_id"]."'";
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="涂鸦墙变更失败!";
			header("Location: ../user_data.php");
		}
		else{
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="涂鸦墙变更成功!";
			header("Location: ../user_data.php");
		}
	}
	else if($action == "jumi"){ //喜歡塗鴉牆
		$sql = "INSERT INTO jumi(uid, jumi_type, jumi_target) values ('".$_SESSION["user_id"]."' , 'wall' ,'".$_POST["wa_id"]."')";
		if(!mysqli_query($sqli,$sql)){
			echo "1|JUMI失败";
		}
		else{
			$sql = "update wall set wa_jumi_count = wa_jumi_count+1 where wa_id=".$_POST["wa_id"];
			if(!mysqli_query($sqli,$sql)){
				echo "1|JUMI失败";
			}
			else{
				echo "0|".$_POST["wa_id"];
			}
		}
	}
	else if($action == "bujumi"){ //取消喜歡塗鴉牆
		$sql = "update wall set wa_jumi_count = wa_jumi_count-1 where wa_id=".$_POST["wa_id"];
		
		if(!mysqli_query($sqli,$sql)){
			echo "1|BUJUMI失败";
		}
		else{
			$sql = "delete from jumi where uid='".$_SESSION["user_id"]."' AND jumi_type = 'wall' AND jumi_target ='".$_POST["wa_id"]."';";
			if(!mysqli_query($sqli,$sql)){
				echo "1|BUJUMI失败";
			}
			else{
				echo "0|".$_POST["wa_id"];
			}
		}
	}
?>