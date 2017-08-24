<?php  
    require $_SERVER['DOCUMENT_ROOT']."/wxdata/sjk1114.php";
    require("../../wxdata/dx_fun.php");
    
    foreach($_POST as $v){
        if($v!==gl2($v)){
            alert('信息格式错误,请重新填写');
            goback();
        }
        
        if($v!==gl_sql($v)){
            alert('信息格式错误,请重新填写');
            goback();
        }
    }
    
    $password   = trim($_POST['addpassword']);
    $pwd = md5($password.$encode_salt);
    $loginname  = trim($_POST['addusername']);
    $qq         = trim($_POST['qq']);
    $tel        = trim($_POST['tel']);
    $nicheng    = trim($_POST['nicheng']);
    $applyma    = trim($_POST['applyma']);
    $applyma    = base64_decode($applyma);
    
	
    if(!preg_match('/^\d+$/', $applyma)){
        alert('邀请码格式错误');
        goback();
    }
    
    if(!is_qq($qq)){
        alert('qq号码只能是数字');
        goback();
    }
    
    if(!is_tel($tel)){
        alert('手机号码只能是11位数字');
        goback();
    }
    

    //空项判断
    if($password=='' or $loginname=='' or $qq=='' or $tel=='' or $nicheng==''){
        exit("<script>alert('填写不完整，请返回重新填写'); javascript:history.go(-1);</script>");
    }
    
    //用户名检查
    $sql=mysql_query("select id from wx_user where loginname='$loginname'");
    $num=mysql_num_rows($sql);
    if($num>0){
        exit("<script>alert('用户名被占用！'); javascript:history.go(-1);</script>");
    }

    
    //邀请码
    $_applyma = get_applyma_uid($applyma);
	
	
    if(!$_applyma){
        $applyma = $mr_applyma;
        $_applyma = get_applyma_uid($applyma);
    }
    
    $apply_uid = $_applyma['userid'];
    if(substr($applyma, 0,2)=='00'){
        //媒介邀请
        $topuser = 'm'.$apply_uid;
        $dinguser = '';
        $invite_m = $apply_uid;
        $invite_u = 0;
    }else{
        //用户邀请
        $mid = get_mid($apply_uid); 
        $topuser = $apply_uid;
        $dinguser = 'm'.$mid;
        $invite_m = $mid;
        $invite_u = $apply_uid;
    }
    
    //有相同的qq 并且媒介是1 的 分配到同一个媒介下面
    if(($invite_m==1) && (!$invite_u)){
        $_user = get_user_byqq($qq);
        if($_user){
            $mid = get_mid($_user['id']);
            $topuser = 'm'.$mid;
            $invite_m = $mid;
        }
    }
    

 
/*验证支付宝唯一
 $sql3=mysql_query("select * from wx_user where alipay='$alipay'");
   $num3=mysql_num_rows($sql3);
   if($num3>0){
		exit("<script>alert('此支付宝已有人注册了！'); javascript:history.go(-1);</script>");
   }
*/


$sql = "insert into wx_user(loginname,username,password,pwd,qq,tel,topuser,dinguser,invite_u,invite_m) values('$loginname','$nicheng','$password','$pwd','$qq','$tel','$topuser','$dinguser','$invite_u','$invite_m')";


$ret = $mysql->execute($sql); 

if($ret !== false){
	exit("<script>alert('注册成功，请登录！');  window.location.href='/user/login/';</script>");
}else{
	exit("<script>alert('注册失败，请联系客服'); javascript:history.go(-1);</script>");
}	