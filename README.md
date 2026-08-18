# NexusDigital - Web Application & Admin Management Portal

NexusDigital is a full-stack, responsive web application developed for a software engineering and digital services agency. The application provides a public-facing website for client engagement alongside a secure administrative panel for dynamic content management.

---

## Features

* **Public Pages:**
  * **Home (`index.php`):** Landing page showcasing company capabilities, key metrics, and technology stack.
  * **About (`about.php`):** Details company background, development standards, and core values.
  * **Services (`services.php`):** Dynamically loads and displays available services from the database.
  * **Contact (`contact.php`):** Includes a functional contact form for visitor inquiries.

* **Admin Dashboard (`admin_dashboard.php`):**
  * **Authentication:** Secure login mechanism using PHP sessions and password verification.
  * **CRUD Operations:** Complete capability to add, view, edit, and delete service listings.
  * **File Uploads:** Handles service banner image uploads, validation, and storage within the `uploads/` directory.

* **User Interface & Styling:**
  * Integrated light and dark theme switcher using CSS custom properties and JavaScript.
  * Mobile-first responsive layout built with custom CSS and Bootstrap 5.

---

## Tech Stack

* **Backend:** PHP
* **Database:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
* **Environment:** Apache / MySQL (XAMPP or AwebServer)

---

## Database Architecture (`nexus_digital_db`)

The relational database consists of 4 main tables:

1. `admin_users`: Stores administrator login details and account records.
2. `categories`: Manages service categories.
3. `services`: Stores service titles, descriptions, pricing, image paths, and category foreign keys.
4. `contacts`: Records messages submitted through the contact form.

---

## Setup & Installation

1. Copy the project folder into your local web server directory (e.g., `htdocs` or web root folder).
2. Open phpMyAdmin and create a database named `nexus_digital_db`.
3. Import the `nexus_digital_db.sql` file into the newly created database.
4. Verify database credentials in `db.php` (`$host = "localhost"`, `$user = "root"`, `$pass = ""`, `$dbname = "nexus_digital_db"`).
5. Open your web browser and navigate to `http://localhost:8080/` (or your configured local server port).

---

## Security Implementation

* **SQL Injection Protection:** Database operations use prepared statements to safeguard data.
* **XSS Protection:** User inputs are sanitized before rendering on the page.
* **Session Control:** Unauthorized access to admin pages is restricted via server-side session checks.
