# 🚀 ChatBot utilizando n8n

Este repositório trata de como fazer um ChatBot n8n simples utilizando workflows n8n e uma api simples em php.

---

## 📋 Pré-requisitos 

Antes de começar, certifique-se de que seu servidor atende aos seguintes requisitos:

- **Docker** e **Docker Compose** instalados  
    Consulte a [documentação oficial do Docker](https://docs.docker.com/get-docker/) para instruções de instalação.
- **Firewall**  
    A porta que o N8N usará (padrão `5678`) deve estar aberta.
- **Diretório do Projeto**  
    Crie uma pasta para a instalação do N8N, por exemplo: `/opt/n8n/`.

---

## 🛠️ Passo 1: Criação dos Arquivos de Configuração

No diretório do projeto, crie dois arquivos: `.env` (credenciais) e `docker-compose.yml` (configuração dos serviços).

### 📁 Arquivo `.env`

Armazene suas credenciais de forma segura. **Nunca compartilhe este arquivo em repositórios públicos!**

```env
# Credenciais de acesso ao N8N
N8N_BASIC_AUTH_USER=seu_usuario_n8n
N8N_BASIC_AUTH_PASSWORD=sua_senha_n8n_producao

# Configuração do Banco de Dados MySQL
DB_TYPE=mysql
DB_MYSQL_HOST=mysql
DB_MYSQL_DATABASE=n8n
DB_MYSQL_USER=n8n_user
DB_MYSQL_PASSWORD=sua_senha_de_usuario_segura

# Variáveis do MySQL
MYSQL_ROOT_PASSWORD=sua_senha_root_segura
MYSQL_DATABASE=n8n
MYSQL_USER=n8n_user
MYSQL_PASSWORD=sua_senha_de_usuario_segura
```

---

### 🐳 Arquivo `docker-compose.yml`

Define os serviços do N8N e do MySQL, garantindo comunicação e persistência de dados.

```yaml
version: '3.8'

services:
    n8n:
        image: n8nio/n8n
        container_name: n8n
        restart: always
        ports:
            - 5678:5678
        environment:
            - DB_TYPE=${DB_TYPE}
            - DB_MYSQL_HOST=${DB_MYSQL_HOST}
            - DB_MYSQL_DATABASE=${DB_MYSQL_DATABASE}
            - DB_MYSQL_USER=${DB_MYSQL_USER}
            - DB_MYSQL_PASSWORD=${DB_MYSQL_PASSWORD}
            - N8N_BASIC_AUTH_ACTIVE=true
            - N8N_BASIC_AUTH_USER=${N8N_BASIC_AUTH_USER}
            - N8N_BASIC_AUTH_PASSWORD=${N8N_BASIC_AUTH_PASSWORD}
        env_file: .env
        volumes:
            - /caminho/para/o/seu/diretorio/.n8n:/home/node/.n8n
        depends_on:
            - mysql

    mysql:
        image: mysql:8.0
        container_name: mysql
        restart: always
        environment:
            - MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
            - MYSQL_DATABASE=${MYSQL_DATABASE}
            - MYSQL_USER=${MYSQL_USER}
            - MYSQL_PASSWORD=${MYSQL_PASSWORD}
        volumes:
            - mysql_data:/var/lib/mysql
        env_file: .env

volumes:
    mysql_data:
```

---

## ▶️ Passo 2: Executando a Instalação

No terminal, dentro do diretório `docker/`, execute:

```bash
docker compose up -d
```

O Docker irá baixar as imagens, criar os volumes e iniciar os containers.

---

## 🌐 Passo 3: Acessando o Painel do N8N

Após a execução, acesse o painel do N8N:

```
http://<IP_DO_SEU_SERVIDOR>:5678
```

Você será solicitado a inserir o usuário e senha definidos no arquivo `.env`.

---

## ⚠️ Considerações Importantes para Produção

- **🔒 Segurança:**  
    Nunca use senhas padrão ou fracas. Proteja o arquivo `.env` e não o compartilhe.
- **🔐 HTTPS:**  
    Utilize HTTPS para proteger suas automações. O ideal é usar um proxy reverso (Nginx, Caddy, etc.) para gerenciar certificados SSL/TLS.
- **📈 Monitoramento:**  
    Ferramentas como Prometheus e Grafana são recomendadas para monitorar o desempenho dos containers.

---

ChatBot simples utilizando n8n como automação e um pequeno back-end em php! 🚀