<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre o Sistema MDF-e

Se trata de um simples sistema para emissão de MDF-e onde é possível:

- Encerrar MDF-e emitidos.
- Enviar novos MDF-e.
- Cancelar MDF-e.

Feito com o Framework Laravel com fácil manutenção.

## 🚀 Instalando 

Para instalar o <MDF-e Simples>, siga estas etapas:

Windows, Linux e macOS:
```
php composer install
```
Criando APP_KEY do Laravel
```
php artisan key:generate
```

Criando Banco de dados:
```
php artisan db:create
```
    
Criando tabelas:
```
php artisan migrate
```

Criando conteúdo do banco de dados:
```
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CidadeSeeder
```
## Usuário e Senha
```
Usuário: usuario@teste.com.br
Senha: 123
``` 
 
## Rodar Servidor
```
php artisan serve
``` 
## http://127.0.0.1:8000/
    
## Licença

Licença livre [MIT license](https://opensource.org/licenses/MIT).
