<?php
    $pdo = new PDO('mysql:host=localhost;dbname=jokes;charset=utf8','chicken','kokoko');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
