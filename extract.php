<?php
$html = file_get_contents('storage/app/stitch-dashboard.html');

preg_match('/<script id="tailwind-config">.*?<\/style>/s', $html, $headMatches);
preg_match('/<!-- Dashboard Content -->(.*?)<\/main>/s', $html, $bodyMatches);
preg_match('/<script>.*?<\/script>\s*<\/body>/s', $html, $scriptMatches);

$blade = "<x-filament-panels::page>\n\n";
$blade .= "<script src=\"https://cdn.tailwindcss.com?plugins=forms,container-queries\"></script>\n";

if (isset($headMatches[0])) {
    $blade .= $headMatches[0] . "\n";
}

if (isset($bodyMatches[1])) {
    $blade .= $bodyMatches[1] . "\n";
}

if (isset($scriptMatches[0])) {
    $blade .= str_replace('</body>', '', $scriptMatches[0]) . "\n";
}

$blade .= "</x-filament-panels::page>";

file_put_contents('resources/views/filament/pages/stitch-dashboard.blade.php', $blade);
echo "Extraction completed successfully!";
