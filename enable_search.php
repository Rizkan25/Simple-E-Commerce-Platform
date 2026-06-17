<?php
$resources = glob('app/Filament/Resources/*/*Resource.php');
foreach ($resources as $file) {
    $content = file_get_contents($file);
    
    // Determine title attribute based on file name
    $attr = 'name';
    if (strpos($file, 'OrderResource') !== false) $attr = 'order_number';
    if (strpos($file, 'DisputeResource') !== false) $attr = 'id';
    if (strpos($file, 'WithdrawalResource') !== false) $attr = 'id';
    
    if (strpos($content, '$recordTitleAttribute') === false) {
        $content = preg_replace(
            '/(protected static.*?\$navigationIcon.*?;)/', 
            "protected static ?string \$recordTitleAttribute = '$attr';\n    $1", 
            $content
        );
        file_put_contents($file, $content);
        echo 'Updated: ' . $file . PHP_EOL;
    }
}
echo "Done.\n";
