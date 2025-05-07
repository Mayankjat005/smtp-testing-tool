<?php
function get_menu_footer() {
    $file = __DIR__ . '/../data/menu_footer.json';
    if (file_exists($file)) {
        $content = json_decode(file_get_contents($file), true);
        return $content ?? [
            'primaryMenu' => [
                ['name' => 'Home', 'url' => 'index.html'],
                ['name' => 'About Us', 'url' => 'about.html'],
                ['name' => 'Contact Us', 'url' => 'contact.html'],
                ['name' => 'Privacy Policy', 'url' => 'privacy.html']
            ],
            'footerContent' => '&copy; 2024 SMTP Testing Tool. All rights reserved.'
        ];
    }
    return null;
}

function render_menu() {
    $data = get_menu_footer();
    if (!$data) return '';
    
    $menu = '';
    foreach ($data['primaryMenu'] as $item) {
        $menu .= sprintf(
            '<li><a href="%s" class="hover:text-blue-600 transition-colors duration-300">%s</a></li>',
            htmlspecialchars($item['url']),
            htmlspecialchars($item['name'])
        );
    }
    return $menu;
}

function render_footer() {
    $data = get_menu_footer();
    return $data ? $data['footerContent'] : '';
}
?>
