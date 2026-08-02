<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beverages', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
        });

        Schema::create('bottles', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->string('img_src');
        });

        Schema::create('filled_bottles', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->foreignId('bottle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('beverage_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filled_bottles');
        Schema::dropIfExists('bottles');
        Schema::dropIfExists('beverages');
    }
};
