# Smit Prajapati — Practical 15

**Course:** ITUE203 — Web Development Frameworks  
**Project:** Smit Campus Portal  
**Student:** Smit Prajapati  
**Folder:** `practical15`  
**Database:** `practical15`

## Run locally with XAMPP
1. Copy the `practical15` folder into `C:\xampp\htdocs\`.
2. Open XAMPP Control Panel and start **Apache** and **MySQL**.
3. Open `http://localhost/phpmyadmin`.
4. Select **Import**, choose `practical15/schema.sql`, and click **Import/Go**. The script creates and selects the `practical15` database.
5. Confirm `db.php` uses database `practical15`, username `root`, and an empty password if that matches your local XAMPP setup.
6. Open `http://localhost/practical15/`.

## Project features
- Responsive campus portal interface with Midnight Campus styling
- Registration and login
- Student and admin dashboards
- Courses, events, notices, attendance and contact messages
- Event registration and CSV export
- PHP + MySQL database schema

## Admin setup
Register an account through the website first. Then, in phpMyAdmin, select database `practical15` and run the following query with the email you registered:

```sql
UPDATE users SET role = 'admin' WHERE email = 'YOUR_REGISTERED_EMAIL';
```

Replace `YOUR_REGISTERED_EMAIL` with your actual registered email. Do not share your password.

## Important
Run PHP pages through `http://localhost/practical15/`, not by opening them directly from File Explorer. Test each form and role before submission.
