<?php
declare(strict_types=1);
session_name('ARQUIVOSESSID');
session_start();
const STORE = __DIR__ . '/storage';
const DATA = STORE . '/data';
const FILES = STORE . '/files';
function init_store(): void {
  foreach ([STORE,DATA,FILES] as $p) if (!is_dir($p)) mkdir($p,0700,true);
  foreach (['users.json'=>[], 'admins.json'=>[], 'files.json'=>[]] as $f=>$v) {
    $p=DATA.'/'.$f; if (!file_exists($p)) file_put_contents($p,json_encode($v),LOCK_EX);
  }
}
function read_json(string $name): array {
  $p=DATA.'/'.$name; $h=fopen($p,'c+'); if(!$h) return [];
  flock($h,LOCK_SH); $s=stream_get_contents($h); flock($h,LOCK_UN); fclose($h);
  $v=json_decode($s?:'[]',true); return is_array($v)?$v:[];
}
function write_json(string $name,array $v): bool {
  $p=DATA.'/'.$name; $h=fopen($p,'c+'); if(!$h) return false;
  flock($h,LOCK_EX); ftruncate($h,0); rewind($h);
  $ok=fwrite($h,json_encode($v,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES))!==false;
  fflush($h); flock($h,LOCK_UN); fclose($h); return $ok;
}
function csrf(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function check_csrf(): void { if(!hash_equals($_SESSION['csrf']??'',(string)($_POST['csrf']??''))){ http_response_code(403); exit('Solicitação inválida. Atualize a página.'); } }
function user(): ?array { return $_SESSION['user']??null; }
function admin(): bool { return !empty($_SESSION['admin']); }
function need_user(): void { if(!user()){header('Location: index.php');exit;} }
function esc(string $s): string { return htmlspecialchars($s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function clean_name(string $s): string { $s=basename(str_replace('\\','/',$s)); return trim(preg_replace('/[\\x00-\\x1F\\x7F]/u','',$s)??''); }
function flash(string $s): void { $_SESSION['flash']=$s; }
function get_flash(): string { $s=$_SESSION['flash']??''; unset($_SESSION['flash']); return $s; }
init_store();
?>