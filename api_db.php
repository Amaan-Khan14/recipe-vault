<?php
/**
 * Recipe Vault - Database API
 * Connects to MySQL database instead of using session storage
 * Supports: GET (list, get, search) and POST (create)
 */

require_once 'config.php';

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

$conn = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];

// === GET: Read Recipes ===
if ($method === 'GET') {
    $action = $_GET['action'] ?? 'list';
    
    // List all recipes
    if ($action === 'list') {
        $sql = "SELECT * FROM recipes ORDER BY id DESC";
        $result = $conn->query($sql);
        
        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = formatRecipe($row);
        }
        
        echo json_encode(['recipes' => $recipes]);
        exit;
    }
    
    // Get single recipe
    if ($action === 'get') {
        $id = intval($_GET['id'] ?? 0);
        
        $stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['recipe' => formatRecipe($row)]);
        } else {
            echo json_encode(['error' => 'Recipe not found']);
        }
        $stmt->close();
        exit;
    }
    
    // Search recipes
    if ($action === 'search') {
        $query = '%' . ($_GET['q'] ?? '') . '%';
        
        $stmt = $conn->prepare("SELECT * FROM recipes WHERE name LIKE ? OR cuisine LIKE ? ORDER BY id DESC");
        $stmt->bind_param("ss", $query, $query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = formatRecipe($row);
        }
        
        echo json_encode(['recipes' => $recipes]);
        $stmt->close();
        exit;
    }
    
    echo json_encode(['error' => 'Unknown action']);
    exit;
}

// === POST: Create Recipe ===
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || empty($data['name'])) {
        echo json_encode(['error' => 'Name is required']);
        exit;
    }
    
    // Prepare data
    $name = htmlspecialchars($data['name']);
    $ingredients = json_encode($data['ingredients'] ?? []);
    $instructions = json_encode($data['instructions'] ?? []);
    $prepTime = intval($data['prepTimeMinutes'] ?? 15);
    $cookTime = intval($data['cookTimeMinutes'] ?? 15);
    $servings = intval($data['servings'] ?? 2);
    $difficulty = $data['difficulty'] ?? 'Medium';
    $cuisine = htmlspecialchars($data['cuisine'] ?? 'Other');
    $calories = intval($data['caloriesPerServing'] ?? 300);
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO recipes 
        (name, ingredients, instructions, prepTimeMinutes, cookTimeMinutes, servings, difficulty, cuisine, caloriesPerServing) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssiiissi", $name, $ingredients, $instructions, $prepTime, $cookTime, $servings, $difficulty, $cuisine, $calories);
    
    if ($stmt->execute()) {
        $newId = $stmt->insert_id;
        
        // Fetch the newly created recipe
        $result = $conn->query("SELECT * FROM recipes WHERE id = $newId");
        $newRecipe = formatRecipe($result->fetch_assoc());
        
        echo json_encode([
            'success' => true,
            'message' => 'Recipe created',
            'recipe' => $newRecipe
        ]);
    } else {
        echo json_encode(['error' => 'Failed to create recipe: ' . $conn->error]);
    }
    
    $stmt->close();
    exit;
}

// Unsupported method
echo json_encode(['error' => 'Method not allowed']);

$conn->close();

// Helper function to format recipe data
function formatRecipe($row) {
    return [
        'id' => intval($row['id']),
        'name' => $row['name'],
        'ingredients' => json_decode($row['ingredients'], true),
        'instructions' => json_decode($row['instructions'], true),
        'prepTimeMinutes' => intval($row['prepTimeMinutes']),
        'cookTimeMinutes' => intval($row['cookTimeMinutes']),
        'servings' => intval($row['servings']),
        'difficulty' => $row['difficulty'],
        'cuisine' => $row['cuisine'],
        'caloriesPerServing' => intval($row['caloriesPerServing']),
        'rating' => floatval($row['rating'])
    ];
}
?>

// todo delete api 