<?php
require_once __DIR__ . '/db.php';

// ค้นหาหอพักตามเงื่อนไข ใช้ prepared statement กัน SQL injection
function search_dorms(array $q): array {
    $sql = 'SELECT * FROM dorms WHERE 1=1';
    $p = [];
    if (!empty($q['q'])) {
        $sql .= ' AND (name LIKE :q OR area LIKE :q)';
        $p[':q'] = '%' . $q['q'] . '%';
    }
    if (!empty($q['max_price'])) {
        $sql .= ' AND price <= :max';
        $p[':max'] = (int)$q['max_price'];
    }
    foreach (['has_wifi', 'has_aircon', 'has_parking'] as $f) {
        if (!empty($q[$f])) $sql .= " AND $f = 1";
    }
    $sql .= ' ORDER BY price ASC';
    $st = db()->prepare($sql);
    $st->execute($p);
    return $st->fetchAll();
}
