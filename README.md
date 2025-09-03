# Laravel Starter CRM

A starter CRM template built with **Laravel** (backend) and **Tailwind CSS** (frontend).  
Includes authentication, user management, and client management out of the box.

---

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/vjdoon/laravelstartercrm.git
   cd laravelstartercrm
2. **Install PHP dependencies**
composer install
3. **Install frontend dependencies**
npm install && npm run build
4. **Configure environment**
cp .env.example .env
php artisan key:generate
5. **Run migrations and seeders**
php artisan migrate --seed
6. **Start the development server**
php artisan serve

**Demo Login**

Username: admin

Password: admin

**Features**

User authentication (login/logout)

Role-based access (admin, user)

Client management (add, edit, delete, view)

User management (add, edit, delete, view)

Password change functionality