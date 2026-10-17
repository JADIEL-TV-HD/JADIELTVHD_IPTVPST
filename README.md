# Meu Arquivo — PHP para InfinityFree

Área privada de documentos com gestor e contas de usuário.

## Instalação
1. Envie todos os arquivos para a pasta pública do site no InfinityFree.
2. Confira se a hospedagem permite PHP e escrita em diretórios. O sistema cria `storage/data` e `storage/files` automaticamente.
3. Abra `gestor.php` e crie o primeiro gestor (senha de pelo menos 12 caracteres).
4. No gestor, crie os acessos. Usuários entram por `index.php`.

## Recursos
- Login de gestor e de usuário, senhas armazenadas com hash.
- Upload de documentos até 25 MB (limite sujeito à hospedagem).
- Arquivos privados: downloads exigem login e pertencem à conta.
- CSRF tokens, nomes de arquivo sanitizados, identificadores aleatórios, sessões regeneradas no login.
- Dados em JSON, sem MySQL.

## Segurança e limites
- O diretório `storage` contém `.htaccess` para negar acesso web direto. Teste isso após publicar; algumas configurações de servidor podem não aplicar regras de diretório.
- Defina senha forte para gestor, mantenha PHP e hospedagem atualizados e use HTTPS.
- Não envie executáveis, scripts, arquivos maliciosos ou documentos de origem desconhecida.
- InfinityFree pode impor limites menores de upload, armazenamento e processamento. Este projeto não promete proteção absoluta contra invasões.
- Faça backup periódico da pasta `storage`; ela contém usuários, metadados e arquivos.
