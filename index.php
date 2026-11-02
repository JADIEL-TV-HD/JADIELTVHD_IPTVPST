<?php
declare(strict_types=1);
date_default_timezone_set('America/Bahia');
$productsFile = __DIR__ . '/data/products.json';
$products = [];
if (is_file($productsFile)) {
    $decoded = json_decode((string) file_get_contents($productsFile), true);
    if (is_array($decoded)) $products = $decoded;
}
$siteName = 'HOST MB STORE';
?><!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#0b8f55">
<meta name="description" content="HOST MB STORE — uma experiência de compras simples, rápida e moderna.">
<title><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
<script>window.HOST_MB_PRODUCTS = <?= json_encode($products, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;</script>
<script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script><script defer src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script><script defer src="assets/app.js"></script>
</head>
<body>
<div class="announcement"><span class="pulse-dot"></span> BEM-VINDO À HOST MB STORE <span>•</span> SUA PRÓXIMA DESCOBERTA ESTÁ AQUI</div>
<header class="site-header"><a class="brand" href="#"><span class="brand-mark">H<span>+</span></span><span class="brand-copy"><strong>HOST MB</strong><small>STORE</small></span></a>
<nav class="desktop-nav"><a class="active" href="#inicio">Início</a><a href="#catalogo">Produtos</a><a href="#beneficios">Por que comprar</a><a href="#sobre">Sobre</a></nav>
<div class="header-actions">
<button class="icon-button search-toggle" aria-label="Pesquisar"><svg viewBox="0 0 24 24"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg></button>
<button class="icon-button favorites-toggle" aria-label="Favoritos"><svg viewBox="0 0 24 24"><path d="M20.8 8.8c0 5.2-8.8 10.2-8.8 10.2S3.2 14 3.2 8.8A4.6 4.6 0 0 1 12 6.5a4.6 4.6 0 0 1 8.8 2.3Z"/></svg><i id="favoriteCount">0</i></button>
<button class="cart-button" id="openCart"><svg viewBox="0 0 24 24"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 1.9-1.4L22 8H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg><span>Carrinho</span><b id="cartCount">0</b></button>
<button class="mobile-menu" id="mobileMenu" aria-label="Abrir menu"><span></span><span></span></button></div></header>
<main>
<section class="hero" id="inicio"><div class="hero-orb orb-one"></div><div class="hero-orb orb-two"></div><div class="hero-content">
<div class="eyebrow hero-eyebrow"><span></span> DESCUBRA. ESCOLHA. APROVEITE.</div><h1 class="hero-title">Tudo o que você<br>procura, <em>em um só lugar.</em></h1>
<p class="hero-description">Uma seleção de produtos para facilitar seu dia a dia. Explore, encontre seus favoritos e compre com praticidade.</p>
<div class="hero-actions"><a class="primary-button" href="#catalogo">Explorar produtos <span>↗</span></a><a class="text-button" href="#beneficios">Conheça a loja →</a></div>
<div class="hero-proof"><div class="proof-avatars"><span>H</span><span>M</span><span>+</span></div><p><strong>Uma loja, muitas possibilidades.</strong><small>Encontre sua próxima escolha.</small></p></div></div>
<div class="hero-art"><div class="art-ring ring-a"></div><div class="art-ring ring-b"></div><div class="floating-tag tag-top"><span class="tag-icon">✦</span><span><b>Novidades</b><small>Descubra agora</small></span></div>
<div class="showcase-card"><div class="showcase-top"><span>HOST MB</span><span>● ONLINE</span></div><div class="showcase-symbol"><div class="symbol-back"></div><div class="symbol-front">H<span>+</span></div><div class="symbol-spark">✦</div></div><div class="showcase-bottom">STORE EXPERIENCE <b>01 / 04</b></div></div>
<div class="floating-tag tag-bottom"><span class="tag-icon green-icon">✓</span><span><b>Compra prática</b><small>Do seu jeito</small></span></div></div><a class="scroll-cue" href="#catalogo">↓ ROLE PARA DESCOBRIR</a></section>
<section class="trust-strip" id="beneficios"><div class="trust-item"><span class="trust-icon">✧</span><div><b>Variedade</b><small>Diversas categorias</small></div></div><div class="trust-item"><span class="trust-icon">⌕</span><div><b>Fácil de encontrar</b><small>Busca simples e rápida</small></div></div><div class="trust-item"><span class="trust-icon">♡</span><div><b>Seus favoritos</b><small>Salve o que gostar</small></div></div><div class="trust-item"><span class="trust-icon">↗</span><div><b>Atendimento direto</b><small>Fale com nossa equipe</small></div></div></section>
<section class="catalog-section section-wrap" id="catalogo"><div class="section-heading"><div><div class="eyebrow"><span></span> ESCOLHA O QUE COMBINA COM VOCÊ</div><h2>Explore nossa <em>coleção.</em></h2><p>Encontre produtos para diferentes momentos e necessidades.</p></div><div class="catalog-count"><strong id="resultCount">0</strong><span>produtos<br>disponíveis</span></div></div>
<div class="catalog-toolbar"><div class="category-tabs" id="categoryTabs"></div><div class="catalog-tools"><label class="search-field"><svg viewBox="0 0 24 24"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><input id="productSearch" type="search" placeholder="Buscar produto..."></label><select id="sortSelect"><option value="featured">Em destaque</option><option value="low">Menor preço</option><option value="high">Maior preço</option><option value="name">Nome A–Z</option></select></div></div>
<div class="product-grid" id="productGrid"></div><div class="empty-state" id="emptyState" hidden><span>⌕</span><h3>Nenhum produto encontrado</h3><p>Tente mudar a busca ou selecionar outra categoria.</p><button class="outline-button" id="clearFilters">Limpar filtros</button></div></section>
<section class="feature-banner section-wrap" id="sobre"><div class="feature-copy"><div class="eyebrow light-eyebrow"><span></span> HOST MB STORE</div><h2>Uma experiência<br>de compra mais <em>leve.</em></h2><p>Estamos aqui para tornar sua busca mais simples. Navegue pelas categorias, descubra novidades e fale com a nossa equipe quando precisar.</p><a class="light-button" href="#catalogo">Ver produtos ↗</a></div><div class="feature-graphic"><div class="feature-circle circle-outer"></div><div class="feature-circle circle-inner"></div><div class="feature-h">H<span>+</span></div><div class="feature-star star-one">✦</div><div class="feature-star star-two">✧</div><div class="feature-caption">SUA LOJA<br>DE POSSIBILIDADES</div></div></section>
</main>
<footer class="footer"><div class="footer-main"><a class="brand" href="#"><span class="brand-mark">H<span>+</span></span><span class="brand-copy"><strong>HOST MB</strong><small>STORE</small></span></a><p>Uma loja com diferentes possibilidades.<br>Encontre o que procura com praticidade.</p><a class="back-top" href="#inicio">Voltar ao topo ↑</a></div><div class="footer-bottom"><span>© <?= date('Y') ?> HOST MB STORE. Todos os direitos reservados.</span><span>Feito para uma experiência simples e moderna.</span></div></footer>
<div class="overlay" id="overlay"></div><aside class="cart-drawer" id="cartDrawer" aria-hidden="true"><div class="drawer-head"><div><span class="eyebrow">SUA SELEÇÃO</span><h3>Meu carrinho</h3></div><button class="close-button" id="closeCart">×</button></div><div class="cart-items" id="cartItems"></div><div class="cart-footer"><div class="cart-total"><span>Total estimado</span><strong id="cartTotal">R$ 0,00</strong></div><p>O pedido será enviado para confirmação com a equipe da loja.</p><button class="checkout-button" id="checkoutButton">Finalizar pelo WhatsApp ↗</button><small class="checkout-note">A compra só será confirmada após atendimento.</small></div></aside>
<div class="toast" id="toast" role="status" aria-live="polite"></div><button class="mobile-cart-fab" id="mobileCartFab">🛒 <span id="mobileCartCount">0</span></button>
</body></html>