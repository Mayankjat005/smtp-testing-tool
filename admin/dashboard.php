<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - SMTP Testing Tool</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen p-4">
  <nav class="bg-white shadow-md rounded-lg max-w-5xl mx-auto mb-6 p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800">Admin Dashboard</h1>
    <a href="index.php?logout=1" class="text-red-600 hover:underline">Logout</a>
  </nav>
  <main class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg p-8 space-y-8">
    <section id="access-code-section">
      <h2 class="text-2xl font-semibold mb-4">Change Access Code</h2>
      <form id="changeCodeForm" class="space-y-4 max-w-md">
        <div>
          <label for="newCode" class="block text-gray-700 font-medium mb-1">New Access Code</label>
          <input type="password" id="newCode" name="newCode" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter new access code" />
        </div>
        <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700 transition-colors">Update Code</button>
        <div id="codeMessage" class="mt-2 text-sm"></div>
      </form>
    </section>

    <section id="menu-footer-section">
      <h2 class="text-2xl font-semibold mb-4">Edit Primary Menu and Footer</h2>
      <form id="menuFooterForm" class="space-y-4 max-w-3xl">
        <div>
          <label for="primaryMenu" class="block text-gray-700 font-medium mb-1">Primary Menu (JSON Array)</label>
          <textarea id="primaryMenu" name="primaryMenu" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder='[{"name":"Home","url":"index.html"}]'></textarea>
          <p class="text-sm text-gray-500 mt-1">Example: [{"name":"Home","url":"index.html"},{"name":"About","url":"about.html"}]</p>
        </div>
        <div>
          <label for="footerContent" class="block text-gray-700 font-medium mb-1">Footer Content (HTML)</label>
          <textarea id="footerContent" name="footerContent" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="&copy; 2024 SMTP Testing Tool. All rights reserved."></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700 transition-colors">Save Menu & Footer</button>
        <div id="menuFooterMessage" class="mt-2 text-sm"></div>
      </form>
    </section>

    <section id="blog-posts-section">
      <h2 class="text-2xl font-semibold mb-4">Manage Blog Posts</h2>
      <div id="blogPostsList" class="mb-4">
        <!-- Blog posts will be loaded here -->
      </div>
      <button id="addPostBtn" class="bg-green-600 text-white font-semibold px-6 py-2 rounded hover:bg-green-700 transition-colors">Add New Post</button>
      <div id="blogPostFormContainer" class="mt-4 hidden max-w-3xl bg-gray-100 p-4 rounded shadow">
        <form id="blogPostForm" class="space-y-4">
          <input type="hidden" id="postId" name="postId" />
          <div>
            <label for="postName" class="block text-gray-700 font-medium mb-1">Post Name</label>
            <input type="text" id="postName" name="postName" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div>
            <label for="postDescription" class="block text-gray-700 font-medium mb-1">Post Description</label>
            <textarea id="postDescription" name="postDescription" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
          </div>
          <div>
            <label for="postSlug" class="block text-gray-700 font-medium mb-1">Post Slug</label>
            <input type="text" id="postSlug" name="postSlug" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div>
            <label for="postPublished" class="inline-flex items-center">
              <input type="checkbox" id="postPublished" name="postPublished" class="form-checkbox" />
              <span class="ml-2 text-gray-700">Published</span>
            </label>
          </div>
          <div>
            <label for="postTime" class="block text-gray-700 font-medium mb-1">Post Time</label>
            <input type="datetime-local" id="postTime" name="postTime" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>
          <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded hover:bg-blue-700 transition-colors">Save Post</button>
            <button type="button" id="cancelPostBtn" class="bg-gray-400 text-white font-semibold px-6 py-2 rounded hover:bg-gray-500 transition-colors">Cancel</button>
          </div>
          <div id="blogPostMessage" class="mt-2 text-sm"></div>
        </form>
      </div>
    </section>
  </main>

  <script>
    // JavaScript for admin panel functionality will be added here later
  </script>
</body>
</html>
