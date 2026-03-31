<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hardware', function (Blueprint $table) {
            $table->unsignedInteger('loan_duration_days')->default(7)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('hardware', function (Blueprint $table) {
            $table->dropColumn('loan_duration_days');
        });
    }
};
