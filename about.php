<?php require_once 'includes/dynamic_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - SMTP Testing Tool</title>
  <link rel="icon" type="image/png" href="favicon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen p-4 flex flex-col items-center">
  <nav class="bg-white shadow-md rounded-lg max-w-3xl w-full mb-6">
    <ul class="flex justify-center space-x-8 p-4 text-gray-700 font-semibold">
      <?php echo render_menu(); ?>
    </ul>
  </nav>
  <main class="max-w-3xl bg-white rounded-lg shadow-lg p-8 animate-fadeIn flex-grow">
    <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">About Us</h1>
    <p class="text-gray-700 leading-relaxed mb-4">
      Welcome to the SMTP Testing Tool. Our mission is to provide a simple, fast, and reliable tool for testing SMTP server configurations and sending test emails.
    </p>
    <p class="text-gray-700 leading-relaxed mb-4">
      This tool is designed for developers, system administrators, and anyone who needs to verify SMTP server settings quickly and efficiently.
    </p>
    <p class="text-gray-700 leading-relaxed">
      We hope this tool helps you troubleshoot and configure your email servers with ease.
    </p>
  </main>
  <footer class="bg-white shadow-inner mt-12 py-6 w-full">
    <div class="max-w-3xl mx-auto text-center text-gray-600 text-sm">
      <?php echo render_footer(); ?>
    </div>
  </footer>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          animation: {
            fadeIn: 'fadeIn 0.8s ease-in forwards',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: 0, transform: 'translateY(10px)' },
              '100%': { opacity: 1, transform: 'translateY(0)' },
            },
          },
        },
      },
    };
  </script>
</body>
</html>
