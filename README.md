# Dorm Finder – เว็บค้นหาหอพัก

โปรเจกต์ฝึกงานตำแหน่ง Developer: HTML, CSS, PHP, TypeScript

## ฟีเจอร์
- ค้นหาตามชื่อ/ย่าน กรองตามราคาและสิ่งอำนวยความสะดวก (live search ด้วย TypeScript)
- หน้ารายละเอียดหอพัก
- หลังบ้านแอดมิน: เข้าสู่ระบบ, เพิ่ม/แก้ไข/ลบหอพัก (CRUD) พร้อม CSRF token

## ข้อกำหนดของระบบ

- **PHP 8.0 ขึ้นไป** (ทดสอบกับ PHP 8.3)
- PHP extension **`pdo_sqlite`** และ **`sqlite3`** (ตรวจสอบ: `php -m` แล้วดูว่ามีสองชื่อนี้)
- ไม่ต้องใช้ MySQL, Node.js หรือ npm เพราะไฟล์ JavaScript ที่คอมไพล์แล้วรวมอยู่ในโปรเจกต์

## วิธีรัน

1. โหลดโปรเจกต์ (**Code > Download ZIP** แล้วแตกไฟล์) หรือ `git clone <ลิงก์ repo>`
2. เปิดเทอร์มินัลในโฟลเดอร์โปรเจกต์ (โฟลเดอร์ที่มี `public` และ `src`)
3. รันเซิร์ฟเวอร์

   ```
   php -S localhost:8000 -t public
   ```

4. เปิด http://localhost:8000
5. หลังบ้านแอดมิน: http://localhost:8000/admin/ (ตั้งชื่อผู้ใช้และรหัสผ่านที่ `src/auth.php`)

ฐานข้อมูล SQLite และข้อมูลตัวอย่างจะถูกสร้างอัตโนมัติที่ `data/dorm.sqlite` เมื่อเปิดเว็บครั้งแรก

## แก้ปัญหาที่พบบ่อย

| อาการ | วิธีแก้ |
|---|---|
| `php` is not recognized | ยังไม่ได้ติดตั้ง PHP หรือยังไม่ได้เปิดเทอร์มินัลใหม่ ติดตั้ง: Windows `winget install PHP.PHP.8.3`, Mac `brew install php`, Ubuntu `sudo apt install php-cli php-sqlite3` |
| `could not find driver` | PHP ยังไม่เปิด SQLite ให้เปิด `extension=pdo_sqlite` และ `extension=sqlite3` ใน `php.ini` (Windows: ถ้ายังไม่มีไฟล์ให้คัดลอกจาก `php.ini-development`) แล้วเช็กด้วย `php --ini` |
| `Address already in use` | พอร์ต 8000 ถูกใช้อยู่ ลองพอร์ตอื่น เช่น `php -S localhost:8080 -t public` |
| ค้นหาไม่อัปเดตทันที | ลองรีเฟรชหน้าแบบ Ctrl+F5 |
| อยากรีเซ็ตข้อมูล | หยุดเซิร์ฟเวอร์ (Ctrl+C) ลบไฟล์ `data/dorm.sqlite` แล้วรันใหม่ |

## สำหรับผู้พัฒนา (แก้โค้ด TypeScript)

แก้ไฟล์ `src/ts/search.ts` แล้วต้องคอมไพล์ใหม่ (ต้องมี Node.js)

```bash
npm i -g typescript
tsc -p .
```

## โครงสร้าง
- `public/` หน้าเว็บ (index, dorm, api, admin/)
- `src/` โค้ด PHP (db, search, auth) และ `src/ts/` โค้ด TypeScript
- `data/` ไฟล์ฐานข้อมูล

## ไอเดียต่อยอด
อัปโหลดรูป, แผนที่, รีวิว, แบ่งหน้า (pagination), เปลี่ยนเป็น MySQL, hash รหัสผ่านด้วย `password_hash`
