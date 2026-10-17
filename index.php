<?php
require __DIR__.'/common.php';
if(isset($_GET['sair'])) { $_SESSION=[]; session_destroy(); header('Location: index.php'); exit; }
$users=read_json('users.json');
if(!user() && $_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action']??'')==='login'){
 check_csrf(); $email=strtolower(trim((string)($_POST['email']??''))); $pass=(string)($_POST['password']??'');
 foreach($users as $u) if(strtolower($u['email'])===$email && !empty($u['active']) && password_verify($pass,$u['password'])) {
   session_regenerate_id(true); $_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email']]; header('Location: index.php'); exit;
 }
 $err='E-mail ou senha incorretos, ou acesso desativado.';
}
if(user() && $_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action']??'')==='upload'){
 need_user(); check_csrf();
 if(empty($_FILES['file']) || $_FILES['file']['error']!==UPLOAD_ERR_OK) $err='Não foi possível receber o arquivo. Verifique o limite de upload da hospedagem.';
 else {
  $f=$_FILES['file']; $name=clean_name((string)$f['name']);
  if($name==='' || $f['size']<=0 || $f['size']>25*1024*1024) $err='Arquivo inválido ou maior que 25 MB.';
  else {
   $id=bin2hex(random_bytes(16)); $stored=$id.'.dat';
   if(move_uploaded_file($f['tmp_name'],FILES.'/'.$stored)){
    $meta=read_json('files.json'); $meta[]=['id'=>$id,'name'=>$name,'size'=>(int)$f['size'],'owner'=>user()['id'],'created'=>date('c')];
    if(write_json('files.json',$meta)) flash('Arquivo enviado com segurança.');
    else { @unlink(FILES.'/'.$stored); $err='Não foi possível salvar os dados do arquivo.'; }
   } else $err='Falha ao armazenar o arquivo.';
  }
 }
 if(empty($err)){header('Location: index.php');exit;}
}
$myfiles=array_values(array_filter(read_json('files.json'),fn($f)=>($f['owner']??'')===(user()['id']??'')));
usort($myfiles,fn($a,$b)=>strcmp($b['created']??'', $a['created']??''));
function size_label(int $n): string { return $n<1048576?round($n/1024,1).' KB':round($n/1048576,2).' MB'; }
?><!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Meu Arquivo</title><style>
*{box-sizing:border-box}body{margin:0;background:#f4f7f5;color:#17221b;font:16px system-ui}header{background:#123d2a;color:white;padding:18px max(5%,calc((100% - 1100px)/2));display:flex;justify-content:space-between;align-items:center;gap:15px}a{color:#176b3d}header a{color:#fff}.wrap{max-width:1000px;margin:32px auto;padding:0 18px}.panel{background:#fff;border:1px solid #e0e8e2;border-radius:18px;padding:24px;margin-bottom:20px;box-shadow:0 8px 28px #173d2a0a}h1{margin:0;font-size:25px}h2{margin-top:0}.muted{color:#68776d}.btn{border:0;border-radius:10px;background:#16713d;color:white;padding:12px 16px;font-weight:650;cursor:pointer;text-decoration:none;display:inline-block}.field{width:100%;padding:12px;border:1px solid #ccd8cf;border-radius:10px;margin:7px 0 14px;font:inherit}.file{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:14px 0;border-bottom:1px solid #edf1ee;flex-wrap:wrap}.file:last-child{border:0}.notice{background:#e8f5eb;padding:12px;border-radius:10px;margin-bottom:15px}.err{background:#ffeded;color:#9a2020;padding:12px;border-radius:10px;margin-bottom:15px}small{display:block;margin-top:10px}
</style></head><body><header><strong>📁 Meu Arquivo</strong><?php if(user()): ?><span><?=esc(user()['name'])?> · <a href="?sair=1">Sair</a></span><?php endif ?></header><main class="wrap">
<?php if(!user()): ?><section class="panel" style="max-width:460px;margin:50px auto"><h1>Acesse seus documentos</h1><p class="muted">Entre com o acesso criado pelo gestor.</p><?php if(!empty($err)): ?><div class="err"><?=esc($err)?></div><?php endif ?><form method="post"><input type="hidden" name="csrf" value="<?=esc(csrf())?>"><input type="hidden" name="action" value="login"><label>E-mail</label><input class="field" type="email" name="email" required autocomplete="username"><label>Senha</label><input class="field" type="password" name="password" required autocomplete="current-password"><button class="btn">Entrar</button></form></section>
<?php else: ?><h1>Seus documentos</h1><p class="muted">Envie e organize seus arquivos em um só lugar.</p><?php if($m=get_flash()): ?><div class="notice"><?=esc($m)?></div><?php endif ?><?php if(!empty($err)): ?><div class="err"><?=esc($err)?></div><?php endif ?><section class="panel"><h2>Enviar arquivo</h2><form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?=esc(csrf())?>"><input type="hidden" name="action" value="upload"><input class="field" type="file" name="file" required><p class="muted">Até 25 MB por arquivo. Documentos e outros formatos são aceitos; arquivos executáveis não devem ser compartilhados.</p><button class="btn">Enviar arquivo</button></form></section><section class="panel"><h2>Arquivos guardados (<?=count($myfiles)?>)</h2><?php if(!$myfiles): ?><p class="muted">Nenhum arquivo enviado ainda.</p><?php endif ?><?php foreach($myfiles as $f): ?><div class="file"><div><strong><?=esc($f['name'])?></strong><div class="muted"><?=esc(size_label((int)$f['size']))?> · <?=esc(date('d/m/Y H:i',strtotime($f['created'])))?></div></div><a class="btn" href="download.php?id=<?=rawurlencode($f['id'])?>">Baixar</a></div><?php endforeach ?></section><?php endif ?></main></body></html>