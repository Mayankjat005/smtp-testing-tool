<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

define('DATA_DIR', __DIR__ . '/../data');
define('ACCESS_CODE_FILE', DATA_DIR . '/access_code.json');
define('MENU_FOOTER_FILE', DATA_DIR . '/menu_footer.json');
define('BLOG_POSTS_FILE', DATA_DIR . '/blog_posts.json');
define('SITEMAP_FILE', __DIR__ . '/../sitemap.xml');

if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
}

function save_json($file, $data) {
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function load_json($file) {
    if (!file_exists($file)) return null;
    return json_decode(file_get_contents($file), true);
}

switch ($action) {
    case 'change_code':
        $newCode = $_POST['newCode'] ?? '';
        if (!$newCode) {
            echo json_encode(['success' => false, 'message' => 'New code is required']);
            exit;
        }
        $hash = password_hash($newCode, PASSWORD_DEFAULT);
        save_json(ACCESS_CODE_FILE, ['code_hash' => $hash]);
        echo json_encode(['success' => true, 'message' => 'Access code updated']);
        break;

    case 'get_menu_footer':
        $data = load_json(MENU_FOOTER_FILE);
        if (!$data) {
            $data = ['primaryMenu' => '[{"name":"Home","url":"index.html"},{"name":"About Us","url":"about.html"},{"name":"Contact Us","url":"contact.html"},{"name":"Privacy Policy","url":"privacy.html"}]', 'footerContent' => '&copy; 2024 SMTP Testing Tool. All rights reserved.'];
        }
        echo json_encode(['success' => true, 'data' => $data]);
        break;

    case 'save_menu_footer':
        $primaryMenu = $_POST['primaryMenu'] ?? '';
        $footerContent = $_POST['footerContent'] ?? '';
        if (!$primaryMenu || !$footerContent) {
            echo json_encode(['success' => false, 'message' => 'Menu and footer content are required']);
            exit;
        }
        save_json(MENU_FOOTER_FILE, ['primaryMenu' => $primaryMenu, 'footerContent' => $footerContent]);
        echo json_encode(['success' => true, 'message' => 'Menu and footer updated']);
        break;

    case 'get_blog_posts':
        $posts = load_json(BLOG_POSTS_FILE);
        if (!$posts) $posts = [];
        echo json_encode(['success' => true, 'posts' => $posts]);
        break;

    case 'save_blog_post':
        $postId = $_POST['postId'] ?? '';
        $postName = $_POST['postName'] ?? '';
        $postDescription = $_POST['postDescription'] ?? '';
        $postSlug = $_POST['postSlug'] ?? '';
        $postPublished = isset($_POST['postPublished']) && $_POST['postPublished'] === 'true';
        $postTime = $_POST['postTime'] ?? '';

        if (!$postName || !$postSlug || !$postTime) {
            echo json_encode(['success' => false, 'message' => 'Post name, slug, and time are required']);
            exit;
        }

        $posts = load_json(BLOG_POSTS_FILE);
        if (!$posts) $posts = [];

        if ($postId) {
            // Edit existing post
            foreach ($posts as &$post) {
                if ($post['id'] === $postId) {
                    $post['name'] = $postName;
                    $post['description'] = $postDescription;
                    $post['slug'] = $postSlug;
                    $post['published'] = $postPublished;
                    $post['time'] = $postTime;
                    break;
                }
            }
        } else {
            // Add new post
            $postId = uniqid();
            $posts[] = [
                'id' => $postId,
                'name' => $postName,
                'description' => $postDescription,
                'slug' => $postSlug,
                'published' => $postPublished,
                'time' => $postTime,
            ];
        }

        save_json(BLOG_POSTS_FILE, $posts);

        // Update sitemap.xml
        update_sitemap($posts);

        echo json_encode(['success' => true, 'message' => 'Blog post saved']);
        break;

    case 'delete_blog_post':
        $postId = $_POST['postId'] ?? '';
        if (!$postId) {
            echo json_encode(['success' => false, 'message' => 'Post ID is required']);
            exit;
        }
        $posts = load_json(BLOG_POSTS_FILE);
        if (!$posts) $posts = [];
        $posts = array_filter($posts, fn($post) => $post['id'] !== $postId);
        save_json(BLOG_POSTS_FILE, $posts);
        update_sitemap($posts);
        echo json_encode(['success' => true, 'message' => 'Blog post deleted']);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

function update_sitemap($posts) {
    $baseUrl = ''; // Set your base URL here if needed
    $urls = [
        $baseUrl . '/index.html',
        $baseUrl . '/about.html',
        $baseUrl . '/contact.html',
        $baseUrl . '/privacy.html',
    ];

    foreach ($posts as $post) {
        if ($post['published']) {
            $urls[] = $baseUrl . '/blog/' . $post['slug'] . '.html';
        }
    }

    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset></urlset>');
    $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    foreach ($urls as $url) {
        $urlElement = $xml->addChild('url');
        $urlElement->addChild('loc', htmlspecialchars($url));
        $urlElement->addChild('lastmod', date('Y-m-d'));
        $urlElement->addChild('changefreq', 'weekly');
        $urlElement->addChild('priority', '0.5');
    }

    $xml->asXML(SITEMAP_FILE);
}
?>
