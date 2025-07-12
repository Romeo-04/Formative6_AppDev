<?php
require_once 'config.php';

$success_message = "";
$error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $breed = mysqli_real_escape_string($conn, $_POST['breed']);
    $age = (int)$_POST['age'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $height = (float)$_POST['height'];
    $weight = (float)$_POST['weight'];
    
    // Validate inputs
    if (!empty($name) && !empty($breed) && $age > 0 && !empty($address) && !empty($color) && $height > 0 && $weight > 0) {
        
        // Check if table exists and has proper structure
        $check_table = $conn->query("SHOW CREATE TABLE dogs");
        if (!$check_table) {
            $error_message = "Database table 'dogs' does not exist. Please run the database setup script.";
        } else {
            $sql = "INSERT INTO dogs (name, breed, age, address, color, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssissdd", $name, $breed, $age, $address, $color, $height, $weight);
                
                if ($stmt->execute()) {
                    $success_message = "Dog information saved successfully!";
                    // Clear form data by redirecting
                    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                    exit();
                } else {
                    // Handle specific error codes
                    $error_code = $stmt->errno;
                    $error_msg = $stmt->error;
                    
                    if ($error_code == 1062) { // Duplicate entry error
                        $error_message = "Database Error: Duplicate entry detected. Please contact administrator to reset AUTO_INCREMENT.";
                    } else {
                        $error_message = "Database Error: " . $error_msg . " (Code: " . $error_code . ")";
                    }
                }
                $stmt->close();
            } else {
                $error_message = "SQL Prepare Error: " . $conn->error;
            }
        }
    } else {
        $error_message = "Please fill in all fields with valid data.";
    }
}

// Check for success parameter
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "Dog information saved successfully!";
}

// Fetch all dogs from database
$dogs_result = $conn->query("SELECT * FROM dogs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOG REGISTRATION SYSTEM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-900 min-h-screen p-8 font-mono text-white">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">
                🐕 DOG REGISTRATION SYSTEM 🐕
            </h1>
            <p class="text-xl text-blue-200">Register your furry friends with detailed information</p>
        </div>

        <!-- Messages -->
        <?php if ($success_message): ?>
            <div class="bg-green-600 text-white p-4 rounded-lg mb-6 text-center">
                ✅ <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="bg-red-600 text-white p-4 rounded-lg mb-6 text-center">
                ❌ <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Registration Form -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-8 border border-white/20">
                <h2 class="text-3xl font-bold mb-6 text-center text-blue-300">Register New Dog</h2>
                
                <form method="POST" action="" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-blue-200 text-sm font-bold mb-2">
                                🐾 Dog Name
                            </label>
                            <input type="text" name="name" required 
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:scale-105 focus:shadow-blue-500/50 focus:shadow-lg transition-all duration-300 ease-in-out"
                                   placeholder="Enter dog's name">
                        </div>
                        
                        <div>
                            <label class="block text-blue-200 text-sm font-bold mb-2">
                                🏷️ Breed
                            </label>
                            <input type="text" name="breed" required 
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:scale-105 focus:shadow-blue-500/50 focus:shadow-lg transition-all duration-300 ease-in-out"
                                   placeholder="Enter breed">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-blue-200 text-sm font-bold mb-2">
                                🎂 Age (years)
                            </label>
                            <input type="number" name="age" min="0" max="30" required 
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:scale-105 focus:shadow-blue-500/50 focus:shadow-lg transition-all duration-300 ease-in-out"
                                   placeholder="Age">
                        </div>
                        
                        <div>
                            <label class="block text-blue-200 text-sm font-bold mb-2">
                                📏 Height (cm)
                            </label>
                            <input type="number" name="height" step="0.01" min="0" required 
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:scale-105 focus:shadow-blue-500/50 focus:shadow-lg transition-all duration-300 ease-in-out"
                                   placeholder="Height">
                        </div>
                        
                        <div>
                            <label class="block text-blue-200 text-sm font-bold mb-2">
                                ⚖️ Weight (kg)
                            </label>
                            <input type="number" name="weight" step="0.01" min="0" required 
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:scale-105 focus:shadow-blue-500/50 focus:shadow-lg transition-all duration-300 ease-in-out"
                                   placeholder="Weight">
                        </div>
                    </div>

                    <div>
                        <label class="block text-blue-200 text-sm font-bold mb-2">
                            🎨 Color
                        </label>
                        <input type="text" name="color" required 
                               class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:scale-105 focus:shadow-blue-500/50 focus:shadow-lg transition-all duration-300 ease-in-out"
                               placeholder="Enter dog's color">
                    </div>

                    <div>
                        <label class="block text-blue-200 text-sm font-bold mb-2">
                            🏠 Address
                        </label>
                        <textarea name="address" rows="3" required 
                                  class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:border-blue-400 focus:scale-105 focus:shadow-blue-500/50 focus:shadow-lg transition-all duration-300 ease-in-out resize-none"
                                  placeholder="Enter full address"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-lg text-lg transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-2xl hover:shadow-black/30 active:scale-95">
                        💾 SAVE DOG INFORMATION
                    </button>
                </form>
            </div>

            <!-- Registered Dogs List -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-8 border border-white/20">
                <h2 class="text-3xl font-bold mb-6 text-center text-blue-300">Registered Dogs</h2>
                
                <div class="max-h-96 overflow-y-auto space-y-4">
                    <?php if ($dogs_result && $dogs_result->num_rows > 0): ?>
                        <?php while($dog = $dogs_result->fetch_assoc()): ?>
                            <div class="bg-white/20 rounded-lg p-4 border border-white/30">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-blue-300"><?php echo htmlspecialchars($dog['name']); ?></h3>
                                    <span class="text-sm text-gray-300">#<?php echo $dog['id']; ?></span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <p><span class="text-blue-200">Breed:</span> <?php echo htmlspecialchars($dog['breed']); ?></p>
                                    <p><span class="text-blue-200">Age:</span> <?php echo $dog['age']; ?> years</p>
                                    <p><span class="text-blue-200">Color:</span> <?php echo htmlspecialchars($dog['color']); ?></p>
                                    <p><span class="text-blue-200">Height:</span> <?php echo $dog['height']; ?> cm</p>
                                    <p><span class="text-blue-200">Weight:</span> <?php echo $dog['weight']; ?> kg</p>
                                </div>
                                <p class="text-sm mt-2"><span class="text-blue-200">Address:</span> <?php echo htmlspecialchars($dog['address']); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center text-gray-300 py-8">
                            <p class="text-lg">No dogs registered yet.</p>
                            <p>Be the first to register a dog! 🐕</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-blue-300">
            <p>&copy; 2025 Dog Registration System | Built with ❤️ for our furry friends</p>
        </div>
    </div>
</body>
