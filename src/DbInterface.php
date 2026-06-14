<?php
namespace Zjk\DbInterface;

interface DBInterface
{
    /**
     * insert/update/delete
     * @return int affectedRows
     */
    public function execute($sql, array $params = array());

    /**
     * fetchRow/fetchOne [fieldName=>value,...]
     * return: array|null
     */
    public function fetch($sql, array $params = array());

    /**
     * fetchAll [[fieldName=>value,...]]
     * return: array
     */
    public function fetchAll($sql, array $params = array());

    /**
     * fetchValue
     * return: mixed
     */
    public function fetchValue($sql, array $params = array());

    /**
     * return: string|int
     */
    public function lastInsertId();

    /**
     * transaction
     */
    public function transaction(callable $callback);

    public function begin();
    public function commit();
    public function rollback();
    public function inTransaction();
}