<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('uitleen', function (Blueprint $table) {
            $table->string('status')->default('pending'); // pending/approved/rejected/returned
        });
    }

    public function down(): void
    {
        Schema::table('uitleen', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};