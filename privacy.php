<?php require_once 'includes/dynamic_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Privacy Policy - SMTP Testing Tool</title>
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
    <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Privacy Policy</h1>
    <div class="space-y-6 text-gray-700">
      <section>
        <h2 class="text-xl font-semibold mb-3">Information We Collect</h2>
        <p class="leading-relaxed">
          When using our SMTP Testing Tool, we do not store any SMTP credentials or email content you provide. All data is used solely for the purpose of sending test emails and is not retained on our servers.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3">How We Use Your Information</h2>
        <p class="leading-relaxed">
          The information you enter into our SMTP Testing Tool is used only to facilitate the sending of test emails. We do not:
        </p>
        <ul class="list-disc ml-6 mt-2 space-y-2">
          <li>Store your SMTP credentials</li>
          <li>Store email content</li>
          <li>Share any information with third parties</li>
          <li>Use the information for any purpose other than sending test emails</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3">Security</h2>
        <p class="leading-relaxed">
          We take security seriously and implement appropriate measures to protect any information transmitted through our tool. However, as we do not store any sensitive information, your SMTP credentials and email content are only used temporarily during the test email sending process.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3">Changes to This Policy</h2>
        <p class="leading-relaxed">
          We may update this privacy policy from time to time. Any changes will be posted on this page with an updated revision date.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3">Contact Us</h2>
        <p class="leading-relaxed">
          If you have any questions about this Privacy Policy, please contact us through our <a href="contact.php" class="text-blue-600 hover:underline">Contact Page</a>.
        </p>
      </section>
    </div>
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
