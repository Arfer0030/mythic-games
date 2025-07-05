<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('short_description');
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->string('image_url');
            $table->json('screenshots')->nullable();
            $table->json('genres');
            $table->string('developer');
            $table->string('publisher');
            $table->date('release_date');
            $table->enum('rating', ['E', 'T', 'M', 'AO'])->default('E');
            $table->decimal('user_rating', 3, 1)->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new_release')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_comming_soon')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};