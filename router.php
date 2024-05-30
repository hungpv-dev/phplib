<?php
$request = $_SERVER['REQUEST_URI'];
// Remove query string for clean URL matching
$request = parse_url($request, PHP_URL_PATH);
// Check if the request is for a file that exists
if (file_exists(__DIR__ . $request)) {
    // Serve the requested file as is
    return false;
}
// Routing logic
if (preg_match('/^\/api\//', $request)) {
    require __DIR__ . '/api.php';
} else {
    require __DIR__ . '/index.php';
}
