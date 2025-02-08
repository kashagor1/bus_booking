# NewBus - Bus Booking System (CodeIgniter 4)

## 📌 Project Overview

The **NewBus - Bus Booking System** is a web-based application built using **CodeIgniter 4** that allows users to book bus tickets online within Bangladesh. The system provides functionalities for managing bus multiple bus company, routes, coach, trips (schedules), seat reservations, seat cancellation, payments and refunds.

## 🚀 Features

- **User Authentication** (Login & Registration)
- **Bus Listings & Search**
- **Seat Selection & Booking**
- **Payment Integration**
- **Admin Dashboard for Bus & Booking Management**
- **Booking Confirmation & Ticket Generation**

## 🏗️ Tech Stack

- **Backend:** CodeIgniter 4 (PHP Framework)
- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Database:** MySQL
- **Authentication:** CodeIgniter Shield / Custom Auth System
- **Payment Gateway:** Dummy GateWay but soon to any either Stripe/PayPal sandbox
- **Deployment:** Apache/Nginx with PHP 8+

## 📂 Folder Structure

```
/project-root
│── app/           # Application logic (Controllers, Models, Views)
│── public/        # Public assets (CSS, JS, Images)
│── writable/      # Logs, cache, session files
│── tests/         # PHPUnit tests
│── .env           # Environment configuration
│── composer.json  # PHP dependencies
│── README.md      # Project documentation
```

## ⚙️ Installation Guide

### Prerequisites

- PHP 8+
- MySQL Database
- Composer
- Apache/Nginx Server

### Step 1: Clone the Repository

```sh
git clone https://github.com/kashagor1/bus_booking.git
cd bus_booking
```

### Step 2: Install Dependencies

```sh
composer install
```

### Step 3: Configure `.env`

Rename `.env.example` to `.env` and update database settings:

```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/bus-booking/'
database.default.hostname = localhost
database.default.database = bus_booking
database.default.username = root
database.default.password = ''
database.default.DBDriver = MySQLi
```

or can setup the db settings from app/Config/Database.php

### Step 4: Run Database Migrations (Skip this step and move to 4.1 only if need db file)

```sh
php spark migrate
```

### Step 5: Setup Database (Only for newbies)

Get the database new_bus.sql file in public/db folder.

### Step 6: Extract Asstets

Extract the bus_booking/public/assets.zip file located in bus_booking/public folder.

### Step 7: Start Development Server

```sh
php spark serve
```

Visit `http://localhost:8080` to access the system.
Visit `http://localhost:8080/admin` to access the super adminpanel panel.
username = admin@test.com
password = 1234

## 🛠️ Usage

1. **Super Admin Panel**: Create Company, Routes, Coach and Trips.
2. **User Panel**: Search and book available buses of different routes & companies. Cancel before 24 hours
3. **Payment Gateway**: Dummy Payment Gateway for now but will integrate a sandbox system here very soon.

## 📜 License

This project is open-source and available under the **MIT License**.

## 📬 Contact

For any queries or contributions, reach out at `ka.shagor1@gmail.com` or create an issue in the repository.

---

🚀 **Happy Coding!** 🎉
