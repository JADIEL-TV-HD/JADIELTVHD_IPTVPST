# HOST LOJA

Loja virtual em PHP + JSON, preparada para hospedagem compartilhada como InfinityFree. Não utiliza MySQL.

## Instalação

1. Envie todos os arquivos e pastas para `htdocs`, mantendo `index.php` na raiz.
2. Confirme que PHP está habilitado e que a pasta `data` permite gravação pelo PHP.
3. Abra `gestor.php` para acessar o painel administrativo.
4. Cadastre, ajuste ou remova os produtos pelo gestor. O catálogo fica em `data/products.json`.

## Recursos

- Catálogo inicial com acesso HOST MB de 15 dias, acesso de 30 dias e compra de chave KEY.
- Carrinho com quantidades e pedido encaminhado para `https://t.me/JADIEL_TM`.
- Gestor separado com senha validada no servidor, hash `password_hash`, sessão `HttpOnly`/`SameSite`, token CSRF e limite de tentativas por sessão.
- Dados salvos em JSON, sem banco MySQL.

Os preços iniciais estão como zero porque os valores não foram informados; por isso, a vitrine mostra “Consulte”. Para usar um preço definido, remova o item inicial no gestor e cadastre-o novamente com o valor correto. O pedido é encaminhado ao Telegram para combinar pagamento; não há processamento automático de pagamentos.

A senha administrativa não fica no HTML ou JavaScript. O servidor guarda somente um hash. Nenhum sistema pode tornar uma requisição invisível a ferramentas de inspeção do navegador ou a uma captura feita no próprio dispositivo; use HTTPS para proteger os dados durante o transporte.
