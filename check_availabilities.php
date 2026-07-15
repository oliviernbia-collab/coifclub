<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Availability;

echo 'Availabilities count: ' . Availability::count() . PHP_EOL;
$availabilities = Availability::all();
foreach ($availabilities as $a) {
    echo $a->employee_id . ' - ' . $a->day_of_week . ' - ' . $a->start_time . ' to ' . $a->end_time . ' (' . ($a->is_active ? 'active' : 'inactive') . ')' . PHP_EOL;
}
?>