<?php
session_start();
require_once '../includes/dynamic_content_new.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

define('ACCESS_CODE_FILE', SETTINGS_DIR . '/access_code.json');

function save_json($file, $data) {
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0755, true);
    }
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
        $data = get_menu_footer();
        echo json_encode(['success' => true, 'data' => $data]);
        break;

    case 'save_menu_footer':
        $primaryMenu = $_POST['primaryMenu'] ?? '';
        $footerContent = $_POST['footerContent'] ?? '';
        
        if (!$primaryMenu || !$footerContent) {
            echo json_encode(['success' => false, 'message' => 'Menu and footer content are required']);
            exit;
        }

        try {
            // Validate JSON format of primaryMenu
            $menuData = json_decode($primaryMenu, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid menu JSON format');
            }

            save_json(MENU_FOOTER_FILE, [
                'primaryMenu' => $menuData,
                'footerContent' => $footerContent
            ]);

            echo json_encode(['success' => true, 'message' => 'Menu and footer updated']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'get_blog_posts':
        $posts = get_blog_posts(false); // Get all posts, including unpublished
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

        $posts = get_blog_posts(false);
        if (!is_array($posts)) $posts = [];

        // Check for duplicate slug (except for the current post being edited)
        foreach ($posts as $post) {
            if ($post['slug'] === $postSlug && $post['id'] !== $postId) {
                echo json_encode(['success' => false, 'message' => 'A post with this slug already exists']);
                exit;
            }
        }

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

        save_json(BLOG_POSTS_FILE, array_values($posts));
        update_sitemap($posts);

        echo json_encode(['success' => true, 'message' => 'Blog post saved']);
        break;

    case 'delete_blog_post':
        $postId = $_POST['postId'] ?? '';
        if (!$postId) {
            echo json_encode(['success' => false, 'message' => 'Post ID is required']);
            exit;
        }

        $posts = get_blog_posts(false);
        if (!is_array($posts)) $posts = [];

        $posts = array_filter($posts, fn($post) => $post['id'] !== $postId);
        save_json(BLOG_POSTS_FILE, array_values($posts));
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
        $baseUrl . '/index.php',
        $baseUrl . '/about.php',
        $baseUrl . '/contact.php',
        $baseUrl . '/privacy.php',
        $baseUrl . '/blog/index.php',
    ];

    foreach ($posts as $post) {
        if ($post['published']) {
            $urls[] = $baseUrl . '/blog/template.php?slug=' . urlencode($post['slug']);
        }
    }

    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

    foreach ($urls as $url) {
        $urlElement = $xml->addChild('url');
        $urlElement->addChild('loc', htmlspecialchars($url));
        $urlElement->addChild('lastmod', date('Y-m-d'));
        $urlElement->addChild('changefreq', 'weekly');
        $urlElement->addChild('priority', '0.8');
    }

    $xml->asXML(__DIR__ . '/../sitemap.xml');
}
?>
