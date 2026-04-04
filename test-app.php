<?php
/**
 * Simple test script to verify PHP and Laravel dependencies
 */

echo "Testing Satria Eko Application Setup\n";
echo "====================================\n\n";

// Check PHP version
echo "1. PHP Version: " . PHP_VERSION . "\n";
if (version_compare(PHP_VERSION, '5.6.4', '>=')) {
    echo "   ✓ PHP version meets requirements (>= 5.6.4)\n";
} else {
    echo "   ✗ PHP version too low. Required: >= 5.6.4\n";
}

// Check required extensions
$required_extensions = [
    'pdo_mysql',
    'mbstring',
    'tokenizer',
    'xml',
    'openssl',
    'json',
    'curl',
    'gd',
    'zip'
];

echo "\n2. Checking PHP extensions:\n";
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "   ✓ $ext\n";
    } else {
        echo "   ✗ $ext (MISSING)\n";
    }
}

// Check composer autoload
echo "\n3. Checking Composer autoload:\n";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "   ✓ Composer autoload found\n";
    
    // Try to load Laravel
    require_once __DIR__ . '/vendor/autoload.php';
    
    if (file_exists(__DIR__ . '/bootstrap/app.php')) {
        echo "   ✓ Laravel bootstrap found\n";
    } else {
        echo "   ✗ Laravel bootstrap not found\n";
    }
} else {
    echo "   ✗ Composer autoload not found. Run: composer install\n";
}

// Check .env file
echo "\n4. Checking environment configuration:\n";
if (file_exists(__DIR__ . '/.env')) {
    echo "   ✓ .env file exists\n";
    
    $env_content = file_get_contents(__DIR__ . '/.env');
    if (strpos($env_content, 'APP_KEY=') !== false) {
        echo "   ✓ Application key is set\n";
    } else {
        echo "   ✗ Application key not found. Run: php artisan key:generate\n";
    }
} else {
    echo "   ✗ .env file not found. Copy from .env.example\n";
}

// Check storage permissions
echo "\n5. Checking directory permissions:\n";
$directories = [
    'storage' => 755,
    'bootstrap/cache' => 755
];

foreach ($directories as $dir => $expected_perms) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -3);
        if ($perms >= $expected_perms) {
            echo "   ✓ $dir permissions: $perms\n";
        } else {
            echo "   ✗ $dir permissions: $perms (should be at least $expected_perms)\n";
        }
    } else {
        echo "   ✗ $dir directory not found\n";
    }
}

echo "\n====================================\n";
echo "Test completed.\n";

if (PHP_SAPI === 'cli') {
    echo "Run the application with: php artisan serve\n";
} else {
    echo "Application should be accessible via web server\n";
}