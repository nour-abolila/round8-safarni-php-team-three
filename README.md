# Safarni App 

## 💡 Project Idea
Safarni is a comprehensive booking application that allows users to book **flights, hotels, and tours** with ease.  
The main goal is to provide a seamless and organized booking experience, backed by a robust and scalable API architecture.

The application focuses on **user management, secure authentication, and a smooth search & filtering experience** for trips and tours.

---

## 🛠 Key Features & Tasks Implemented

### 1️⃣ Authentication & Authorization
- User registration with **Full Name, Email, and Password**.
- Sending **OTP via email** for account verification.
- OTP verification and account activation.
- Login with email and password, with **API token generation**.
- Logout and token revocation.
- Forgot password & reset password using OTP.
- Change password for authenticated users.
- Roles & Permissions implemented using **Spatie Laravel Permission**.
- Support for **Google OAuth login**.

### 2️⃣ User Profile
- View user profile (Show).
- Update user profile (Edit).
- All operations follow **Clean Code practices** with **Service Layer** handling business logic and **Request classes** handling validation.

### 3️⃣ Tours / Flights Search & Filtering
- Search trips or tours based on **location**.
- Filter results by:
  - **Price** (Low to High / High to Low)
  - **Most Reviewed**
  - **Budget Range**
- Designed to be intuitive and easily extensible.

---

## 🗂️ Clean Code Structure
The project is structured with **clean architecture principles**:

- **Services:** All business logic like Authentication, Profile Management, and OTP handling is inside service classes.
- **Requests:** Validation rules are separated into request classes for cleaner controllers.
- **Resources:** API Resources are used to format JSON responses consistently.
- **Helpers / Responses:** Custom helper methods are used for standardized API responses.
- **Mailables:** OTP emails are sent using dedicated mail classes.
- **Controllers:** Minimal logic, only delegating tasks to services and returning API responses.

This structure ensures maintainability, scalability, and readability of the codebase.

---

## ⚡ API Overview
- **POST /api/register** → Register a new user + send OTP.
- **POST /api/verify-otp** → Verify OTP and activate account.
- **POST /api/login** → Login and get API token.
- **POST /api/logout** → Logout and revoke token.
- **POST /api/forgot-password** → Request OTP to reset password.
- **POST /api/reset-password** → Reset password using OTP.
- **POST /api/change-password** → Change password for logged-in user.
- **GET /api/profile** → View user profile.
- **PUT /api/profile** → Update user profile.
- **GET /api/tours/search** → Search trips or tours by location.
- **GET /api/tours/filter** → Filter trips or tours by price, reviews, or budget.

---

## 🔧 Technologies Used
- **Laravel 10**
- **PHP 8**
- **MySQL**
- **Spatie Laravel Permission**
- **Sanctum** for API token authentication
- **SMTP / Gmail** for sending OTP emails
- **Postman** for API testing

---

## 📝 Notes
- The project follows **Clean Code** and **Service-Oriented Architecture**.
- Controllers are lightweight; services handle all business logic.
- Requests handle validation to keep controllers clean.
- API responses are standardized using resources and helpers.
- Focused on maintainability, readability, and scalability.
