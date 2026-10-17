<?php
require __DIR__.'/common.php';
$admins=read_json('admins.json'); $setup=count($admins)===0;
if(isset($_GET['sair'])){$_SESSION=[];session_destroy();header('Location: gestor.php');exit;}
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 check_csrf(); $action=(string)($_POST['action']??'');
 if($setup && $action==='setup'){
  $name=trim((string)($_POST['name']??''));$email=strtolower(trim((string)($_POST['email']??'')));$pass=(string)($_POST['password']??'');
  if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($pass)<12)$err='Informe nome, e-mail válido e senha com pelo menos 12 caracteres.';
  else {write_json('admins.json',[['name'=>$name,'email'=>$email,'password'=>password_hash($pass,PASSWORD_DEFAULT)]]);session_regenerate_id(true);$_SESSION['admin']=true;header('Location: gestor.php');exit;}
 } elseif(!admin() && $action==='login'){
  $email=strtolower(trim((string)($_POST['email']??'')));$pass=(string)($_POST['password']??'');
  foreach($admins as $a)if(strtolower($a['email'])===$email&&password_verify($pass,$a['password'])){session_regenerate_id(true);$_SESSION['admin']=true;header('Location: gestor.php');exit;}
  $err='E-mail ou senha incorretos.';
 } elseif(admin() && $action==='create'){
  $name=trim((string)($_POST['name']??''));$email=strtolower(trim((string)($_POST['email']??'')));$pass=(string)($_POST['password']??'');
  if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($pass)<12)$err='Preencha nome, e-mail válido e senha com pelo menos 12 caracteres.';
  else {$users=read_json('users.json');foreach($users as $u)if(strtolower($u['email'])===$email)$err='Este e-mail já tem acesso.';
   if(!$err){$users[]=['id'=>bin2hex(random_bytes(12)),'name'=>$name,'email'=>$email,'password'=>password_hash($pass,PASSWORD_DEFAULT),'active'=>true];write_json('users.json',$users);flash('Acesso criado. Entregue a senha ao usuário por um canal seguro.');header('Location: gestor.php');exit;}
  }
 } elseif(admin() && $action==='toggle'){
  $id=(string)($_POST['id']??'');$users=read_json('users.json');foreach($users as &$u)if($u['id']===$id)$u['active']=!$u['active'];unset($u);write_json('users.json',$users);header('Location: gestor.php');exit;
 }
}
$users=read_json('users.json');
?><!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Gestor · Meu Arquivo</title><style>*{box-sizing:border-box}body{margin:0;background:#f3f7f4;color:#17221b;font:16px system-ui}.wrap{max-width:900px;margin:40px auto;padding:0 16px}.panel{background:white;border:1px solid #e0e8e2;border-radius:18px;padding:24px;margin:18px 0}input{display:block;width:100%;padding:12px;border:1px solid #cbd8ce;border-radius:10px;margin:7px 0 15px;font:inherit}button{background:#176d3c;color:#fff;border:0;border-radius:10px;padding:12px 16px;font-weight:bold;cursor:pointer}a{color:#176d3c}.user{border-bottom:1px solid #e7eee9;padding:14px 0;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}.err{background:#ffeded;color:#922;padding:12px;border-radius:10px}</style></head><body><main class="wrap"><h1>Gestor · Meu Arquivo</h1><?php if($err): ?><div class="err"><?=esc($err)?></div><?php endif ?>
<?php if($setup): ?><section class="panel"><h2>Configuração inicial do gestor</h2><p>Crie a conta administrativa. Use uma senha única com pelo menos 12 caracteres.</p><form method="post"><input type="hidden" name="csrf" value="<?=esc(csrf())?>"><input type="hidden" name="action" value="setup"><label>Nome</label><input name="name" required maxlength="100"><label>E-mail</label><input name="email" type="email" required><label>Senha (mínimo 12 caracteres)</label><input name="password" type="password" minlength="12" required><button>Criar gestor</button></form></section>
<?php elseif(!admin()): ?><section class="panel"><h2>Login do gestor</h2><form method="post"><input type="hidden" name="csrf" value="<?=esc(csrf())?>"><input type="hidden" name="action" value="login"><label>E-mail</label><input name="email" type="email" required><label>Senha</label><input name="password" type="password" required><button>Entrar</button></form></section>
<?php else: ?><p><a href="index.php">Abrir área de arquivos</a> · <a href="?sair=1">Sair</a></p><?php if($m=get_flash()): ?><p class="panel"><?=esc($m)?></p><?php endif ?><section class="panel"><h2>Criar acesso para o site</h2><form method="post"><input type="hidden" name="csrf" value="<?=esc(csrf())?>"><input type="hidden" name="action" value="create"><label>Nome do usuário</label><input name="name" required maxlength="100"><label>E-mail de login</label><input name="email" type="email" required><label>Senha inicial (mínimo 12 caracteres)</label><input name="password" type="password" minlength="12" required><button>Criar acesso</button></form></section><section class="panel"><h2>Acessos criados</h2><?php foreach($users as $u): ?><div class="user"><div><strong><?=esc($u['name'])?></strong><br><?=esc($u['email'])?><br><small><?=!empty($u['active'])?'Ativo':'Desativado'?></small></div><form method="post"><input type="hidden" name="csrf" value="<?=esc(csrf())?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?=esc($u['id'])?>"><button><?=!empty($u['active'])?'Desativar':'Ativar'?></button></form></div><?php endforeach ?></section><?php endif ?></main></body></html>