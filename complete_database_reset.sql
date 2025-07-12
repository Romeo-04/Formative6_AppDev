-- COMPLETE DATABASE RESET SCRIPT
-- Copy and paste this ENTIRE script into phpMyAdmin SQL tab

-- Step 1: Use the correct database
USE dog_registration;

-- Step 2: Drop the table completely to start fresh
DROP TABLE IF EXISTS dogs;

-- Step 3: Create the table with proper AUTO_INCREMENT
CREATE TABLE dogs (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    breed VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    address TEXT NOT NULL,
    color VARCHAR(50) NOT NULL,
    height DECIMAL(5,2) NOT NULL,
    weight DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1;

-- Step 4: Insert sample data
INSERT INTO dogs (name, breed, age, address, color, height, weight) VALUES
('Buddy', 'Golden Retriever', 3, '123 Main St, New York, NY', 'Golden', 60.50, 30.25),
('Luna', 'Siberian Husky', 2, '456 Oak Ave, Los Angeles, CA', 'Black and White', 55.00, 25.50),
('Max', 'German Shepherd', 5, '789 Pine Rd, Chicago, IL', 'Brown and Black', 65.00, 35.75),
('Bella', 'Labrador Retriever', 4, '321 Elm St, Houston, TX', 'Yellow', 58.25, 28.00),
('Charlie', 'Bulldog', 6, '654 Maple Dr, Phoenix, AZ', 'White and Brown', 40.50, 22.80),
('Lucy', 'Border Collie', 2, '987 Cedar Ln, Philadelphia, PA', 'Black and White', 52.75, 20.50),
('Cooper', 'Beagle', 4, '147 Birch St, San Antonio, TX', 'Tricolor', 38.00, 18.25),
('Daisy', 'Poodle', 3, '258 Willow Way, San Diego, CA', 'White', 45.50, 15.75),
('Rocky', 'Rottweiler', 7, '369 Spruce Ave, Dallas, TX', 'Black and Brown', 68.00, 42.30),
('Molly', 'Cocker Spaniel', 5, '741 Aspen Blvd, San Jose, CA', 'Brown', 42.25, 16.90);

-- Step 5: Verify the table structure
SHOW CREATE TABLE dogs;

-- Step 6: Check AUTO_INCREMENT status
SHOW TABLE STATUS LIKE 'dogs';
