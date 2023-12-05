# Image library

## Start project

```bash
docker-compose up -d
```
Create .env from .env.dis:
```bash
cp .env.dist .env
```
Install dependencies:
```bash
docker exec imaging composer install
```

Create database schema:
```bash
docker exec imaging php bin/console doctrine:schema:create
```

## Usage
Register user:
```
http://localhost:8005/register
```
Login user:
```
http://localhost:8005/login
```
Get API token with registered username and password:
```
curl --location --request POST 'localhost:8005/api/login_check' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username": "username",
    "password": "password"
}'
```
Upload image:
```
curl --location --request POST 'localhost:8005/api/upload' \
--header 'Authorization: Bearer ey...-4w' \
--header 'Content-Type;' \
--form 'image=@"/home/name/images/image.png"'
```
