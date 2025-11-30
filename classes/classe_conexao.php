<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

class Database
{
    private $pdo;

    public function __construct()
    {
        $host     = $_ENV['DB_HOST'];
        $usuario  = $_ENV['DB_USER'];
        $senha    = $_ENV['DB_PASS'];
        $banco    = $_ENV['DB_NAME'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getRegistro($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    public function getRegistros($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function incluir($tabela, $dados)
    {
        $campos = implode(",", array_keys($dados));
        $placeholders = implode(",", array_fill(0, count($dados), "?"));

        $sql = "INSERT INTO {$tabela} ({$campos}) VALUES ({$placeholders})";
        $this->query($sql, array_values($dados));

        return $this->pdo->lastInsertId();
    }

    public function alterar($tabela, $dados, $where)
    {
        $set = implode(" = ?, ", array_keys($dados)) . " = ?";
        $sql = "UPDATE {$tabela} SET {$set} WHERE {$where}";
        return $this->query($sql, array_values($dados));
    }

    public function excluir($tabela, $where)
    {
        $sql = "DELETE FROM {$tabela} WHERE {$where}";
        return $this->query($sql);
    }
}