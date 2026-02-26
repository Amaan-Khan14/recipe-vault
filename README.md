# Recipe Vault - Database Version

This version uses MySQL database instead of session storage. Data persists even after closing the browser!

## Prerequisites

- XAMPP installed (Apache + MySQL)

---

## Step 1: Start XAMPP

### Linux

```bash
cd /opt/lampp
sudo ./lampp start
```

### Windows

1. Open **XAMPP Control Panel**
   - Press `Win + R`, type `xampp-control` and press Enter
   - OR go to `C:\xampp` and run `xampp-control.exe`

2. Click **Start** button next to **Apache**
3. Click **Start** button next to **MySQL**

Both should show green "Running" status.

---

## Step 2: Create the Database (Using phpMyAdmin)

1. Open browser and go to: **http://localhost/phpmyadmin**

2. Click the **SQL** tab (at the top)

3. Copy and paste this SQL to create the database and table:

```sql
-- Create database
CREATE DATABASE IF NOT EXISTS recipe_vault 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE recipe_vault;

-- Create recipes table
CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ingredients JSON NOT NULL,
    instructions JSON NOT NULL,
    prepTimeMinutes INT DEFAULT 15,
    cookTimeMinutes INT DEFAULT 15,
    servings INT DEFAULT 2,
    difficulty VARCHAR(20) DEFAULT 'Medium',
    cuisine VARCHAR(50) DEFAULT 'Other',
    caloriesPerServing INT DEFAULT 300,
    rating DECIMAL(2,1) DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

4. Click **Go** button (bottom right)

5. You should see "MySQL returned an empty result set" - this is good! The table is created.

6. Click **SQL** tab again

7. Copy and paste this SQL to add sample recipes:

```sql
USE recipe_vault;

INSERT INTO recipes (name, ingredients, instructions, prepTimeMinutes, cookTimeMinutes, servings, difficulty, cuisine, caloriesPerServing, rating) VALUES
(
    'Classic Margherita Pizza',
    '["Pizza dough", "Tomato sauce", "Fresh mozzarella", "Fresh basil", "Olive oil"]',
    '["Preheat oven to 475°F", "Roll out dough and add sauce", "Add mozzarella and basil", "Bake for 12-15 minutes"]',
    20, 15, 4, 'Easy', 'Italian', 300, 4.6
),
(
    'Vegetarian Stir-Fry',
    '["Tofu", "Broccoli", "Bell peppers", "Soy sauce", "Sesame oil", "Garlic"]',
    '["Press and cube tofu", "Heat oil in wok", "Stir-fry tofu until golden", "Add vegetables and sauce"]',
    15, 12, 3, 'Easy', 'Asian', 220, 4.7
),
(
    'Chicken Tacos',
    '["Chicken breast", "Taco shells", "Lettuce", "Tomatoes", "Cheese", "Taco seasoning"]',
    '["Season chicken", "Grill until cooked", "Slice into strips", "Assemble tacos"]',
    15, 20, 4, 'Medium', 'Mexican', 350, 4.5
),
(
    'Greek Salad',
    '["Cucumber", "Tomatoes", "Red onion", "Feta cheese", "Olives", "Olive oil"]',
    '["Chop vegetables", "Add feta and olives", "Drizzle with olive oil", "Season with oregano"]',
    10, 0, 2, 'Easy', 'Mediterranean', 180, 4.8
),
(
    'Butter Chicken',
    '["Chicken", "Tomato puree", "Cream", "Butter", "Garam masala", "Ginger-garlic paste"]',
    '["Marinate chicken", "Cook chicken in butter", "Add tomato puree and spices", "Simmer with cream"]',
    30, 25, 4, 'Medium', 'Indian', 450, 4.9
);
```

8. Click **Go** button

9. You should see "5 rows inserted" - Success!

---

## Step 3: Run the PHP Application

Open a terminal in the `recipe-vault/database` directory:

```bash
cd recipe-vault/database
php -S localhost:8000
```

You should see:
```
PHP Development Server started at http://localhost:8000
```

---

## Step 4: Open in Browser

Visit: **http://localhost:8000**

You should see the Recipe Vault with 🗄️ Database Version label!

---

## Verify Database is Working

1. Add a new recipe through the web interface
2. Close the browser
3. Reopen **http://localhost:8000**
4. Your new recipe should still be there!

---

## Stopping XAMPP

### Linux
```bash
cd /opt/lampp
sudo ./lampp stop
```

### Windows
Open XAMPP Control Panel and click **Stop** for Apache and MySQL.

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| "Database connection failed" | Make sure MySQL is running in XAMPP Control Panel |
| "Access denied for user" | Check `config.php` - default XAMPP is username: `root`, password: empty |
| "Failed to load recipes" | Make sure you executed both SQL files in phpMyAdmin |
| Port 8000 already in use | Use a different port: `php -S localhost:8080` |

---

## Files in this Directory

| File | Purpose |
|------|---------|
| `schema.sql` | Creates database and recipes table |
| `seed.sql` | Inserts 5 sample recipes |
| `config.php` | Database connection settings |
| `api_db.php` | API endpoints using MySQL |
| `index.html` | Frontend interface |
