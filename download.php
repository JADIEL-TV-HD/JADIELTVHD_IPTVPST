<?php
require __DIR__.'/common.php'; need_user();
$id=(string)($_GET['id']??''); if(!preg_match('/^[a-f0-9]{32}$/',$id)){http_response_code(404);exit('Arquivo não encontrado.');}
$all=read_json('files.json');$found=null;foreach($all as $f)if(($f['id']??'')===$id&&($f['owner']??'')===user()['id']){$found=$f;break;}
if(!$found){http_response_code(404);exit('Arquivo não encontrado.');}
$path=FILES.'/'.$id.'.dat';if(!is_file($path)){http_response_code(404);exit('Arquivo não encontrado.');}
$name=clean_name($found['name']);header('X-Content-Type-Options: nosniff');header('Content-Type: application/octet-stream');header('Content-Length: '.filesize($path));header('Content-Disposition: attachment; filename="download"; filename*=UTF-8\'\''.rawurlencode($name));readfile($path);exit;
?>