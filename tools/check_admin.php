<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('email', 'admin@example.com')->first();
if (! $u) {
    echo "NO_USER\n";
    exit(0);
}

$passOk = Illuminate\Support\Facades\Hash::check('password', $u->password) ? 'YES' : 'NO';
echo "ID:{$u->id} | ROLE:{$u->role} | PASS_OK:{$passOk}\n";
