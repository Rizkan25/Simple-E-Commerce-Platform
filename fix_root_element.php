<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

// Remove existing x-filament-panels::page wrappers if any
$content = str_replace('<x-filament-panels::page>', '', $content);
$content = str_replace('</x-filament-panels::page>', '', $content);

// Wrap everything cleanly in a single div
$content = "<div>\n" . trim($content) . "\n</div>";

file_put_contents($file, $content);
echo "Cleanly wrapped in a single div!";
