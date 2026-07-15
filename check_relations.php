<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Employee;
$employees = Employee::with('services')->get();
foreach ($employees as $emp) {
    echo $emp->user->name . ': ' . $emp->services->count() . ' services' . PHP_EOL;
}
?>