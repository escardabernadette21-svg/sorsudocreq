# Document Request System - Capstone Project

## Overview
The Document Request System is a web-based application built with Laravel that simplifies the process of requesting and processing academic documents. It enables students to select from various certifications, academic forms, and other services, specify their purpose, and generate payment order slips online. The system supports role-based access, where students can submit and track their requests, while administrators can review, process, and release the requested documents. This streamlined approach reduces manual paperwork, ensures accurate fee calculation, and improves overall efficiency in handling school document requests.

## Features

### Admin Features:
- **Dashboard Management:** View key statistics such as the total number of students, pending document requests, approved requests, completed payments, and recent activities. Provides a quick overview of system performance and pending tasks for administrators.
- **Student Management:** Create, update, view, and delete student records.
- **Announcement Management:** Manage annoucement information.
- **Document Request Management:** Manage academic form and services of student.
- **Payment Management:** Update, view and delete payment of student.
- **Transaction History:** View and download document request history.

### Student Features:
- **Online Registration:** Students can create accounts and register via the online platform.
- **Document Request:** Select certifications, academic forms, and services, specify their purpose, and generate payment order slips online.
- **Request Tracking:** Monitor the status of document requests (pending, approved, processed, or released).
- **Payment Processing:** View payment details and confirm transactions related to document requests.
- **Announcements Viewing:** Access important announcements posted by the school administration.
- **Transaction History:** Review previous requests and download completed documents when available.

## Installation

### Prerequisites:
- PHP 8.1 or higher
- Composer
- MySQL or another relational database
- Node.js & npm (for frontend dependencies)

### Steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/escardabernadette21-svg/sorsudocreq.git
   cd sorsudocreq

2. **Install Backend Dependencies:**
   ```bash
   composer install

3. **Configure Environment: Copy the .env.example file to .env :**
   ```bash
   copy .env.example .env


4. **Update the .env file with database and API keys:**
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

5.  **Gmail Config:**
    ```bash
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=465
    MAIL_USERNAME=carlogacelo3@gmail.com
    MAIL_PASSWORD=kifhkwzujuzqoeqe
    MAIL_ENCRYPTION=ssl
    MAIL_FROM_ADDRESS="carlogacelo3@gmail.com"
    MAIL_FROM_NAME="Sorsu-Bulan Document Request System"

6.  **Pusher Config:**
    ```bash
    PUSHER_APP_ID=2041220
    PUSHER_APP_KEY=302b9145ad49f3adcf60
    PUSHER_APP_SECRET=58ee3a0e913177a5b61e
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=ap1


7. **Generate Application Key**
    ```bash
    php artisan key:generate

8. **Run Migrations: Migrate the database tables**
    ```bash
    php artisan migrate:fresh --seed

9. **To link storage**
    ```bash
    php artisan storage:link

10. **Install Frontend Dependencies**
    ```bash
    npm install && npm run build

11. **Serve the Application: Start the development server**
      ```bash
    php artisan serve


### License:
This project is open-source and available under the MIT license.
