<?php
define('SETTINGS_DIR', __DIR__ . '/../data/settings');
define('MENU_FOOTER_FILE', SETTINGS_DIR . '/menu_footer.json');
define('BLOG_POSTS_FILE', __DIR__ . '/../data/blog_posts.json');

function get_menu_footer() {
    if (!file_exists(MENU_FOOTER_FILE)) {
        $default_content = [
            'primaryMenu' => [
                ['name' => 'Home', 'url' => 'index.php'],
                ['name' => 'About Us', 'url' => 'about.php'],
                ['name' => 'Blog', 'url' => 'blog/index.php'],
                ['name' => 'Contact Us', 'url' => 'contact.php'],
                ['name' => 'Privacy Policy', 'url' => 'privacy.php']
            ],
            'footerContent' => '&copy; 2024 SMTP Testing Tool. All rights reserved.'
        ];
        
        if (!is_dir(SETTINGS_DIR)) {
            mkdir(SETTINGS_DIR, 0755, true);
        }
        
        file_put_contents(MENU_FOOTER_FILE, json_encode($default_content, JSON_PRETTY_PRINT));
        return $default_content;
    }
    
    $content = json_decode(file_get_contents(MENU_FOOTER_FILE), true);
    return $content ?? [];
}

function render_menu() {
    $data = get_menu_footer();
    if (empty($data['primaryMenu'])) return '';
    
    // Determine the current page
    $current_page = basename($_SERVER['PHP_SELF']);
    
    $menu = '';
    foreach ($data['primaryMenu'] as $item) {
        $is_current = ($item['url'] === $current_page);
        $class = 'hover:text-blue-600 transition-colors duration-300';
        if ($is_current) {
            $class .= ' text-blue-600 font-bold';
        }
        $menu .= sprintf(
            '<li><a href="%s" class="%s">%s</a></li>',
            htmlspecialchars($item['url']),
            $class,
            htmlspecialchars($item['name'])
        );
    }
    return $menu;
}

function render_footer() {
    $data = get_menu_footer();
    return $data['footerContent'] ?? '';
}

function get_blog_posts($published_only = true) {
    if (!file_exists(BLOG_POSTS_FILE)) {
        return [];
    }
    
    $posts = json_decode(file_get_contents(BLOG_POSTS_FILE), true) ?? [];
    
    if ($published_only) {
        $posts = array_filter($posts, fn($post) => $post['published']);
    }
    
    // Sort by time (newest first)
    usort($posts, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));
    
    return $posts;
}

function get_blog_post_by_slug($slug) {
    $posts = get_blog_posts(true);
    foreach ($posts as $post) {
        if ($post['slug'] === $slug) {
            return $post;
        }
    }
    return null;
}

function format_date($date_string) {
    return date('F j, Y', strtotime($date_string));
}

// Initialize settings directory if it doesn't exist
if (!is_dir(SETTINGS_DIR)) {
    mkdir(SETTINGS_DIR, 0755, true);
}
?>
