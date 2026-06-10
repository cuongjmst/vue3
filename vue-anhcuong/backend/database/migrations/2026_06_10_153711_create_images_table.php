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
        Schema::create('images', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            $table->string('url');

            $table->string('role')->nullable();

            $table->timestamp('last_modified_date')
                  ->nullable();

            $table->foreignId('last_modified_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};