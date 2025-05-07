<?php
session_start();
require_once '../includes/dynamic_content_new.php';

define('ACCESS_CODE_FILE', SETTINGS_DIR . '/access_code.json');

function get_stored_code_hash() {
    if (!file_exists(ACCESS_CODE_FILE)) {
        // Initialize with default code 772889 hashed
        $default_code = '772889';
        $hash = password_hash($default_code, PASSWORD_DEFAULT);
        
        if (!is_dir(dirname(ACCESS_CODE_FILE))) {
            mkdir(dirname(ACCESS_CODE_FILE), 0755, true);
        }
        
        file_put_contents(ACCESS_CODE_FILE, json_encode(['code_hash' => $hash]));
        return $hash;
    }
    $data = json_decode(file_get_contents(ACCESS_CODE_FILE), true);
    return $data['code_hash'] ?? null;
}

function verify_code($code) {
    $hash = get_stored_code_hash();
    return password_verify($code, $hash);
}

if (isset($_POST['code'])) {
    $code = $_POST['code'];
    if (verify_code($code)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard_new.php');
        exit;
    } else {
        $error = 'Invalid access code.';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard_new.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login - SMTP Testing Tool</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
    <h1 class="text-2xl font-semibold mb-6 text-center">Admin Login</h1>
    <?php if (!empty($error)): ?>
      <div class="mb-4 text-red-600 font-medium text-center"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <form method="POST" action="login.php" class="space-y-4">
      <div>
        <label for="code" class="block text-gray-700 font-medium mb-1">Access Code</label>
        <div class="relative">
          <input type="password" id="code" name="code" required 
                 class="w-full border border-gray-300 rounded px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                 placeholder="Enter access code" />
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <p class="text-sm text-gray-500 mt-1">Default code: 772889</p>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition-colors">
        <i class="fas fa-lock mr-2"></i> Login
      </button>
    </form>
    <div class="mt-4 text-center">
      <a href="../index.php" class="text-blue-600 hover:underline text-sm">
        <i class="fas fa-arrow-left mr-1"></i> Back to Site
      </a>
    </div>
  </div>

  <script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('code');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      
      // Toggle eye icon
      const icon = this.querySelector('i');
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
