# Dorm Finder – เว็บค้นหาหอพัก

โปรเจกต์ฝึกงานตำแหน่ง Developer: HTML, CSS, PHP, TypeScript

## ฟีเจอร์
- ค้นหาตามชื่อ/ย่าน กรองตามราคาและสิ่งอำนวยความสะดวก (live search ด้วย TypeScript)
- หน้ารายละเอียดหอพัก
- หลังบ้านแอดมิน: เข้าสู่ระบบ, เพิ่ม/แก้ไข/ลบหอพัก (CRUD) พร้อม CSRF token

## วิธีรัน
```bash
npm i -g typescript     # ครั้งแรก
tsc -p .                # คอมไพล์ TypeScript -> public/assets/js
php -S localhost:8000 -t public
```
เปิด http://localhost:8000  
แอดมิน: http://localhost:8000/admin/ (user `pucow` / pass `pucow1234` — ควรเปลี่ยนใน `src/auth.php`)

ฐานข้อมูล SQLite สร้างและใส่ข้อมูลตัวอย่างให้อัตโนมัติที่ `data/dorm.sqlite`

## โครงสร้าง
- `public/` หน้าเว็บ (index, dorm, api, admin/)
- `src/` โค้ด PHP (db, search, auth) และ `src/ts/` โค้ด TypeScript
- `data/` ไฟล์ฐานข้อมูล

## ไอเดียต่อยอด
อัปโหลดรูป, แผนที่, รีวิว, แบ่งหน้า (pagination), เปลี่ยนเป็น MySQL, hash รหัสผ่านด้วย `password_hash`
