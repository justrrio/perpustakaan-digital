# Perpustakaan Digital

![Banner.png](https://github.com/justrrio/perpustakaan-digital/blob/main/Banner.png)

## Overview

This project is a comprehensive Digital Library Management System developed using CodeIgniter 4. It allows for efficient management of books, users, and categories, featuring robust functionalities such as user authentication, book search, and categorization. The system supports role-based access, ensuring secure and distinct functionalities for administrators and regular users.

## Features

- **User Authentication**: Secure login and registration with password encryption to protect user data.
- **Role Management**: Customized views and permissions for Admins and regular Users.
- **Book Management**: Full CRUD (Create, Read, Update, Delete) operations for books, including soft delete to prevent data loss.
- **Category Management**: Efficient handling of book categories, allowing addition, editing, and removal.
- **User Management**: Admins have the ability to manage user accounts and assign roles.
- **Search and Filter**: Powerful search and filter options to find books based on categories and titles.
- **Responsive Design**: Intuitive and adaptive user interface suitable for various devices.

## Technologies Used

- **Backend**: CodeIgniter 4 (PHP Framework)
- **Frontend**: HTML, CSS, Bootstrap, JavaScript
- **Database**: MySQL
- **Version Control**: Git and GitHub

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository**
    
    Clone the project repository from GitHub:
    
    ```bash
    git clone https://github.com/justrrio/perpustakaan-digital.git
    ```
    
2. **Navigate to the project directory**
    
    ```bash
    cd perpustakaan-digital
    ```
    
3. **Install dependencies**
    
    Ensure Composer is installed on your system, then run:
    
    ```bash
    composer install
    ```
    
4. **Set up the database**
    - Navigate to the `db` directory:
        
        ```bash
        cd db
        ```
        
    - Import the `.sql` file into your database management system (e.g., MySQL).
5. **Configure the environment**
    
    Update your `.env` file with your database settings:
    
    ```
    database.default.hostname = localhost
    database.default.database = perpustakaan_digital
    database.default.username = root
    database.default.password =
    database.default.DBDriver = MySQLi
    ```
    
6. **Run the application**
    
    Start the development server:
    
    ```bash
    php spark serve
    ```
    
    Open your browser and navigate to `http://localhost:8080` to access the application.
    

## Usage

The system offers two types of accounts: Admin and User. Below are the details for logging in:

- **Admin Account**
    - **Email:** admin@gmail.com
    - **Password:** 12341234
- **User Account**
    - **Email:** testing@gmail.com
    - **Password:** 12341234

To access the login page, navigate to the following URL:

```bash
http://localhost:8080/login
```

Once logged in, Admins can manage books, categories, and users, while regular Users can browse and search for books within their authorized categories.
