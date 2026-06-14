<?php
namespace Zjk\DbInterface;

interface DBInterface
{
    /**
     * 执行 insert/update/delete
     * return: 影响行数
     */
    public function execute($sql, array $params = array());

    /**
     * 返回一行数据
     * return: array|null
     */
    public function fetch($sql, array $params = array());

    /**
     * 返回多行数据
     * return: array
     */
    public function fetchAll($sql, array $params = array());

    /**
     * 返回单个标量（COUNT / MAX / 某个字段）
     * return: mixed
     */
    public function fetchValue($sql, array $params = array());

    /**
     * 获取最后插入ID
     * return: string|int
     */
    public function lastInsertId();

    /**
     * 事务封装
     */
    public function transaction(callable $callback);

    public function begin();
    public function commit();
    public function rollback();
}