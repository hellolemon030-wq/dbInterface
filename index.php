<?php

use Zjk\DbInterface\DbInterface;
use Zjk\DbInterface\PdoDb;

include __DIR__ . "/vendor/autoload.php";

echo PdoDb::class;
echo DbInterface::class;