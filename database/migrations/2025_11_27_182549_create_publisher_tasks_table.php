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
        Schema::create('publisher_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publisher_id')->constrained('users')->noActionOnDelete();
            $table->foreignId('campaign_id')->constrained()->noActionOnDelete();
            $table->foreignId('campaign_task_id')->constrained()->noActionOnDelete();
            $table->enum('status', ['pending','waiting_review','approved', 'rejected'])->default('pending');
            $table->decimal('reward', 10, 2)->default(0);
            $table->string('proof_file')->nullable(); // صورة إثبات أو رابط
            $table->string('proof_link')->nullable(); // صورة إثبات أو رابط
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publisher_tasks');
    }
};
