<?php
require_once __DIR__ . '/../src/search.php';
header('Content-Type: application/json; charset=utf-8');
echo json_encode(search_dorms($_GET), JSON_UNESCAPED_UNICODE);
