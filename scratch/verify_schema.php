<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = [
    'customers',
    'customer_subscriptions',
    'bandwidth_packages',
    'monthly_invoices',
    'package_mutations',
    'service_suspensions',
    'service_terminations',
    'tickets',
];

echo "--------------------------------------------------------\n";
echo "DATABASE VERIFICATION REPORT\n";
echo "--------------------------------------------------------\n";

foreach ($tables as $table) {
    if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
        $count = \Illuminate\Support\Facades\DB::table($table)->count();
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
        echo "✅ Table: {$table} [{$count} records]\n";
        echo "   Columns (" . count($columns) . "): " . implode(', ', $columns) . "\n\n";
    } else {
        echo "❌ Table: {$table} NOT FOUND!\n\n";
    }
}
