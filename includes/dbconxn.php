<?php
    // $pdo = new PDO('pgsql:host=postgres;dbname=jokes;options=\'--client_encoding=UTF8\'','user=postgres','password=postgres');
    $pdo = new PDO('pgsql:host=postgres;dbname=jokes;user=postgres;password=postgres;options=\'--client_encoding=UTF8\'');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
