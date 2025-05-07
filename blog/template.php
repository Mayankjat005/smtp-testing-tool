<?php
require_once '../includes/dynamic_content.php';

// Get blog post data from URL parameter
$slug = $_GET['slug'] ?? '';
$posts_file = __DIR__ . '/../data/blog_posts.json';
$post = null;

if (file_exists($posts_file)) {
    $posts = json_decode(file_get_contents($posts_file), true) ?? [];
    foreach ($posts as $p) {
        if ($p['slug'] === $slug && $p['published']) {
            $post = $p;
            break;
        }
    }
}

if (!$post) {
    header('Location: ../index.php');
    exit;
}

$pageTitle = $post['name'] . ' - SMTP Testing Tool';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
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
        <article class="prose lg:prose-lg mx-auto">
            <h1 class="text-3xl font-semibold mb-4"><?php echo htmlspecialchars($post['name']); ?></h1>
            <div class="text-gray-600 mb-4">
                <time datetime="<?php echo htmlspecialchars($post['time']); ?>">
                    <?php echo date('F j, Y', strtotime($post['time'])); ?>
                </time>
            </div>
            <div class="text-gray-800 leading-relaxed">
                <?php echo nl2br(htmlspecialchars($post['description'])); ?>
            </div>
        </article>
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
