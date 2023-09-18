<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function testConnection()
    {
        try {
            DB::connection()->getPdo();
            return "Connected successfully to the database.";
        } catch (\Exception $e) {
            return "Database connection error: " . $e->getMessage();
        }
    }
}
