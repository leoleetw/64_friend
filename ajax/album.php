<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	function resize_img($floder , $filename){
		list($width,$height,$type,$attr)=getimagesize("../update/album/".$floder."/".$filename);
		$max_width = 180;
		$max_height = 180;
		if($width > $max_width || $height > $max_height){//做縮圖
			if($width > $max_width){
				$proportion = $max_width/$width;
				$new_width = $max_width;
				$new_height = $height*$proportion;
				$thumb = imagecreatetruecolor($new_width, $new_height);
				switch ($type) {
	        case 1: $source = imagecreatefromgif("../update/album/".$floder."/".$filename); break;
	        case 2: $source = imagecreatefromjpeg("../update/album/".$floder."/".$filename);  break;
	        case 3: 
	        	$source = imagecreatefrompng("../update/album/".$floder."/".$filename);
	        	$c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);//拾取一個完全透明的顏色
						imagealphablending($thumb ,false);//關閉混合模式，以便透明顏色能覆蓋原畫布
						imagefill($thumb , 0 , 0, $c);//填充
						imagesavealpha($thumb ,true); 
	        	break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				switch ($type) {
	        case 1: imagegif($thumb,"../update/album_s/".$floder."/".$filename); break;
	        case 2: imagejpeg($thumb,"../update/album_s/".$floder."/".$filename , 100);  break;
	        case 3: imagepng($thumb,"../update/album_s/".$floder."/".$filename); break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
				list($width,$height,$type,$attr)=getimagesize("../update/album_s/".$floder."/".$filename);
				if($height > $max_height){
					$proportion = $max_height/$height;
					$new_height = $max_height;
					$new_width = $width*$proportion;
					$thumb = imagecreatetruecolor($new_width, $new_height);
					switch ($type) {
		        case 1:	$source = imagecreatefromgif("../update/album_s/".$floder."/".$filename); 	break;
		        case 2: $source = imagecreatefromjpeg("../update/album_s/".$floder."/".$filename);  break;
		        case 3: 
		        	$source = imagecreatefrompng("../update/album_s/".$floder."/".$filename);
		        	$c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);
							imagealphablending($thumb ,false);
							imagefill($thumb , 0 , 0, $c);
							imagesavealpha($thumb ,true); 
		        	break;
		        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		      }
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					switch ($type) {
		        case 1: imagegif($thumb,"../update/album_s/".$floder."/".$filename); break;
		        case 2: imagejpeg($thumb,"../update/album_s/".$floder."/".$filename , 100);  break;
		        case 3: imagepng($thumb,"../update/album_s/".$floder."/".$filename); break;
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
	        case 1:	$source = imagecreatefromgif("../update/album/".$floder."/".$filename);	break;
	        case 2: $source = imagecreatefromjpeg("../update/album/".$floder."/".$filename);  break;
	        case 3: 
	        $source = imagecreatefrompng("../update/album/".$floder."/".$filename); 
	        $c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);
					imagealphablending($thumb ,false);
					imagefill($thumb , 0 , 0, $c);
					imagesavealpha($thumb ,true);
	        break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				switch ($type) {
	        case 1: imagegif($thumb,"../update/album_s/".$floder."/".$filename); break;
	        case 2: imagejpeg($thumb,"../update/album_s/".$floder."/".$filename , 100);  break;
	        case 3: imagepng($thumb,"../update/album_s/".$floder."/".$filename); break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
			}
		}
		else{//直接複製
			copy("../update/album/".$floder."/".$filename, "../update/album_s/".$floder."/".$filename);
		}
		return true;
	}
	
	
	if($action == "add_album"){ //新增相簿
		$sql = "INSERT INTO album( uid, alb_title, alb_cover, pho_count, creat_date)
		values('".$_SESSION["user_id"]."','".$_POST["alb_title"]."','','0','".date("Y-m-d H-i-s")."')";
		mysqli_query($sqli,$sql);
		$album_cover = "";
		$album_id = mysqli_insert_id($sqli);
		$target_dir = "../update/album/".$album_id;
		mkdir($target_dir);
		$target_dir_s = "../update/album_s/".$album_id;
		mkdir($target_dir_s);
		$update_count = count($_FILES["files"]["name"]);
		$error = 0 ;
		for($n = 0 ; $n < $update_count ; ++$n){
			if(!file_exists($target_dir."/".basename($_FILES["files"]["name"][$n]))){
				if($n==$_POST["album_cover"])
					$album_cover = basename($_FILES["files"]["name"][$n]);
				move_uploaded_file($_FILES["files"]["tmp_name"][$n], $target_dir."/".basename($_FILES["files"]["name"][$n]));
				resize_img($album_id, basename($_FILES["files"]["name"][$n]));
				$sql_pho = "INSERT INTO photo( pho_url,  alb_id, pho_jumi_count)
				values ('".basename($_FILES["files"]["name"][$n])."' ,'".$album_id."' , 0)";
				mysqli_query($sqli,$sql_pho);
			}
			else if(file_exists($target_dir."/".basename($_FILES["files"]["name"][$n]))){
				$time=time();
				if($n==$_POST["album_cover"])
					$album_cover = $time.basename($_FILES["files"]["name"][$n]);
				move_uploaded_file($_FILES["files"]["tmp_name"][$n], $target_dir."/".$time.basename($_FILES["files"]["name"][$n]));
				resize_img($album_id , $time.basename($_FILES["files"]["name"][$n]));
				$sql_pho = "INSERT INTO photo( pho_url,  alb_id, pho_jumi_count)
				values ('".$time.basename($_FILES["files"]["name"][$n])."' ,'".$album_id."' , 0)";
				mysqli_query($sqli,$sql_pho);
			}
		}
		$update_count = $update_count-$error;
		$sql = "update album set alb_cover = '".$album_cover."' ,pho_count = '".$update_count."'  where alb_id='".$album_id."';";
		mysqli_query($sqli,$sql);
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="新增相簿成功!";
		header("Location: ../user_photo.php?alb_id=".$album_id);
	}
	else if($action == "add_pho"){
		$error = 0;
		$target_dir = "../update/album/".$_POST["alb_id"];
		$update_count = count($_FILES["files"]["name"]);
		for($n = 0 ; $n < $update_count ; ++$n){
			if(!file_exists($target_dir."/".basename($_FILES["files"]["name"][$n]))){
				$album_cover = basename($_FILES["files"]["name"][$n]);
				move_uploaded_file($_FILES["files"]["tmp_name"][$n], $target_dir."/".basename($_FILES["files"]["name"][$n]));
				resize_img($_POST["alb_id"],basename($_FILES["files"]["name"][$n]));
				$sql_pho = "INSERT INTO photo( pho_url,  alb_id, pho_jumi_count)
				values ('".basename($_FILES["files"]["name"][$n])."' ,'".$_POST["alb_id"]."' , 0)";
				mysqli_query($sqli,$sql_pho);
			}
			else if(file_exists($target_dir."/".basename($_FILES["files"]["name"][$n]))){
				$time=time();
				$album_cover = $time.basename($_FILES["files"]["name"][$n]);
				move_uploaded_file($_FILES["files"]["tmp_name"][$n], $target_dir."/".$time.basename($_FILES["files"]["name"][$n]));
				resize_img($_POST["alb_id"],$time.basename($_FILES["files"]["name"][$n]));
				$sql_pho = "INSERT INTO photo( pho_url,  alb_id, pho_jumi_count)
				values ('".$time.basename($_FILES["files"]["name"][$n])."' ,'".$_POST["alb_id"]."' , 0)";
				mysqli_query($sqli,$sql_pho);
			}
		}
		$update_count = $update_count - $error;
		$sql = "select pho_count from album where alb_id =".$_POST["alb_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$sql = "update album set pho_count = '".(intval($row["pho_count"])+$update_count)."' where alb_id='".$_POST["alb_id"]."';";
		mysqli_query($sqli,$sql);
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="新增相片成功!";
		header("Location: ../user_photo.php?alb_id=".$_POST["alb_id"]);
	}
	else if($action == "remove_pho"){
		$sql = "select * from photo where pho_id='".$_POST["pho_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$temp = explode(".",$row["pho_url"]);
		$time=time();
		$name = $time.".".$temp[(count($temp)-1)];
		unlink("../update/album_s/".$row["alb_id"]."/".$row["pho_url"]);
		rename("../update/album/".$row["alb_id"]."/".$row["pho_url"], "../update/remove/".$name);
		
		$sql1 = "select pho_count from album where alb_id=".$row["alb_id"];
		$result1 = mysqli_query($sqli,$sql1);
		$row1 = mysqli_fetch_array($result1) ;
		$sql1 = "update album set pho_count=".(intval($row1["pho_count"])-1)." where alb_id = ".$row["alb_id"];
		mysqli_query($sqli,$sql1);
		$sql1 = "delete from photo where pho_id=".$_POST["pho_id"];
		mysqli_query($sqli,$sql1);
		echo "0|".$_POST["pho_id"];
	}
	else if($action == "remove_album"){
		rmdir("../update/album_s/".$_POST["alb_id"]);
		rename("../update/album/".$_POST["alb_id"], "../update/remove/".$_POST["alb_id"]);
		$sql1 = "delete from album where alb_id=".$_POST["alb_id"];
		mysqli_query($sqli,$sql1);
		$sql1 = "delete from photo where alb_id=".$_POST["alb_id"];
		mysqli_query($sqli,$sql1);
		echo "0|".$_POST["alb_id"];
	}
	else if($action == "set_cover"){ //設定相簿封面
		$sql = "select alb_id, pho_url from photo where pho_id=".$_POST["pho_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$sql = "update album set alb_cover = '".$row["pho_url"]."' where alb_id = ".$_POST["alb_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1";
		else
			echo "0";
	}
	else if($action == "change_title"){ //更改相簿名稱
		$sql = "update album set alb_title = '".$_POST["alb_title"]."' where alb_id = ".$_POST["alb_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1";
		else
			echo "0";
	}
	else if($action == "alb_photo"){ //顯示該相簿所有照片
		$list = Array();
		$sql = "select alb_id , pho_url from photo where alb_id='".$_POST["alb_id"]."'";
		$result = mysqli_query($sqli,$sql);
		for($i=0 ; $i < $row = mysqli_fetch_array($result); ++$i){
			$list[$i] = $row;
		}
		echo json_encode($list);
	}
	else if($action == "face_photo"){ //大頭照
		if($_POST["photo_from"]=="file_update"){
			$ini_filename = $_FILES["imgInp"]["tmp_name"];
		}
		else if($_POST["photo_from"]=="album"){
			$ini_filename = "../update/album/".$_POST["alb_id"]."/".$_POST["pho_url"];
			
		}
		$target_jpg = '../update/face_photo/'.$_SESSION["user_id"].'.jpg';
		list($width,$height,$type,$attr)=getimagesize($ini_filename);
		$p_width = $width/intval($_POST["resize_width"]);
		$p_height = $height/intval($_POST["resize_height"]);
		$des_im = imagecreatetruecolor((intval($_POST["x2"])-intval($_POST["x1"]))*$p_width, (intval($_POST["y2"])-intval($_POST["y1"]))*$p_height);
		$src_im = imagecreatefromjpeg($ini_filename);
		imagecopy($des_im,$src_im, 0, 0 ,intval($_POST["x1"])*$p_width, intval($_POST["y1"])*$p_height,  (intval($_POST["x2"])-intval($_POST["x1"]))*$p_width, (intval($_POST["y2"])-intval($_POST["y1"]))*$p_height);
		imagejpeg($des_im,$target_jpg , 100);
		imagedestroy($des_im);
		imagedestroy($src_im);
		
		$thumb = imagecreatetruecolor(160, 160);
		$source = imagecreatefromjpeg($target_jpg);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, 160, 160, (intval($_POST["x2"])-intval($_POST["x1"]))*$p_width, (intval($_POST["y2"])-intval($_POST["y1"]))*$p_height);
		imagejpeg($thumb,$target_jpg , 100);
		$sql = "update member set photo_url = '".$_SESSION["user_id"].".jpg' where uid=".$_SESSION["user_id"];
		mysqli_query($sqli,$sql);
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="大头照更新成功!";
		$_SESSION["user_photo"]="update/face_photo/".$_SESSION["user_id"].".jpg";
		header("Location: ../user_data.php");
	}
	else if($action == "jumi"){
		$sql = "INSERT INTO jumi(uid, jumi_type, jumi_target) values ('".$_SESSION["user_id"]."' , 'photo' ,'".$_POST["pho_id"]."')";
		if(!mysqli_query($sqli,$sql)){
			echo "1|JUMI失败";
		}
		else{
			$sql = "update photo set pho_jumi_count = pho_jumi_count+1 where pho_id=".$_POST["pho_id"];
			if(!mysqli_query($sqli,$sql)){
				echo "1|JUMI失败";
			}
			else{
				echo "0|".$_POST["pho_id"];
			}
		}
	}
	else if($action == "bujumi"){
		$sql = "update photo set pho_jumi_count = pho_jumi_count-1 where pho_id=".$_POST["pho_id"];
		
		if(!mysqli_query($sqli,$sql)){
			echo "1|BUJUMI失败";
		}
		else{
			$sql = "delete from jumi where uid='".$_SESSION["user_id"]."' AND jumi_type = 'photo' AND jumi_target ='".$_POST["pho_id"]."';";
			if(!mysqli_query($sqli,$sql)){
				echo "1|BUJUMI失败";
			}
			else{
				echo "0|".$_POST["pho_id"];
			}
		}
	}
?>