<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wxdata/sjk1114.php';
header('content-type:text/html;charset=utf-8');
$sql  = "SELECT guestsheng,COUNT(*) as num  FROM  wx_guest where 1 group by guestsheng order by num desc";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)){
    $shengs[$row['guestsheng']] = $row['num'];
}

$sql  = "SELECT guestsex,COUNT(*) as num  FROM  wx_guest where 1 group by guestsex order by num desc";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)){
    $sexes[$row['guestsex']] = $row['num'];
}

$sql  = "SELECT guestage,COUNT(*) as num  FROM  wx_guest where 1 group by guestage order by num desc";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)){
    $ages[$row['guestage']] = $row['num'];
}

?>

<!doctype html>
<html lang="en">
<head>
  <script type="text/javascript" src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/exporting.js"></script>
  <script>
  $(function () {
	    $('#container').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: '微优出单省份分布图'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: '所占比例',
	            data: [
                <?php
                    foreach ($shengs as $sheng=>$num){
                        $sheng = trim($sheng);
                        $str[] = "['{$sheng}',   {$num}]";
                    }
                    echo join(",".PHP_EOL, $str);
                ?>
		   	    ]
	        }]
	    });
	});				
  </script>
  
<script>
  $(function () {
	    $('#container1').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: '微优出单性别分布图'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: '所占比例',
	            data: [
                <?php
                    $str = array();
                    $arr = array('女','男');
                    foreach ($sexes as $sex=>$num){
                        $sex = trim($sex);
                        $sex = $arr[$sex]?$arr[$sex]:'其他';
                        $str[] = "['{$sex}',   {$num}]";
                    }
                    echo join(",".PHP_EOL, $str);
                ?>
		   	    ]
	        }]
	    });
	});				
  </script>
  
    <script>
  $(function () {
	    $('#container2').highcharts({
	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: '微优出单年龄分布图'
	        },
	        tooltip: {
	    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: '所占比例',
	            data: [
                <?php
                $str = array();
                $arr  =  array(
                            1 =>'18岁以下',
                            2 =>'18岁--25岁',
                            3 =>'26岁--35岁',
                            4 =>'36岁--45岁',
                            5 =>'46岁--60岁',
                            6 =>'60岁以上',
                    );
                    foreach ($ages as $age=>$num){
                        $age = trim($age);
                        $age = $arr[$age]?$arr[$age]:'其他';
                        $str[] = "['{$age}',   {$num}]";
                    }
                    echo join(",".PHP_EOL, $str);
                ?>
		   	    ]
	        }]
	    });
	});				
  </script>
  
  
</head>
<body>
  <div id="container" style="min-width:700px;height:400px"></div>
  <div id="container1" style="min-width:700px;height:400px"></div>
  <div id="container2" style="min-width:700px;height:400px"></div>
</body>
</html>