<?php require_once 'includes/dynamic_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SMTP Testing Tool</title>
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
  
  <main class="max-w-3xl w-full bg-white rounded-lg shadow-lg p-8 animate-fadeIn flex-grow">
    <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">SMTP Testing Tool</h1>
    <form id="smtpForm" class="space-y-6">
      <fieldset class="border border-gray-300 rounded p-4">
        <legend class="text-lg font-semibold mb-2">SMTP Server Details</legend>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="host" class="block text-gray-700 font-medium mb-1">SMTP Host</label>
            <input type="text" id="host" name="host" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="smtp.example.com" />
          </div>
          <div>
            <label for="port" class="block text-gray-700 font-medium mb-1">Port</label>
            <input type="number" id="port" name="port" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="587" />
          </div>
          <div>
            <label for="encryption" class="block text-gray-700 font-medium mb-1">Encryption</label>
            <select id="encryption" name="encryption" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="">None</option>
              <option value="ssl">SSL</option>
              <option value="tls">TLS</option>
            </select>
          </div>
          <div>
            <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
            <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="user@example.com" />
          </div>
          <div>
            <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
            <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="password" />
          </div>
        </div>
      </fieldset>

      <fieldset class="border border-gray-300 rounded p-4">
        <legend class="text-lg font-semibold mb-2">Email Details</legend>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="from" class="block text-gray-700 font-medium mb-1">From Email</label>
            <input type="email" id="from" name="from" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="sender@example.com" />
          </div>
          <div>
            <label for="to" class="block text-gray-700 font-medium mb-1">To Email</label>
            <input type="email" id="to" name="to" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="recipient@example.com" />
          </div>
          <div class="md:col-span-2">
            <label for="subject" class="block text-gray-700 font-medium mb-1">Subject</label>
            <input type="text" id="subject" name="subject" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Test Email Subject" />
          </div>
          <div class="md:col-span-2">
            <label for="message" class="block text-gray-700 font-medium mb-1">Message</label>
            <textarea id="message" name="message" rows="5" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write your test email message here..."></textarea>
          </div>
        </div>
      </fieldset>

      <div class="text-center">
        <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-3 rounded hover:bg-blue-700 transition-colors disabled:opacity-50" id="sendBtn">
          <i class="fas fa-paper-plane mr-2"></i> Send Test Email
        </button>
      </div>
    </form>

    <div id="result" class="mt-6 text-center text-lg font-medium"></div>
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

    const form = document.getElementById('smtpForm');
    const resultDiv = document.getElementById('result');
    const sendBtn = document.getElementById('sendBtn');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      resultDiv.textContent = '';
      sendBtn.disabled = true;
      sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';

      const formData = new FormData(form);
      const data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      try {
        const response = await fetch('send_email.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        });

        const result = await response.json();

        if (result.success) {
          resultDiv.textContent = 'Email sent successfully!';
          resultDiv.className = 'mt-6 text-center text-lg font-medium text-green-600';
        } else {
          resultDiv.textContent = 'Error: ' + result.error;
          resultDiv.className = 'mt-6 text-center text-lg font-medium text-red-600';
        }
      } catch (error) {
        resultDiv.textContent = 'Error: ' + error.message;
        resultDiv.className = 'mt-6 text-center text-lg font-medium text-red-600';
      } finally {
        sendBtn.disabled = false;
        sendBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Send Test Email';
      }
    });
  </script>
</body>
</html>
