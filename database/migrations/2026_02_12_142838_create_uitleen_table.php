<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uitleen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hardware_id')->constrained('hardware')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable();

            $table->unsignedInteger('quantity')->default(1);
            $table->dateTime('loaned_at')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->boolean('is_returned')->default(false);
            $table->string('borrower_name')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uitleen');
    }
};
