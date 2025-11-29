<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'admin@example.com')->first();
if (! $u) {
    echo "NO_USER\n";
    exit(1);
}

$u->password = Illuminate\Support\Facades\Hash::make('password');
$u->save();

echo "RESET_OK\n";
