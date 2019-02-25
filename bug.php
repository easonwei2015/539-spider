<?php

/*

爬今彩539的資料

*/

//include('simple_html_dom.php');
include('config/mysql_connet.php');
$date = date('Yms');

for($i=1;$i<=110;$i++){
	
	$url = "http://www.lotto-8.com/listlto539.asp?indexpage=".$i."&orderby=new";
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($ch);
	curl_close($ch);

	preg_match_all('/<td class="auto-style5" style="border-bottom-style: dotted; border-bottom-color: #CCCCCC; font-size:24px;">([^<>]+)<\/td>/',$content,$target);
	preg_match_all('/<td class="auto-style5" style="border-bottom-style: dotted; border-bottom-color: #CCCCCC; font-size:36px;">([^<>]+)<\/td>/',$content,$target1);

	// 找有無重複日期
	foreach($target[1] as $key => $value){
		
		$main_query = $mysqli->query("SELECT count(*) AS COUNT FROM `539_data` WHERE date ='".trim($target[1][$key])."'");

		$main_data = $main_query->fetch_assoc();
		
		// 有需要新增才新增
		if($main_data['COUNT']==0){
			$sql = "INSERT INTO `539_data`(`date`, `number`, `create_date`) VALUES ('".$target[1][$key]."','".str_replace('&nbsp;','',$target1[1][$key])."','".$date."');";	
							
			if ($mysqli->query($sql) === TRUE) {
				//echo "第".$i."頁新增成功<br>";			
			} else {
				//echo "Error: " . $sql . "<br>" . $mysqli->error;
			}		
		}else{
			// 新增至找到有資料的日期為止
			exit;
		}	
	}
	
	
	echo "第".$i."頁新增成功<br>";	
}

unset($main_data);
unset($main_query);
$mysqli->close();

?>