<?php
session_start();
// รหัสผ่านแอดมิน (ตัวอย่าง) — ควรเปลี่ยนก่อนใช้งานจริง
const ADMIN_USER = 'pucow';
const ADMIN_PASS_HASH_PLAIN = 'pucow1234';

function is_admin(): bool { return !empty($_SESSION['admin']); }
function require_admin(): void {
    if (!is_admin()) { header('Location: login.php'); exit; }
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function check_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(400); exit('CSRF token ไม่ถูกต้อง');
    }
}
