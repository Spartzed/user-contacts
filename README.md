# User Contacts

!GitHub repo size

## Descrição

O projeto **User Contacts** é uma aplicação para gerenciar contatos de usuários. Ele permite adicionar, editar, visualizar e excluir contatos de forma simples e eficiente, permitindo ver a localização através do Mapa da Google.

## Objetivo

O objetivo deste projeto é desenvolver uma aplicação web simples utilizando exclusivamente o framework Laravel, sem a integração de outros frameworks de frontend. A aplicação utiliza Blade para renderização de templates e uma API REST para comunicação com o backend. 

## Funcionalidades
- Criar um usuario
- Excluir o usuario
- Adicionar novos contatos
- Editar contatos existentes
- Visualizar detalhes dos contatos
- Excluir contatos
- Pesquisar contatos

## Tecnologias Utilizadas

- PHP 8.2
- Laravel 11
- SQLite

## Instalação

1. Clone o repositório:
    ```bash
    git clone https://github.com/Spartzed/user-contacts.git
    ```
2. Navegue até o diretório do projeto:
    ```bash
    cd user-contacts
    ```
3. Instale as dependências:
    ```bash
    npm install
    ```
4. Rode as migrations:
    ```bash
    php artisan migrate
    ```
5. Caso de erro ao rodar a migration:
    ```bash
    touch database/database.sqlite
    ```
6. Inicie o servidor:
    ```bash
    php artisan serve
    ```

## Uso

Após iniciar o servidor, acesse `http://localhost:3000` no seu navegador para utilizar a aplicação.

