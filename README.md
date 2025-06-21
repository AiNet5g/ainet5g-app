// 🧠 AI NET 5G+ | ระบบแอปแบบสมบูรณ์ Flutter ทุกแพลตฟอร์ม

// 📦 โครงสร้างหลักของระบบ Flutter | Flutter App Main Structure
lib/
├── main.dart                         // Entry point ของแอป | App entry point
├── routes.dart                       // เส้นทางระหว่างหน้า (User / Admin / Host) | Routing between screens
├── app_config.dart                   // ค่าคงที่ / โดเมน / API URL | Constants / domain / API URLs
├── themes/app_theme.dart             // ธีมสี Gradient 3D | 3D Gradient theme
├── .env.example                      // ตัวอย่าง environment สำหรับ Dev วาง API Key | Example environment for dev

// 🔐 ส่วน Login และ Auth | Login & Auth
├── auth/
│   ├── login_screen.dart             // หน้าล็อกอิน (Google / Facebook / LINE) | Login screen
│   ├── register_screen.dart          // ลงทะเบียน (ถ้าจำเป็น) | Registration screen (if needed)
│   └── auth_service.dart             // เชื่อมต่อ API Login / Token | API login connector

// 📱 สำหรับ User ทั่วไป | For General Users
├── user/
│   ├── dashboard_screen.dart         // หน้าหลักของผู้ใช้งาน | Main user dashboard
│   ├── server_list.dart              // แสดงเซิร์ฟเวอร์ที่พร้อมเชื่อม | Server selection
│   ├── subscription_screen.dart      // แพ็กเกจ / ต่ออายุ / จ่ายเงิน (เฉพาะรายเดือนเท่านั้น) | Monthly subscriptions only
│   ├── revenue_screen.dart           // รายได้ของ User ที่แชร์ลิงก์ / แชร์ WiFi | Referral/WiFi revenue
│   ├── usage_history.dart            // ประวัติการใช้งาน / แพ็กเกจที่ซื้อ / วันหมดอายุ | Usage and history
│   └── user_api.dart                 // API สำหรับฝั่ง User | User-side APIs
│   └── connect_screen.dart           // ✅ Flutter UI จริงสำหรับหน้าเชื่อมต่อ | Real Flutter Connect UI

// 📡 สำหรับ Host (มือถือที่ปล่อยเน็ต) | For Hosts (Internet sharers)
├── host/
│   ├── host_dashboard.dart           // หน้าควบคุมการปล่อยเน็ต | Network sharing control
│   ├── host_metrics.dart             // ความเร็ว, จำนวน user ที่รับเน็ต | Speed, client count
│   ├── host_vpn_config.dart          // ดึง config VPN และเชื่อมเซิร์ฟเวอร์ | VPN Config & Connect
│   └── host_api.dart                 // API สำหรับฝั่ง Host | Host APIs

// 🧠 ฝั่ง Admin (Web/Desktop) | Admin (Web/Desktop)
├── admin/
│   ├── admin_dashboard.dart          // หน้ารวมสถิติ | Dashboard overview
│   ├── manage_hosts.dart             // จัดการ Host | Manage Hosts
│   ├── manage_packages.dart          // แพ็กเกจรายวัน/เดือน/ปี | Manage all package types
│   ├── manage_users.dart             // จัดการผู้ใช้ | Manage users
│   ├── manage_ai.dart                // ตั้งค่า AI Key (GPT) | AI Configs
│   ├── manage_revenue.dart           // รายได้ทั่วไป/โรงแรม | General vs Business Revenue
│   ├── manage_clients.dart           // จัดการลูกค้าโรงแรม | Business Clients
│   ├── manage_access_roles.dart      // สิทธิ์การเข้าถึงตามหมวด | Role-Based Access Control
│   ├── api_docs.dart                 // Swagger / Redoc UI + JSON | Full API Docs
│   └── admin_api.dart                // API สำหรับ Admin ครบฟีเจอร์ | Full Admin APIs

// 🌐 ส่วนแชร์ข้ามแพลตฟอร์ม | Cross-platform
├── components/                      // UI ร่วมใช้ | Shared Components
├── models/                          // โครงสร้างข้อมูล | Data Models
├── services/                        // ระบบเชื่อมต่อ API | API Services
├── widgets/                         // วิดเจ็ตพิเศษ | Special Widgets
├── mocks/                           // Mock สำหรับ Dev/Test | Dev/Test Mocks
├── i18n/                            // ไฟล์แปลข้อความ (TH/EN) | Translation Files (TH/EN)
└── test/                            // Unit / Integration Test เบื้องต้น | Unit / Integration Tests

// ✅ README.md พร้อม | README Includes:
// - สรุปโครงสร้างระบบทั้งหมด (Flowchart) | Full System Flowchart
// - รายละเอียดของหน้าทุกจุดในระบบ (UI Mapping) | UI Screen Mapping
// - การใช้งานระบบจากมุมมอง Dev + Admin + User | Usage by Roles
// - วิธี Deploy + Setup Environment + API Key แบบปลอดภัย | Secure Deployment Guide
// - เชื่อม Swagger / Redoc สำหรับ Docs API ทั้งหมด | Full API Docs
// - แนบตัวอย่าง API JSON และ Mockup UI ทุกหน้าจอแบบ Preview | Sample APIs + UI Mockups
// - เอกสารภาษาอังกฤษแยกต่างหาก | English Documentation Included

// ✅ หมายเหตุเพิ่มเติม (ต้องห้าม) | Important Notes
// - ห้ามใช้คำว่า "VPN" แสดงต่อผู้ใช้ทั่วไป | Never use the word "VPN" for general users
// - ห้ามแสดง IP, port หรือ config แบบ raw ต่อผู้ใช้งานทั่วไป | Never expose raw config/IP
// - ห้ามให้ผู้ใช้เลือก protocol หรือปรับ config VPN เอง | No user-side VPN config
// - สัญญาณที่เชื่อมสำเร็จต้องแสดงว่า "AI NET 5G+" | Final signal name must show "AI NET 5G+"
// - ทุกแพลตฟอร์มต้องติดตั้งแบบระบบปิด | Closed sideload install only
// - ระบบต้องใช้ Server หลักที่ติดตั้งไว้ใน Vultr | Vultr is mandatory
// - ต้องมีระบบ Usage Logging และ History สำหรับดูย้อนหลัง | Required detailed logging
