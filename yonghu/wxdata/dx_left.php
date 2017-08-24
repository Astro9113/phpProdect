<div class="vip-content-l">
        	<h1>订单与结算</h1>
            	<div id="nav-left-chang" >
			<ul  id="vip-content-l-shang">
               
               <?php if($nav1==2){ ?>
                <li class="vip-content-l-lb<?php if($nav2==1){ echo " hover"; }?>"><a href="/user/">统计总揽</a></li>
                <li class="vip-content-l-lb<?php if($nav2==2){ echo " hover"; }?>"><a href="/user/order/">推广的订单</a></li>
                <li class="vip-content-l-lb<?php if($nav2==3){ echo " hover"; }?>"><a href="/user/order/settle/">结算与返款</a></li>
                <!-- <li class="vip-content-l-lb<?php if($nav2==4){ echo " hover"; }?>"><a href="#">联不上发货中</a></li> -->
                <?php }elseif($nav1==1){  ?>
                <li class="vip-content-l-lb<?php if($nav2==1){ echo " hover"; }?>"><a href="/user/commod/">浏览商品</a></li>
                <li class="vip-content-l-lb<?php if($nav2==2){ echo " hover"; }?>"><a href="/user/channel/">渠道设置</a></li>
                <li class="vip-content-l-lb<?php if($nav2==3){ echo " hover"; }?>"><a href="/user/statist/">商品渠道出单统计</a></li>
                <li class="vip-content-l-lb<?php  if($nav2==4){ echo " hover"; } ?>"><a href="/user/flow/">发布访问流量</a></li>
                <?php }elseif($nav1==3){  ?>
                <li class="vip-content-l-lb<?php if($nav2==1){ echo " hover"; }?>"><a href="/user/invite/">邀请链接</a></li>
                <li class="vip-content-l-lb<?php if($nav2==2){ echo " hover"; }?>"><a href="/user/invite/invuser/">邀请用户</a></li>
                <li class="vip-content-l-lb<?php if($nav2==3){ echo " hover"; }?>"><a href="/user/invite/invorder/">用户订单</a></li>
                <?php }elseif($nav1==4){  ?>
                <li class="vip-content-l-lb<?php if($nav2==1){ echo " hover"; }?>"><a href="/user/informa/">帐号信息</a></li>
                <li class="vip-content-l-lb<?php if($nav2==2){ echo " hover"; }?>"><a href="/user/informa/modpassword/">修改密码</a></li>
                <?php }elseif($nav1==5){  ?>
                <li class="vip-content-l-lb<?php if($nav2==1){ echo " hover"; }?>"><a href="/user/support/post/">提交工单</a></li>
                <li class="vip-content-l-lb<?php if($nav2==2){ echo " hover"; }?>"><a href="/user/support/?status=all">我的工单</a></li>
                <?php }elseif($nav1==6){  ?>
                <li class="vip-content-l-lb<?php if($nav2==1){ echo " hover"; }?>"><a href="/user/tool/">cps广告代码</a></li>
                <li class="vip-content-l-lb<?php if($nav2==2){ echo " hover"; }?>"><a href="#">未完待续..</a></li>
                <?php }?>
            </ul>  
			
            <h1 style="margin-top:30px;">重要公告</h1>
            <ul  id="vip-content-l-shang">
            	<li class="vip-content-l-nav" style=" padding-top:5px;padding-bottom: 50px;"><a href="/user/active/" class="jiekouwd">发现金了！</a></li>
            </ul>
     </div>
            <ul>
                <li id="vip-ihuyi-content-l-xia"></li>
            </ul>
        </div>