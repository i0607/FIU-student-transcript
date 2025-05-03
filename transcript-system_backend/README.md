# FIU Student Transcript Management System

A full-stack web application for managing and viewing student transcripts, including features such as login authentication, course categorization, GPA calculation, and export options.

## Features

### 🔐 Authentication & Authorization
- Role-based login (Admin / Staff)
- Token-based API access using Laravel Sanctum

### 📄 Student Transcript Retrieval
- Search student by number
- Display per-semester courses and GPA
- Highlight passed/failed courses
- GPA and cumulative GPA shown

### 📚 Curriculum & Remaining Courses
- Curriculum matched by department
- Show taken and remaining courses
- Color-coded by category (FC, AC, AE, etc.)

### 📊 Admin Panel
- Create/edit/delete staff users
- Protected by role-based access control

### 📥 Export Options
- Export transcript to PDF or Excel

---

## 🛠 Tech Stack

### Backend
- Laravel 8.0
- Sanctum for API auth
- MySQL
- DomPDF (PDF export)
- Laravel Excel (XLSX export)

### Frontend
- React (CRA)
- Axios
- Material UI

---

## 🧱 Database Schema Overview

- `students`: Student details (name, department, etc.)
- `courses`: Curriculum courses with department & semester
- `transcripts`: Pivot table (student_id, course_id, grade)
- `users`: Staff/Admin users

---

## 🚀 Getting Started

### Backend Setup

```bash
cd transcript-system_backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

> Make sure you have MySQL running and `.env` properly configured.

### Frontend Setup

```bash
cd transcript-system-frontend
npm install
npm start
```

---

## 🔑 Sample Login Credentials

| Role   | Email            | Password  |
|--------|------------------|-----------|
| Admin  | admin@fiu.edu    | admin123  |
| Staff  | staff@fiu.edu    | staff123  |

---

## 📄 License

MIT License. See `LICENSE.md` for details.
