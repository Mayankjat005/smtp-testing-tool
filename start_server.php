<?php
// Kill any existing process on port 8000
exec("kill -9 $(lsof -t -i:8000) 2>/dev/null");

// Start PHP server
$command = "php -S localhost:8000";
echo "Starting server...\n";
echo "Access the site at: http://localhost:8000/\n";
echo "Access admin panel at: http://localhost:8000/admin/\n";
echo "Default admin code: 772889\n";
echo "Press Ctrl+C to stop the server\n";
passthru($command);
?>
