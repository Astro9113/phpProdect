<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<div class="header">
	<div class="header-content">
    	<div class="logo left">
        
        
   <img src="/images/logo2.gif" />
                                    
        </div>
                <div class="nav left">
            <div class="menu left">
              <ul>
                <li><a class="hide<?php if($nav1==1){ echo " hover"; }?>" href="/user/commod/">产品及文案</a></li>
                <li><a class="hide<?php if($nav1==2){ echo " hover"; }?>" href="/user/">订单与结算</a></li>
                <li><a class="hide<?php if($nav1==3){ echo " hover"; }?>" href="/user/invite/">邀请与奖励</a></li>
                <li><a class="hide<?php if($nav1==4){ echo " hover"; }?>" href="/user/informa/">信息设置</a></li>
                <!--<li><a class="hide<?php if($nav1==6){ echo " hover"; }?>" href="/user/tool/">推广工具</a></li>-->
              </ul>
            </div>
        </div>
		<div class="nav-right-btn right">
        	<div class="nav-right-btn-top">账号：<em><?php echo $_SESSION['login1114name'];?></em><!--<small>1341</small>--><span><a href="/user/logout/">[退出登录]</a></span></div>
        </div>
            </div>

</div>