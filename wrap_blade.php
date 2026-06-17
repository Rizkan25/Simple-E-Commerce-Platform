<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

if (strpos(trim($content), '<style>') === 0) {
    $content = "<div>\n" . $content . "\n</div>";
    file_put_contents($file, $content);
    echo "Wrapped in a single div.";
} else {
    echo "Looks like it might already be wrapped. First chars: " . substr(trim($content), 0, 20);
}
