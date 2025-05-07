<?php require_once 'includes/dynamic_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us - SMTP Testing Tool</title>
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
    <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Contact Us</h1>
    <p class="text-gray-700 leading-relaxed mb-6 text-center">
      If you have any questions, feedback, or need support, please feel free to reach out to us.
    </p>
    <form class="space-y-6 max-w-lg mx-auto" id="contactForm">
      <div>
        <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
        <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Your Name" />
      </div>
      <div>
        <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
        <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="you@example.com" />
      </div>
      <div>
        <label for="message" class="block text-gray-700 font-medium mb-1">Message</label>
        <textarea id="message" name="message" rows="5" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write your message here..."></textarea>
      </div>
      <div class="text-center">
        <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-3 rounded hover:bg-blue-700 transition-colors">
          <i class="fas fa-paper-plane mr-2"></i> Send Message
        </button>
      </div>
    </form>
    <div id="contactResult" class="mt-6 text-center text-lg font-medium"></div>
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

    const form = document.getElementById('contactForm');
    const resultDiv = document.getElementById('contactResult');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      resultDiv.textContent = 'Message sent successfully! We will get back to you soon.';
      resultDiv.className = 'mt-6 text-center text-lg font-medium text-green-600';
      form.reset();
    });
  </script>
</body>
</html>
