<?php
$file = 'resources/views/filament/pages/stitch-dashboard.blade.php';
$content = file_get_contents($file);

// Remove the hardcoded light wrapper
$content = str_replace('<div class="bg-[#fbf8fa] text-[#1b1b1d] rounded-xl overflow-hidden">', '<div>', $content);

// Replace the tailwind config colors with dark mode equivalents
$pattern = '/"colors":\s*\{.*?\}/s';
$darkColors = '
                    "colors": {
                        "surface-container-high": "#3f3f46",
                        "primary-container": "#1e293b",
                        "on-tertiary-fixed": "#2a1700",
                        "on-error": "#ffffff",
                        "on-secondary-container": "#00714d",
                        "surface-container-low": "#27272a",
                        "on-secondary-fixed-variant": "#005236",
                        "on-tertiary-container": "#c88000",
                        "surface-bright": "#3f3f46",
                        "tertiary": "#201100",
                        "on-secondary-fixed": "#002113",
                        "surface-variant": "#27272a",
                        "on-surface": "#f4f4f5",
                        "background": "transparent",
                        "inverse-surface": "#f4f4f5",
                        "outline": "#52525b",
                        "secondary-fixed": "#6ffbbe",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "primary": "#ffffff",
                        "inverse-primary": "#bcc7de",
                        "inverse-on-surface": "#18181b",
                        "secondary": "#4edea3",
                        "surface": "transparent",
                        "on-tertiary": "#ffffff",
                        "on-background": "#f4f4f5",
                        "on-tertiary-fixed-variant": "#653e00",
                        "primary-fixed": "#d8e3fb",
                        "surface-container": "#27272a",
                        "on-surface-variant": "#a1a1aa",
                        "on-secondary": "#ffffff",
                        "tertiary-container": "#3c2300",
                        "error": "#ffb4ab",
                        "on-primary-fixed-variant": "#3c475a",
                        "secondary-container": "#005236",
                        "surface-tint": "#bcc7de",
                        "tertiary-fixed": "#ffddb8",
                        "tertiary-fixed-dim": "#ffb95f",
                        "on-primary-container": "#d8e3fb",
                        "on-primary": "#091426",
                        "surface-container-highest": "#52525b",
                        "on-primary-fixed": "#111c2d",
                        "surface-dim": "#18181b",
                        "surface-container-lowest": "rgba(255,255,255,0.03)",
                        "secondary-fixed-dim": "#4edea3",
                        "outline-variant": "rgba(255,255,255,0.1)",
                        "primary-fixed-dim": "#bcc7de"
                    }';
$content = preg_replace($pattern, trim($darkColors), $content);

// Small adjustments to inline styles
$content = preg_replace('/background: linear-gradient\(180deg, rgba\(9, 20, 38, 0.05\) 0%, rgba\(255, 255, 255, 0\) 100%\);/', 'background: linear-gradient(180deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0) 100%);', $content);

// Make standard buttons more visible
$content = str_replace('bg-white shadow-sm rounded text-primary', 'bg-[#3f3f46] shadow-sm rounded text-white', $content);
$content = str_replace('bg-primary text-white', 'bg-amber-500 text-gray-900', $content);

file_put_contents($file, $content);
echo "Dark theme applied!";
