<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

$replacements = [
    // Colors
    'bg-primary-fixed' => 'bg-amber-500',
    'text-on-primary-fixed' => 'text-amber-900',
    'bg-tertiary-fixed' => 'bg-orange-200',
    'text-on-tertiary-fixed' => 'text-orange-900',
    'text-secondary' => 'text-emerald-400',
    'text-error' => 'text-red-400',
    'text-primary' => 'text-amber-500',
    'bg-secondary-container' => 'bg-emerald-900/50',
    'text-on-secondary-container' => 'text-emerald-300',
    'bg-error-container' => 'bg-red-900/50',
    'text-on-error-container' => 'text-red-300',
    'bg-primary-container' => 'bg-amber-900/50',
    'text-on-primary-container' => 'text-amber-300',

    // Spacing
    'gap-gutter' => 'gap-4',
    'gap-xs' => 'gap-1',
    'gap-sm' => 'gap-2',
    'gap-md' => 'gap-4',
    'gap-lg' => 'gap-6',
    
    'mt-xs' => 'mt-1',
    'mt-sm' => 'mt-2',
    'mt-md' => 'mt-4',
    'mt-lg' => 'mt-6',
    'mt-xl' => 'mt-8',
    
    'mb-xs' => 'mb-1',
    'mb-sm' => 'mb-2',
    'mb-md' => 'mb-4',
    'mb-lg' => 'mb-6',
    'mb-xl' => 'mb-8',
    
    'p-xs' => 'p-1',
    'p-sm' => 'p-2',
    'p-md' => 'p-4',
    'p-lg' => 'p-6',
    
    'px-xs' => 'px-1',
    'px-sm' => 'px-2',
    'px-md' => 'px-4',
    'px-lg' => 'px-6',
    
    'py-xs' => 'py-1',
    'py-sm' => 'py-2',
    'py-md' => 'py-4',
    'py-lg' => 'py-6',

    // Typography
    'text-display-sm' => 'text-2xl font-bold tracking-tight',
    'text-headline-sm' => 'text-xl font-bold',
    'text-body-md' => 'text-base',
    'text-body-sm' => 'text-sm',
    'text-label-md' => 'text-sm font-semibold',
    'text-data-mono' => 'text-sm font-mono',
];

// Sort by length descending to prevent partial replacements (e.g. mb-sm vs mb-small)
uksort($replacements, function($a, $b) {
    return strlen($b) - strlen($a);
});

foreach ($replacements as $search => $replace) {
    // Regex to ensure we only replace full words within classes
    $content = preg_replace('/\b' . preg_quote($search, '/') . '\b/', $replace, $content);
}

file_put_contents($file, $content);
echo "Replacements done.";
