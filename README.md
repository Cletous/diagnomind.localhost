# DiagnoMind – AI-Powered Medical Diagnosis System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red?logo=laravel)](https://laravel.com/)
[![Python](https://img.shields.io/badge/Flask-Python-blue?logo=python)](https://flask.palletsprojects.com/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-lightgrey?logo=mysql)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

DiagnoMind is a full-stack medical diagnosis system built with **Laravel + Livewire** and integrated with an **AI diagnosis server using Flask (Python)**. Doctors can submit symptoms, receive AI-generated suggestions, manage hospitals, and track patient feedback. Patients can access diagnosis history and provide ratings or comments.

---

## Getting Started (Development Setup)

### 1. Create a folder diagnomind-projects and clone the github repositories in there

Right click on the desktop and Open Terminal. Then use the following commands:

```
mkdir diagnomind-projects
cd diagnomind-projects/
git clone https://github.com/Cletous/diagnomind-ai-server
git clone https://github.com/Cletous/diagnomind.localhost
```

You should end up with a folder structure as follows:

```

diagnomind-projects/
├── diagnomind-ai-server/ # Python Flask AI engine
└── diagnomind.localhost/ # Laravel web frontend

```

---

### 2. Start the AI Diagnosis Server

```bash
cd diagnomind-ai-server
python app.py
```

This runs the Flask server at: `http://127.0.0.1:2500/predict`

---

### 3. Configure Laravel Environment

Open a new terminal window from inside inside the `diagnomind-ai-server` folder and run the following commands

```bash
cd ../diagnomind.localhost
cp .env.example .env
```

Copy and paste the following into your created `.env`:

```dotenv
APP_NAME="DiagnoMind AI"
APP_ENV=local
APP_KEY=base64:mbGmIxq9dtVsuQJ9sSCeZp96z2sqAjkGrBaLfOoFlXg=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000/

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

```

---

### 4. Install PHP Dependencies

```bash
composer install
```

---

### 5. Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

---

### 6. Default User Accounts

| Role         | Email                                | Password  | Natioanal Id Number             |
| ------------ | ------------------------------------ | --------- | ------------------------------- |
| **Admin**    | `admin@test.com`                     | `admin`   | `111111111T01`                  |
| **Doctors**  | `doctor1@test.com`                   | `doctor`  | `111111111T02`                  |
|              | `doctor2@gmail.com`                  | `doctor`  | `111111111T03`                  |
| **Patients** | `user1@test.com` → `user20@test.com` | `patient` | `100000001T01` → `100000001T01` |

---

### 7. Link and configure your mail provider:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=server1.makuruwan.com
MAIL_PORT=465
MAIL_USERNAME=no-reply@yourdomain.com
MAIL_PASSWORD=EmailPassword
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="no-reply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Replace `MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION` and `MAIL_FROM_ADDRESS` with your actual mail provider configuration settings and credentials.

---

### 8. Start Laravel Development Server

```bash
php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Key Features

-   Role-based Access (Admin, Doctor, Patient)
-   AI Symptom-to-Diagnosis engine (via Flask)
-   Hospital Management & Invitations
-   Diagnosis History & Filtering
-   Feedback & Ratings for Diagnoses

---

## Tech Stack

-   **Backend:** Laravel 12, Livewire, MySQL
-   **AI Engine:** Flask + Python
-   **UI:** Bootstrap 5.3
-   **Auth:** Email Verification, Role Management

---

## Contributing

Contributions are welcome! Fork the repo and submit a PR.

---

## License

This project is licensed under the [MIT License](LICENSE).

---

## Contact

Maintained by **UZ Computer Engineering Students** — Part 2 Group Project
**Group Members:**

-   Cletous Ngoma (R196481X) – [ngomacletousjnr@gmail.com](mailto:ngomacletousjnr@gmail.com)
-   Takudzwanashe H. Nhaiso (R231702X)
-   Talent Nechitukire (R1810926)
-   Shelton Mutambirwa (R231684F)
-   Patricia Mukunza (R231733N)
-   Tadiwa Ncube (R231692S)

---
