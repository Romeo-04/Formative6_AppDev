# Dog Registration System - Setup Instructions

## Prerequisites
1. XAMPP installed and running (Apache + MySQL)
2. Web browser

## Setup Steps

### 1. Database Setup
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click on "SQL" tab
3. Copy and paste the content from `database_setup.sql`
4. Click "Go" to execute the SQL script

### 2. File Structure
Make sure you have these files in your `c:\xampp\htdocs\FA6\` directory:
- `DogRegister.php` (main application file)
- `config.php` (database configuration)
- `database_setup.sql` (database structure and sample data)

### 3. Running the Application
1. Start XAMPP (Apache and MySQL services)
2. Open your web browser
3. Navigate to: `http://localhost/FA6/DogRegister.php`

## Features
- ✅ Dog registration form with all required fields
- ✅ MySQL database integration
- ✅ 10 pre-loaded sample records
- ✅ Form validation
- ✅ Responsive design with Tailwind CSS
- ✅ Real-time display of registered dogs
- ✅ Modern gradient UI design

## Database Fields
- Name (VARCHAR)
- Breed (VARCHAR)
- Age (INT)
- Address (TEXT)
- Color (VARCHAR)
- Height (DECIMAL)
- Weight (DECIMAL)
- Created timestamp

## Technologies Used
- PHP 7+ for backend logic
- MySQL for database
- HTML5 for structure
- Tailwind CSS for styling
- Responsive design principles

## Troubleshooting
- If you get connection errors, make sure XAMPP MySQL is running
- Check that the database name in `config.php` matches your setup
- Ensure all files are in the correct directory
