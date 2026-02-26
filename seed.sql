-- Recipe Vault Sample Data
-- Run this after schema.sql to insert sample recipes

USE recipe_vault;

-- Insert sample recipes
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
