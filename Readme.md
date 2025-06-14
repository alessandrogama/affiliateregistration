#  Sistema de Cadastro de Afiliados

Este projeto tem como objetivo facilitar o cadastro e a gestão de afiliados em um modelo de comissões multinível. Ele foi desenvolvido utilizando Laravel no backend, Vue.js no frontend e MySQL como banco de dados — tudo isso containerizado com Docker para facilitar a configuração e o ambiente de desenvolvimento.

---

##  Tecnologias Utilizadas

- **Laravel 10** (PHP)
- **Vue.js 3** 
- **MySQL 8**
- **Docker**
- **Adminer** 

---

##  Pré-requisitos

Antes de começar, é importante garantir que você tenha os seguintes softwares instalados na máquina:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)

---

##  Subindo o Projeto

Aqui está o passo a passo para colocar tudo para rodar:

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 2. Suba os containers
```bash
docker-compose up -d --build
```
Aguarde o Docker construir e subir os serviços. Isso pode levar alguns minutos na primeira vez.

##  Configurando o Backend (Laravel)
### 3. Acesse o container do PHP
```bash
docker exec -it php_backend bash
```
### 4. Dentro do container, rode os comandos:
```bash
composer install
cp .env.example .env
php artisan key:generate
```
### 5. Configure o banco de dados no .env

Garanta que estas variáveis estejam corretas:

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=afiliados
DB_USERNAME=userAfiliadoDB
DB_PASSWORD=userAfiliadoDB123
```
### 6. Rode as migrations e seeders
```bash
php artisan migrate --seed
```
Esse comando vai criar as tabelas necessárias e popular o banco com alguns afiliados iniciais para facilitar os testes.

##  Frontend
O frontend é uma aplicação Vue 3 que já está configurada para rodar no container. Assim que você sobe os containers, ela fica disponível em:
```bash
http://localhost
```
Configurando a API entre o BackEnd e o FrontEnd:

```bash
cp .env.development .env

VUE_APP_BASE_API_URL='http://localhost:8000'
```
Lá você vai encontrar o formulário de cadastro de afiliados.

Os referenciadores são carregados dinamicamente via API.

##  API disponível

A API pode ser testada com ferramentas como Postman ou diretamente pelo frontend.

Alguns endpoints úteis:
```bash
GET /api/affiliates — Lista todos os afiliados

GET /api/affiliates/{id} — Detalha um afiliado específico

POST /api/cadastroafiliado — Cadastra um novo afiliado com referenciadores
```
##  Acesso ao banco de dados

Para facilitar a visualização e edição do banco, o projeto inclui o Adminer.

Basta acessar:

```bash
http://localhost:8081

E preencher os campos assim:

Servidor: db

Usuário: userAfiliadoDB

Senha: userAfiliadoDB123

Banco: afiliados
```
## 🔄 Comandos úteis

Reiniciar o projeto do zero (útil após grandes mudanças):

```bash
docker-compose down -v
docker-compose up --build
```
Ver os logs do backend:

```bash
docker logs -f php_backend
```