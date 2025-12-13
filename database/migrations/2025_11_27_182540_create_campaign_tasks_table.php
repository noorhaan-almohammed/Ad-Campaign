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
        Schema::create('campaign_tasks', function (Blueprint $table) {
            $table->id();
             $table->foreignId('campaign_id')->constrained()->noActionOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('reward', 10, 2)->default(0); // مكافأة المهمة للناشر
            $table->integer('max_completions')->default(0); // العدد المسموح للمشاركين
            $table->enum('status', ['active', 'paused', 'ended'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_tasks');
    }
};
