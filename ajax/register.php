<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	
	if($action == "register"){ //帐号注册
		$acc = $_POST["acc"];
		//再次验证帐号重复（修复重整）
		$sql = "select * from user where acc='".mysqli_real_escape_string($sqli, $acc)."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn != 0 ){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="已有重复帐号，请更换帐号！！";
			header("Location: ../index.php");
		}
		else{
			//驗證推薦人
			$recommend = intval($_POST["recommend"]);
			$sql = "select * from user where uid='".mysqli_real_escape_string($sqli, $recommend)."'";
			$result = mysqli_query($sqli,$sql);
			$rs_cn = mysqli_num_rows($result);
			
			$pwd = $_POST["pwd"];
			$email = $_POST["email"];
			$updatedate = date("Y-m-d H:i:s");
			$str = RandomString();
			$str = encrypt($str);
			if($rs_cn!=0){
				$sql = "INSERT INTO user(acc, pwd, state, email,recommend, verify_code, login_count, login_ip, login_date, creat_date)
				values('".$acc."','".encrypt($pwd)."','0','".$recommend."','".mysqli_real_escape_string($sqli, $email)."','".$str."','0','','".$updatedate."','".$updatedate."');";
			}
			else{
				$sql = "INSERT INTO user(acc, pwd, state, email,recommend, verify_code, login_count, login_ip, login_date, creat_date)
				values('".$acc."','".encrypt($pwd)."','0','','".mysqli_real_escape_string($sqli, $email)."','".$str."','0','','".$updatedate."','".$updatedate."');";
			}
			if(!mysqli_query($sqli,$sql)){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="注册帐号失败！";
				header("Location: ../index.php");
			}
			else{
				$u_id = mysqli_insert_id($sqli);
				//新增積分表
				$sql = "INSERT INTO point(uid) VALUES ('".$u_id."');";
				mysqli_query($sqli,$sql);
				//新增禮物列表
				$sql = "INSERT INTO gift(uid) VALUES ('".$u_id."');";
				mysqli_query($sqli,$sql);
				//新增基本資料表
				if($_POST["sex"]=="1"){
					$sql = "INSERT INTO member(uid, cert, name, mobile, nick, sex, measure, city_cate, city_code, blood_type, birth_day, height, weight, edu_bg, job, faith, interest, edit_date)
					value('".$u_id."','0','".$_POST["name"]."','".$_POST["mobile"]."','".$_POST["nick"]."','".$_POST["sex"]."','".$_POST["breast"]."-".$_POST["waist"]."-".$_POST["hips"]."'
					,'".$_POST["city_cate"]."','".$_POST["city_code"]."','".$_POST["blood_type"]."','".$_POST["birth_day_y"]."-".$_POST["birth_day_m"]."-".$_POST["birth_day_d"]."','".$_POST["height"]."'
					,'".$_POST["weight"]."','".$_POST["edu_bg"]."','".$_POST["job"]."','".$_POST["faith"]."','".$_POST["interest"]."','".$updatedate."');";
				}
				else{
					$sql = "INSERT INTO member(uid, cert, name, mobile, nick, sex, measure, city_cate, city_code, blood_type, birth_day, height, weight, edu_bg, job, faith, interest, edit_date)
					value('".$u_id."','0','".$_POST["name"]."','".$_POST["mobile"]."','".$_POST["nick"]."','".$_POST["sex"]."', NULL
					,'".$_POST["city_cate"]."','".$_POST["city_code"]."','".$_POST["blood_type"]."','".$_POST["birth_day_y"]."-".$_POST["birth_day_m"]."-".$_POST["birth_day_d"]."','".$_POST["height"]."'
					,'".$_POST["weight"]."','".$_POST["edu_bg"]."','".$_POST["job"]."','".$_POST["faith"]."','".$_POST["interest"]."','".$updatedate."');";
				}	
				mysqli_query($sqli,$sql);
				
				require("../include/js/mailer/class.phpmailer.php");
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPAuth = true; // turn on SMTP authentication
				$mail->CharSet = "utf-8"; 
				//這幾行是必須的
				
				$mail->Username = 'papcada1.clayart@gmail.com'; //
				$mail->Password = 'Q92001532'; //
				//這邊是你的gmail帳號和密碼
				
				$mail->FromName = "ICU优质男女交友网";
				// 寄件者名稱(你自己要顯示的名稱)
				$webmaster_email = 'papcada1.clayart@gmail.com'; 
				//回覆信件至此信箱
				
				
				//$email="papcada1.clayart@gmail.com"; //papcada.clayart@yahoo.com.tw
				// 收件者信箱
				$name=$acc;
				// 收件者的名稱or暱稱
				$mail->From = $webmaster_email;
				
				
				$mail->AddAddress($email,$name);
				$mail->AddReplyTo($webmaster_email,"Squall.f");
				//這不用改
				
				$mail->WordWrap = 50;
				//每50行斷一次行
				
				//$mail->AddAttachment("/XXX.rar");
				// 附加檔案可以用這種語法(記得把上一行的//去掉)
				
				$mail->IsHTML(true); // send as HTML
				
				$content = "亲爱的会员您好︰<br/><br/>";
				$content .= "欢迎加入ICU优质男女交友网，请点击以下网址进行开通，如果该网址没有出现连结，则请自行复制贴到网址列上<br/><br/>";
				$content .= "http://220.134.32.90/64_friend/ajax/register.php?action=verify&uid=".$u_id."&verify_code=".$str."";
				
				$mail->Subject = "ICU优质男女交友网-帐号开通"; 
				// 信件標題
				$mail->Body = $content;
				//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
				$mail->AltBody = $content; 
				//信件內容(純文字版)
				
				if(!$mail->Send()){
					$sql = "delete from user where u_id='".$u_id."'";
					//mysqli_query($sqli,$sql);
					echo "1|注册验证信件發生錯誤：" . $mail->ErrorInfo;
					//如果有錯誤會印出原因
				}
				else{
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="注册完毕，请先至信箱收信开启认证！！";
					header("Location: ../index.php");
				}
			}
		}
	}
	if($action == "check"){ // 判定重复帐号
		$target = $_POST["target"];
		$value = $_POST["value"];
		if($target=="mobile")
			$sql = "select * from member where ".$target."='".mysqli_real_escape_string($sqli, $value)."'";
		else
			$sql = "select * from user where ".$target."='".mysqli_real_escape_string($sqli, $value)."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		echo $rs_cn."|".$target;
	}
	if($action == "verify"){ // 帐号注册邮件开通
		$sql = "select * from user where uid='".mysqli_real_escape_string($sqli, $_GET["uid"])."' AND verify_code='".mysqli_real_escape_string($sqli, $_GET["verify_code"])."';";
		$sql;
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn!=1){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="帐号资讯发生问题，请提交email至官方网站获得帮助";
			header("Location: ../index.php");
		}
		else{
			$row = mysqli_fetch_array($result) ;
			if($row["state"]!=0){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="此帐号以获得会员开通资格，请勿重复点击网址";
				header("Location: ../index.php");
			}
			else{
				$sql = "update user set state=1 where uid='".$_GET["uid"]."';";
				if(!mysqli_query($sqli,$sql)){
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="会员帐号资格开通失败，请提交email至官方网站获得帮助";
					header("Location: ../index.php");
				}
				else{
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="恭喜您，会员资格开通成功，请重新登入";
					header("Location: ../index.php");
				}
			}
		}
	}
?>