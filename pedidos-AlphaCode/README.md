# Sistema de Pedidos AlphaCode

Sistema de gerenciamento de pedidos desenvolvido com Laravel 10 e Bootstrap 5.

## Screenshots

### Tela de Login
![Tela de Login](https://images-pinheiro.s3.us-east-2.amazonaws.com/Tela_Login.png)

### Tela de Cadastro
![Tela de Cadastro](https://images-pinheiro.s3.us-east-2.amazonaws.com/tela_cadastro.png)

### Dashboard
![Dashboard](https://images-pinheiro.s3.us-east-2.amazonaws.com/Tela_Dashboard.png)

### Painel Principal
![Painel Principal](https://images-pinheiro.s3.us-east-2.amazonaws.com/Tela_Painel.png)

### Gestão de Pedidos
![Gestão de Pedidos](https://images-pinheiro.s3.us-east-2.amazonaws.com/Tela_Pedidos.png)

### Gestão de Clientes
![Gestão de Clientes](https://images-pinheiro.s3.us-east-2.amazonaws.com/Tela_Clientes.png)

### Gestão de Produtos
![Gestão de Produtos](https://images-pinheiro.s3.us-east-2.amazonaws.com/Tela_Produtos.png)

## Requisitos

- PHP 8.1 ou superior
- Composer
- MySQL 5.7 ou superior
- Node.js e NPM (para assets)

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/pedidos-AlphaCode.git
cd pedidos-AlphaCode
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

4. Configure o banco de dados no arquivo `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pedidos_alphacode
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. Gere a chave da aplicação:
```bash
php artisan key:generate
```

6. Execute as migrações:
```bash
php artisan migrate
```

7. Instale as dependências do Node.js e compile os assets:
```bash
npm install
npm run dev
```

8. Inicie o servidor:
```bash
php artisan serve
```

## Funcionalidades

- Autenticação de usuários
- Gestão de clientes
- Gestão de produtos
- Gestão de pedidos
- Dashboard com estatísticas
- Relatórios

## Tecnologias Utilizadas

- Laravel 10
- Bootstrap 5
- MySQL
- Chart.js
- Font Awesome

## Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova feature'`)
4. Push para a branch (`git push origin feature/nova-feature`)
5. Abra um Pull Request

## Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

