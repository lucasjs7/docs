## Instalação docker

Criar os containers:
```
$ docker compose up -d
```

Iniciar os containers
```
$ docker compose start
```

Destruir os containers
```
$ docker compose down
```
Destruir os containers e o volume do banco de dados
```
$ docker compose down -v
```

## Configuração
Renomeie o arquivo `config-example.php` para `config.php`, feito isso, entre no arquivo e edite a constante `MYSQL_HOST` para o seu IPV4.