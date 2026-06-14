<?php

require __DIR__ . '/../vendor/autoload.php';

use Zjk\DbInterface\PdoDb;

$sqlHost = '127.0.0.1';;
$sqlUser = 'root';
$sqlPassword = '';
$sqlDbName = 'test';

$pdo = new PDO(
    "mysql:host={$sqlHost};dbname={$sqlDbName};charset=utf8mb4",
    "{$sqlUser}",
    "{$sqlPassword}",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
);

$db = new PdoDb($pdo);

successLog("create table test_user");

$db->execute("DROP TABLE IF EXISTS test_user");

$db->execute("
    CREATE TABLE IF NOT EXISTS test_user (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100)
    )
");

successLog("insert into test_user");


$db->execute(
    "INSERT INTO test_user(name) VALUES(?)",
    ['testUserName']
);

$id = $db->lastInsertId();

echo "insert id: {$id}\n";


successLog("fetch from test_user");

$row = $db->fetch(
    "SELECT * FROM test_user WHERE id = ?",
    [$id]
);

var_dump($row);

successLog("fetchAll from test_user");

$rows = $db->fetchAll(
    "SELECT * FROM test_user"
);

var_dump($rows);

successLog("fetchValue from test_user");


$count = $db->fetchValue(
    "SELECT COUNT(*) FROM test_user"
);

var_dump($count);

successLog("transaction commit");

$db->transaction(function ($db) {
    $db->execute(
        "INSERT INTO test_user(name) VALUES(?)",
        ['transcationTest']
    );
});

successLog("transaction rollback");

$count = $db->fetchValue(
    "SELECT COUNT(*) FROM test_user"
);

echo "user count = {$count}\n";

try {
    $db->transaction(function ($db) {
        $db->execute(
            "INSERT INTO test_user(name) VALUES(?)",
            ['rollbackTest']
        );

        throw new Exception('test rollback');
    });
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

$count = $db->fetchValue(
    "SELECT COUNT(*) FROM test_user"
);

echo "user count = {$count}\n";

successLog("ddl test");



try {
    $db->begin();

    $db->execute("
        CREATE TABLE IF NOT EXISTS test_ddl (
            id INT PRIMARY KEY AUTO_INCREMENT
        )
    ");

    echo "inTransaction: ";
    var_dump($db->inTransaction());

    $db->commit();

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo "=== done ===\n";



function successLog($msg){
    echo "\033[32msuccess: {$msg}\033[0m\n";
}