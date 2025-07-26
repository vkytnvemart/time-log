# Laravel Time Log App

A simple time tracking system built in Laravel where users can log tasks by date, specify time spent in hours/minutes, and view/edit their entries.

## 🚀 Features

- Log work tasks by date.
- Add multiple entries per day.
- Edit/update submitted tasks.
- Auto-calculates total hours per day.
- Enforces 10-hour daily cap.
- Clean UI with Tailwind CSS.


## 🔧 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/vkytnvemart/time-log.git
   cd laravel-time-log
composer install
php artisan key:generate
php artisan migrate
php artisan serve
