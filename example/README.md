# Oxws example

## Crie a estrutura básica

Copie **/public** e **/app** para **/project_home**

    /project_home
    ├── /public
    │   ├── index.php
    │   └── router.php
    ├── /app
    │   ├── controllers
    │   │   └── index.php
    │   └── views
    │       └── index.php
    └── /vendor
        ├── composer
        └── oxsys

## Inicie o servidor

Inicie o PHP Standalone Server

    $ cd project_home
    $ php -S localhost:8080 -t public public/router.php

## Comece a codificar

- Leia a documentação em http://oxws.oxsys.com.br/documentacao
- Crie e altere os arquivos em **/public** e **/app**
- Acompanhe as mudanças em http://localhost:8080

## Licença

Licença GPL-3.0 <https://github.com/ddiasweb/oxws/blob/master/LICENSE>

Copyright (C) 2016 Oxsys <http://oxsys.com.br/>
