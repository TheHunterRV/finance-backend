## Finance Data Processing & Access Control Backend
## Overview

This project is a backend system for a Finance Dashboard Application that manages financial records and provides role-based access to data and analytics.

The system is built using CodeIgniter 4, PHP, and MySQL, focusing on clean architecture, secure APIs, and maintainable backend logic.

##System Design

The application follows a structured backend design:

Controllers → Handle API requests and responses
Models → Handle database operations
Helpers → JWT authentication logic
BaseController → Centralized token validation
##Roles & Access Control
Role	Permissions
Admin	Full access (create, view all records, dashboard)
Analyst	View all records and dashboard
Viewer	Can access only their own records and dashboard
##Features
##Financial Records
Create financial records
View records
Fields:
amount
type (income/expense)
category
date
notes
##Dashboard
Total Income
Total Expense
Net Balance
Role-based data visibility:
Admin & Analyst → All records
Viewer → Only own records
## Authentication
JWT-based authentication
Secure API access using Bearer Token
## Setup Instructions
1. Clone Repository
git clone https://github.com/TheHunterRV/finance-backend
cd finance-backend
2. Install Dependencies
composer install
3. Configure Environment

Edit .env file:

CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = finance_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
4. Run Migrations
php spark migrate
5. Start Server
php spark serve

## API Documentation
## Login

POST /login

Request:

{
  "email": "admin@test.com",
  "password": "123456"
}

Response:

{
  "message": "Login successful",
  "token": "JWT_TOKEN"
}

## Create Record

POST /records

Headers:

Authorization: Bearer <token>

Body:

{
  "amount": 5000,
  "type": "income",
  "category": "salary",
  "date": "2026-04-01",
  "notes": "Monthly salary"
}

## Get Records

GET /records

## Dashboard

GET /dashboard

Response:

{
  "totalIncome": 50000,
  "totalExpense": 20000,
  "netBalance": 30000
}

## Access Control Logic
JWT token is required for protected routes
Token is validated in BaseController
Role determines data visibility:
Admin / Analyst → All records
Viewer → Only own records

## Database Schema
Users Table
id
name
email
password (hashed)
role (admin, analyst, viewer)
is_active
Records Table
id
amount
type (income/expense)
category
date
notes
created_by

## Testing

Tested using Postman:

Login → get JWT token
Add token in Authorization header
Test endpoints

## Assumptions
Users are manually inserted into database (no registration API)
JWT token expires in 1 hour
Admin and Analyst can view all records
Viewer can only access their own data
Passwords are stored securely using hashing
Simplified schema without strict foreign key constraints (to avoid migration issues)

## Tradeoffs & Design Decisions
 No full RBAC system → simple role-based checks used
 No pagination → kept simple for assignment scope
 No refresh tokens → basic JWT implementation
 Foreign key constraints removed → avoided migration errors
 Focus on clarity, maintainability, and core backend logic

## Future Improvements
Pagination & filtering
Category-wise analytics
Monthly trends
Full RBAC system
Swagger API documentation
Frontend integration

## Author

Rohit Vishwakarma
