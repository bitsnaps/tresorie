<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
<<<<<<< HEAD
$db['dsn'] = 'mysql:host=127.0.0.1:3306;dbname=yalitresoredb_test';
=======
$db['dsn'] = 'mysql:host=localhost;dbname=yalitresoredb_test';
>>>>>>> dev

return $db;
