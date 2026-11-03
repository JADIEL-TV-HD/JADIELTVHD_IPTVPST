(()=>{'use strict';const $=s=>document.querySelector(s);const products=Array.isArray(window.HOSTLOJA_PRODUCTS)?window.HOSTLOJA_PRODUCTS:[];const money=n=>Number(n||0).toLocaleString('pt-BR',{style:'currency',currency:'BRL'});const esc=v=>String(v??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));let cart=[];try{cart=JSON.parse(localStorage.getItem('hostloja_cart')||'[]')}catch{cart=[]}let toastTimer;const save=()=>localStorage.setItem('hostloja_cart',JSON.stringify(cart));function toast(t){const el=$('#toast');el.textContent=t;el.classList.add('show');clearTimeout(toastTimer);toastTimer=setTimeout(()=>el.classList.remove('show'),2600)}function renderProducts(){const grid=$('#productGrid');$('#productCount').textContent=products.length;grid.innerHTML=products.map((p,i)=>`<article class="product-card"><div class="product-topline"><span>HOST MB ACCESS</span><span class="product-index">0${i+1}</span></div><div class="product-art art-${i%3}"><div class="art-halo"></div><div class="product-glyph">${esc(p.emoji||'✦')}</div><span class="art-caption">DIGITAL EXPERIENCE</span></div><div class="product-content"><span class="product-type">${esc(p.duration||'ACESSO DIGITAL')}</span><h3>${esc(p.name)}</h3><p>${esc(p.description||'Escolha seu acesso e fale com nosso atendimento.')}</p><div class="product-buy"><div><small>VALOR</small><b>${Number(p.price)>0?money(p.price):'Consulte'}</b></div><button class="add-cart" data-add="${esc(p.id)}">Adicionar ao carrinho <span>＋</span></button></div></div></article>`).join('');$('#emptyState').hidden=products.length>0;if(window.gsap&&!matchMedia('(prefers-reduced-motion: reduce)').matches){gsap.from('.product-card',{y:34,opacity:0,duration:.7,stagger:.12,ease:'power3.out',scrollTrigger:{trigger:'.product-grid',start:'top 85%'}})}}function renderCart(){const count=cart.reduce((s,x)=>s+x.qty,0);$('#cartCount').textContent=count;const items=cart.map(x=>{const p=products.find(y=>String(y.id)===String(x.id));return p?{...p,qty:x.qty}:null}).filter(Boolean);$('#cartItems').innerHTML=items.length?items.map(p=>`<div class="cart-row"><div class="cart-item-icon">${esc(p.emoji||'✦')}</div><div class="cart-item-copy"><b>${esc(p.name)}</b><small>${p.qty} unidade(s) · ${Number(p.price)>0?money(p.price):'Preço a confirmar'}</small><div class="qty"><button data-qty="${esc(p.id)}" data-delta="-1">−</button><span>${p.qty}</span><button data-qty="${esc(p.id)}" data-delta="1">＋</button></div></div><button class="remove" data-remove="${esc(p.id)}" aria-label="Remover">×</button></div>`).join(''):'<div class="cart-empty"><span>◈</span><b>Seu carrinho está vazio.</b><small>Adicione um acesso para continuar.</small></div>';const total=items.reduce((s,p)=>s+Number(p.price)*p.qty,0);$('#cartTotal').textContent=total>0?money(total):'A combinar';$('#checkout').disabled=!items.length;save()}function openCart(){renderCart();$('#shade').classList.add('visible');$('#drawer').classList.add('visible');$('#drawer').setAttribute('aria-hidden','false');document.body.classList.add('locked')}function closeCart(){$('#shade').classList.remove('visible');$('#drawer').classList.remove('visible');$('#drawer').setAttribute('aria-hidden','true');document.body.classList.remove('locked')}$('#productGrid').addEventListener('click',e=>{const b=e.target.closest('[data-add]');if(!b)return;const id=b.dataset.add;const item=cart.find(x=>String(x.id)===String(id));if(item)item.qty++;else cart.push({id,qty:1});renderCart();b.classList.add('added');b.innerHTML='Adicionado <span>✓</span>';toast('Produto adicionado ao carrinho.');setTimeout(()=>{b.classList.remove('added');b.innerHTML='Adicionar ao carrinho <span>＋</span>'},1300)});$('#cartItems').addEventListener('click',e=>{const q=e.target.closest('[data-qty]');const r=e.target.closest('[data-remove]');if(q){const item=cart.find(x=>String(x.id)===String(q.dataset.qty));if(item){item.qty+=Number(q.dataset.delta);if(item.qty<=0)cart=cart.filter(x=>x!==item)}renderCart()}if(r){cart=cart.filter(x=>String(x.id)!==String(r.dataset.remove));renderCart()}});$('#cartOpen').addEventListener('click',openCart);$('#cartClose').addEventListener('click',closeCart);$('#shade').addEventListener('click',closeCart);$('#checkout').addEventListener('click',()=>{const lines=cart.map(x=>{const p=products.find(y=>String(y.id)===String(x.id));return p?`• ${p.name} — ${x.qty} unidade(s)`:''}).filter(Boolean);if(!lines.length)return;const msg='Olá, Jadiel! Quero fazer este pedido na HOST LOJA:\n\n'+lines.join('\n')+'\n\nPode me informar o valor final e como concluir o pagamento?';window.open('https://t.me/JADIEL_TM?text='+encodeURIComponent(msg),'_blank','noopener,noreferrer')});document.addEventListener('keydown',e=>{if(e.key==='Escape')closeCart()});renderProducts();renderCart();if(window.gsap&&!matchMedia('(prefers-reduced-motion: reduce)').matches){gsap.from('.hero-copy > *',{y:24,opacity:0,duration:.8,stagger:.12,ease:'power3.out',delay:.12});gsap.from('.visual-card',{scale:.82,rotation:-12,opacity:0,duration:1.1,ease:'back.out(1.5)',delay:.3});gsap.to('.chip-one',{y:-10,duration:2.4,repeat:-1,yoyo:true,ease:'sine.inOut'});gsap.to('.chip-two',{y:9,duration:2.8,repeat:-1,yoyo:true,ease:'sine.inOut'});gsap.to('.orbit-two',{rotation:360,duration:38,repeat:-1,ease:'none'})}})();

/* Motion interactions: reveal, pointer spotlight, magnetic buttons and ripple */
(()=>{
 'use strict';
 const reduced=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
 const finePointer=window.matchMedia&&window.matchMedia('(hover: hover) and (pointer: fine)').matches;
 const revealTargets=document.querySelectorAll('.section-top,.product-card,.support-band,.partners-label,.hero-note');
 if(!reduced&&'IntersectionObserver'in window){
   document.body.classList.add('reveal-ready');
   const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{
     if(entry.isIntersecting){entry.target.classList.add('is-visible');observer.unobserve(entry.target)}
   }),{threshold:.12,rootMargin:'0px 0px -35px 0px'});
   revealTargets.forEach((el,i)=>{el.classList.add('reveal-item');el.style.transitionDelay=(i%3)*75+'ms';observer.observe(el)});
 }
 if(finePointer&&!reduced){
   document.querySelectorAll('.product-card').forEach(card=>{
     card.addEventListener('pointermove',e=>{
       const r=card.getBoundingClientRect();
       card.style.setProperty('--pointer-x',(e.clientX-r.left)+'px');
       card.style.setProperty('--pointer-y',(e.clientY-r.top)+'px');
     },{passive:true});
   });
   document.querySelectorAll('.button-main,.button-quiet,.add-cart,.cart-open,.support-band>a').forEach(el=>{
     el.classList.add('magnetic');
     el.addEventListener('pointermove',e=>{
       const r=el.getBoundingClientRect(),dx=e.clientX-(r.left+r.width/2),dy=e.clientY-(r.top+r.height/2);
       el.style.transform='translate('+Math.max(-5,Math.min(5,dx*.10))+'px,'+Math.max(-5,Math.min(5,dy*.10))+'px)';
     },{passive:true});
     el.addEventListener('pointerleave',()=>{el.style.transform=''});
   });
 }
 document.addEventListener('click',e=>{
   const target=e.target.closest('.button-main,.add-cart,.checkout,.cart-open,.support-band>a');
   if(!target||reduced)return;
   const r=target.getBoundingClientRect(),size=Math.max(r.width,r.height),wave=document.createElement('span');
   wave.className='ripple';wave.style.width=wave.style.height=size+'px';
   wave.style.left=(e.clientX-r.left-size/2)+'px';wave.style.top=(e.clientY-r.top-size/2)+'px';
   target.appendChild(wave);wave.addEventListener('animationend',()=>wave.remove(),{once:true});
 });
})();
