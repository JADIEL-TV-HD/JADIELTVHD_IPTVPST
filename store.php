<?php
declare(strict_types=1);
function hostloja_products(): array {
    $file = __DIR__ . '/data/products.json';
    if (!is_file($file)) return [];
    $data = json_decode((string) file_get_contents($file), true);
    return is_array($data) ? array_values(array_filter($data, static fn($p) => is_array($p) && isset($p['id'], $p['name'], $p['price']))) : [];
}
function hostloja_save(array $products): bool {
    $file = __DIR__ . '/data/products.json';
    $json = json_encode(array_values($products), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    $tmp = $file . '.tmp';
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    return rename($tmp, $file);
}
