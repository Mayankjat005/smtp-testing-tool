<?php
session_start();

define('ACCESS_CODE_FILE', __DIR__ . '/../data/access_code.json');

function get_stored_code_hash() {
    if (!file_exists(ACCESS_CODE_FILE)) {
        // Initialize with default code 772889 hashed
        $default_code = '772889';
        $hash = password_hash($default_code, PASSWORD_DEFAULT);
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
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid access code.';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
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
    <form method="POST" action="index.php" class="space-y-4">
      <label for="code" class="block text-gray-700 font-medium">Access Code</label>
      <input type="password" id="code" name="code" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter access code" />
      <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition-colors">Login</button>
    </form>
  </div>
</body>
</html>
