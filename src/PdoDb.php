<?php
namespace Zjk\DbInterface;

use Exception;
use PDO;

class PdoDb implements DBInterface
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function execute($sql, array $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function fetch($sql, array $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res : null;
    }

    public function fetchAll($sql, array $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchValue($sql, array $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function transaction(callable $callback)
    {
        $this->begin();
        try {
            $result = call_user_func($callback, $this);
            $this->commit();
            return $result;
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function begin()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollback()
    {
        $this->pdo->rollBack();
    }
}
