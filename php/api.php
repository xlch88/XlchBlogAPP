<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

$appVersion = '1.0.0';

//设置时区
date_default_timezone_set('PRC');

$do = isset($_GET['do']) ? $_GET['do'] : 'post';
$type = isset($_GET['type']) ? $_GET['type'] : '';

include('mysql.php');
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$db->set_charset('utf8');

if($do == 'post'){
	$option = [
		'number' => 20,
		'page' => 0,
		'cid' => 0,
		'type' => 'category'
	];

	if(isset($_GET['number'])) $option['number'] = (int)$_GET['number'];
	if(isset($_GET['page'])) $option['page'] = (int)$_GET['page'];
	if(isset($_GET['cid'])) $option['cid'] = addslashes($_GET['cid']);
	if(isset($_GET['type'])) $option['type'] = in_array($_GET['type'],['tag','category','search']) ? $_GET['type'] : 'category';
	if($option['type'] == 'tag') $option['type'] = 'post_tag';
	
	if($option['cid'] && $option['type'] != 'search'){
		$sql = 'select ID,post_content,post_title,post_date,post_date,wp_terms.name as term_name from wp_posts,wp_term_relationships,wp_term_taxonomy,wp_terms where ID=object_id and wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id and post_type="post" and post_status = "publish" and wp_term_relationships.term_taxonomy_id = "'.$option['cid'].'" and taxonomy = "'.$option['type'].'" and wp_terms.term_id = wp_term_relationships.term_taxonomy_id';
	}else if($option['type'] == 'search'){
		$sql = 'select ID,post_content,post_title,post_date,post_date,wp_terms.name as term_name from wp_posts,wp_term_relationships,wp_term_taxonomy,wp_terms where ID=object_id and wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id and post_type="post" and post_status = "publish" and wp_terms.term_id = wp_term_relationships.term_taxonomy_id and taxonomy = "category" and (`post_title` LIKE "%'.$option['cid'].'%" or `post_content` LIKE "%'.$option['cid'].'%")';
	}else{
		$sql = 'select ID,post_content,post_title,post_date,post_date,wp_terms.name as term_name from wp_posts,wp_term_relationships,wp_term_taxonomy,wp_terms where ID=object_id and wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id and post_type="post" and post_status = "publish" and wp_terms.term_id = wp_term_relationships.term_taxonomy_id and taxonomy = "category"';
	}
	$page = $option['page'] * $option['number'];
	$sql.= " order by ID desc limit {$page},{$option['number']}";
	$result = $db->query($sql);
	$rows = [];
	if($result){
		while($row = $result->fetch_assoc()){
			$row['img'] = getImg($row);
			$row['post_content'] = mb_substr(str_replace(["\r","\n"], ' ', strip_tags($row['post_content'])), 0, 100, 'utf-8') . '...';
			$row['sub_title'] = $row['term_name'] . ' | ' . timeago($row['post_date']);
			$rows[] = $row;
		}
	}
	$data = $rows;
	
	exit(json_encode(['code'=>1,'msg'=>'一切安好。','data'=>$data]));
}else if($do == 'term'){
	if($type == 'category' or !$type){
		$parents = [];
		$sons = [];
		
		$sql = 'SELECT wp_terms.term_id,name,parent,(select count(1) from wp_term_relationships,wp_posts where wp_term_relationships.term_taxonomy_id = wp_terms.term_id and object_id = ID and post_type="post" and post_status = "publish") as `count` FROM wp_terms,wp_term_taxonomy WHERE wp_term_taxonomy.term_id = wp_terms.term_id and wp_term_taxonomy.taxonomy = "category"';
		$result = $db->query($sql);
		if($result){
			while($row = $result->fetch_assoc()){
				if(!$row['parent']) $parents[$row['term_id']] = $row;
				else $sons[$row['term_id']] = $row;
			}
		}
		
		foreach($sons as $son){
			$parents[$son['parent']]['son'][] = $son;
		}
		
		$data = $parents;
		
		exit(json_encode(['code'=>1,'msg'=>'一切安好。','data'=>$data]));
	}else if($type == 'tag'){
		$rows = [];
		
		$sql = 'SELECT wp_terms.term_id,name,(select count(1) from wp_term_relationships,wp_posts where wp_term_relationships.term_taxonomy_id = wp_terms.term_id and object_id = ID and post_type="post" and post_status = "publish") as `count` FROM wp_terms,wp_term_taxonomy WHERE wp_term_taxonomy.term_id = wp_terms.term_id and wp_term_taxonomy.taxonomy = "post_tag" and count != 0 order by rand() desc limit 50';
		$result = $db->query($sql);
		$x = 0;
		
		if($result){
			while($row = $result->fetch_assoc()){
				if($x < 2) $weight = 5;
				else if($x < 10) $weight = 3;
				else if($x < 30) $weight = 2;
				else $weight = 1;
				
				$rows[] = ['text' => $row['name'], 'weight' => $weight, 'id' => $row['term_id']];
				$x++;
			}
		}
		
		exit(json_encode(['code'=>1,'msg'=>'一切安好。','data'=>$rows]));
	}
}else if($do == 'read'){
	if(isset($_GET['id'])) $id = (int)$_GET['id'];
	
	$sql = 'select ID,post_content,post_title,post_date,post_date,wp_terms.name as term_name from wp_posts,wp_term_relationships,wp_term_taxonomy,wp_terms where ID = "'.$id.'" and object_id = ID and wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id and post_type="post" and post_status = "publish" and taxonomy = "category" and wp_terms.term_id = wp_term_relationships.term_taxonomy_id';
	
	$result = $db->query($sql);
	if($result && ($row = $result->fetch_assoc())){
		
		$row['img'] = getImg($row);
		$row['sub_title'] = $row['term_name'] . ' | ' . timeago($row['post_date']);
		
		exit(json_encode(['code'=>1,'msg'=>'一切安好。','data'=>$row]));
	}else{
		exit(json_encode(['code'=>0,'msg'=>'未找到文章！','data'=>$row]));
	}
}else if($do == 'start'){
	file_put_contents('test.txt',$_POST['info']);
	$info = @json_decode($_POST['info'],true);
	$uuid = addslashes($info['deviceInfo']['plus.device.uuid']);
	$ip = addslashes(real_ip());
	
	if($info && $uuid){
		
		$sql = 'SELECT * FROM `xlch_app_user` where UUID = "'.$uuid.'"';
		$result = $db->query($sql);
		if(!$result or !($row = $result->fetch_assoc())){
			$sql = 'insert into `xlch_app_user` set UUID = "'.$uuid.'", lastIP = "'.$ip.'"';
			$db->query($sql);
			$id = $db->insert_id;
			
			$sql = 'SELECT * FROM `xlch_app_user` where `id` = "'.$id.'"';
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
		}
		
		$db->query('update xlch_app_user set lastDate = now(), lastIP = "'.$ip.'" where id = "'.$row['id'].'"');
		$db->query('insert into `xlch_app_log` set uid = "'.$row['id'].'", ip = "'.$ip.'", date = now(), deviceInfo = "'.addslashes(json_encode($info['deviceInfo'])).'",appVersion = "'.$info['appInfo']['version'].'"');
		
	}
}

function getImg($post_data){
	global $db;
	$sql = 'SELECT guid as url FROM `wp_postmeta`,`wp_posts` WHERE post_id = '.$post_data['ID'].' and meta_key = "_thumbnail_id" and wp_posts.ID = meta_value';
	$result = $db->query($sql);
	if($row = $result->fetch_assoc()){
		$url = $row['url'];
	}else{
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_data['post_content'], $matches);
        $post_thumbnail_src = isset($matches[1][0]) ? $matches[1][0] : ''; //获取该图片 src
		if(!empty($post_thumbnail_src)){
			$url = $post_thumbnail_src;
		}else{
			$url = '//xlch.me/wp-content/themes/Git-alpha/assets/img/pic/' . rand(1, 12) . '.jpg';
		}
	}
	if(substr($url, 0, 2) == '//'){
		$url = 'https:'.$url;
	}
	return $url;
}
function timeago($ptime) {
    $ptime = strtotime($ptime) + 60 * 60 * 2;
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';
    $interval = array(
        12 * 30 * 24 * 60 * 60 => '年前 (' . date('Y-m-d', $ptime) . ')',
        30 * 24 * 60 * 60 => '个月前 (' . date('m-d', $ptime) . ')',
        7 * 24 * 60 * 60 => '周前 (' . date('m-d', $ptime) . ')',
        24 * 60 * 60 => '天前',
        60 * 60 => '小时前',
        60 => '分钟前',
        1 => '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}
function real_ip(){
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
		$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] AS $xip) {
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
				$ip = $xip;
				break;
			}
		}
	}
	return $ip;
}