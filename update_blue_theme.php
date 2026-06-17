<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

// Replace zinc colors with the custom blue scale colors
$content = str_replace('"surface-container-highest": "#52525b"', '"surface-container-highest": "#213c5e"', $content);
$content = str_replace('"surface-container-high": "#3f3f46"', '"surface-container-high": "#14253d"', $content);
$content = str_replace('"surface-container": "#27272a"', '"surface-container": "#091426"', $content);
$content = str_replace('"surface-container-low": "#27272a"', '"surface-container-low": "#14253d"', $content);
$content = str_replace('"surface-container-lowest": "rgba(255,255,255,0.03)"', '"surface-container-lowest": "#050a13"', $content);
$content = str_replace('"surface-dim": "#18181b"', '"surface-dim": "#091426"', $content);
$content = str_replace('"surface-variant": "#27272a"', '"surface-variant": "#14253d"', $content);
$content = str_replace('"inverse-on-surface": "#18181b"', '"inverse-on-surface": "#091426"', $content);
$content = str_replace('"outline": "#52525b"', '"outline": "#213c5e"', $content);
$content = str_replace('bg-[#3f3f46]', 'bg-[#213c5e]', $content);
$content = str_replace('"surface-bright": "#3f3f46"', '"surface-bright": "#213c5e"', $content);

file_put_contents($file, $content);
echo "Blue dark theme applied!";
