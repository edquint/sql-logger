📄 Read this documentation in [English 🇺🇸](README.md)

# PHP SQL Logger

Uma biblioteca simples para gerar logs de queries SQL e gravar em arquivos de log.  
Útil para inspecionar como as queries estão sendo montadas, seja utilizando **ORMs** como **Doctrine 1**, **Doctrine 2** e **Eloquent**, ou queries **raw** (puras).

## 📦 Instalação

Adicione a biblioteca ao seu projeto via Composer:

```bash
composer require edquint/sql-logger
```

## 🚀 Recursos

* Captura queries geradas automaticamente por ORMs populares.
* Suporte para queries **raw**.
* Salva logs em arquivos de forma configurável.
* Fácil integração em projetos PHP.

#### ORMs suportados

- Doctrine 1
- Doctrine 2
- Eloquent

## ⚙️ Configuração

A configuração é feita através da classe **`LoggerConfig`**, onde você define:

* Diretório para os arquivos de log.
* Nome do arquivo de log.
* Opções adicionais.

Exemplo:

```php
use SqlLogger\Settings\LoggerConfig;

LoggerConfig::setLogPath(__DIR__ . '/logs'); // Caminho onde os logs serão salvos
LoggerConfig::setFileName('queries.log');    // Nome do arquivo de log
```

## ✅ Como Usar

A classe principal para gerar os logs é **`LogSql`**.

### 1. Logando queries de ORMs

Se estiver utilizando um ORM suportado, basta passar a instância da query para o método `orm`:

```php
use SqlLogger\LogSql;

// Exemplo com uma query de ORM (Doctrine, Eloquent, etc.)
LogSql::orm($query);
```

Isso irá converter a query para uma string formatada e salvar no arquivo configurado.

---

### 2. Logando queries RAW (manuais)

Para queries SQL manuais, basta passar a query e os parâmetros para o método `raw`:

```php
use SqlLogger\LogSql;

$params = ['id' => 10];
$sql = "SELECT * FROM users WHERE id = :id";

LogSql::raw($sql, $params);
```

## 🔍 Saída do Log

O log será salvo no diretório configurado, no formato:

```
[2025-08-02 19:00:00] Sql Query:
SELECT
  *
FROM
  users
WHERE
  id = 10
```

---

### 📄 Licença

Este projeto está licenciado sob a licença **MIT**.
Você pode ver o conteúdo completo da licença no arquivo [`LICENSE`](./LICENSE).
