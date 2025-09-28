<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

**Overview**

This project is a self-contained Expense Management module built using Laravel 12 with a modular architecture.
The module (Modules/Expenses) demonstrates clean, scalable practices suitable for ERP-style development, including:

- Modular folder structure with separation of concerns
- Service layer for business logic
- Form Requests for validation
- Resource classes for consistent API responses
- Optional features: Swagger docs, Feature tests, Events

**Setup Instructions** 

**1. Clone the Repository**
```command
git clone <repo-url>
cd <project-folder>
```

**2. Install Dependencies**
```command
composer install
```
**3. Environment Setup**
- Copy .env.example to .env
- Update database credentials
- Run:
```command
php artisan key:generate
```
**4. Run Migrations**
```command
php artisan migrate
```
**5. Seed Sample Expenses**
```command
php artisan db:seed --class=ExpenseSeeder
```
**6. Access API Endpoints**
```coomand
GET     /api/expenses          
POST    /api/expenses          
GET     /api/expenses/{id}    
PUT     /api/expenses/{id}     
DELETE  /api/expenses/{id}
```
**7. Swagger API Docs**
```command
php artisan l5-swagger:generate
http://localhost:8000/api/documentation
```
**Project Structure & Decisions**
```command
Modules/
 └── Expenses/
      ├── Http/
      │    ├── Controllers/ExpenseController.php   # API endpoints
      │    └── Requests/StoreExpenseRequest.php    # Validation (create)
      │    └── Requests/UpdateExpenseRequest.php   # Validation (update)
      ├── Models/Expense.php                       # Eloquent model
      ├── Services/ExpenseService.php              # Business logic
      ├── Resources/ExpenseResource.php            # API formatting
      ├── Database/
      │    ├── migrations/                         # DB schema
      │    └── factories/ExpenseFactory.php        # Test/seed data
      └── routes/api.php 
```
**Key Decisions**

- **UUIDs used for id:** ensures scalability and uniqueness across distributed systems.
- **Service Layer:** keeps business logic out of controllers.
- **Form Requests:** centralize validation rules.
- **Resource Classes:** consistent and clean API responses.
- **Repository Pattern:** optional, but could be added if project grows.
- **Swagger (L5-Swagger):** for API documentation.
- **Feature Test:** added for core CRUD operations.

**Assumptions**

- Authentication & multi-user handling were not required (per instructions).
- Categories handled as enum-like strings (not a separate module).
- Only basic filtering (category, date range) included.
- Used Laravel’s default testing framework (PHPUnit) for feature test.
- Used L5-Swagger for API docs (could be swapped with Scribe).

**Time Spent**

- Project Setup & Modular Structure: 1.5 hours
- Expense CRUD (Controller, Service, Model, Requests): 2 hours
- Validation & Resources: 2 hour
- Feature Test & Factory: 1.5 hours
- Swagger Documentation: 1 hour
- Final cleanup & README: 0.5 hour
