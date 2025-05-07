<?php
require_once '../includes/dynamic_content.php';

// Load blog posts
$posts_file = __DIR__ . '/../data/blog_posts.json';
$posts = [];

if (file_exists($posts_file)) {
    $all_posts = json_decode(file_get_contents($posts_file), true) ?? [];
    // Filter only published posts and sort by time (newest first)
    $posts = array_filter($all_posts, fn($post) => $post['published']);
    usort($posts, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Blog - SMTP Testing Tool</title>
    <link rel="icon" type="image/png" href="../favicon.png" />
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
        <h1 class="text-3xl font-semibold mb-8 text-center text-gray-800">Blog Posts</h1>
        
        <?php if (empty($posts)): ?>
            <p class="text-center text-gray-600">No blog posts available yet.</p>
        <?php else: ?>
            <div class="space-y-8">
                <?php foreach ($posts as $post): ?>
                    <article class="border-b border-gray-200 pb-8 last:border-b-0">
                        <h2 class="text-2xl font-semibold mb-2">
                            <a href="template.php?slug=<?php echo urlencode($post['slug']); ?>" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                <?php echo htmlspecialchars($post['name']); ?>
                            </a>
                        </h2>
                        <div class="text-gray-600 text-sm mb-3">
                            <time datetime="<?php echo htmlspecialchars($post['time']); ?>">
                                <?php echo date('F j, Y', strtotime($post['time'])); ?>
                            </time>
                        </div>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            <?php 
                            $description = htmlspecialchars($post['description']);
                            echo strlen($description) > 200 
                                ? substr($description, 0, 200) . '...' 
                                : $description; 
                            ?>
                        </p>
                        <a href="template.php?slug=<?php echo urlencode($post['slug']); ?>" 
                           class="text-blue-600 hover:text-blue-800 transition-colors inline-flex items-center">
                            Read more
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
