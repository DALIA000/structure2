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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->json('title');
            $table->json('description');
            $table->double('price');
            $table->integer('type');
            $table->json('location');
            $table->json('address');
            $table->json('badge');
            $table->string('category');
            $table->unsignedBigInteger('rental_period')->nullable();
            $table->string('handover_date')->nullable();
            $table->string('community');
            $table->json('amenities');
            $table->string('agent')->nullable();
            $table->string('developer')->nullable();
            $table->boolean('furnishing')->default(0);
            $table->boolean('status')->default(0); //for highlighting
            $table->unsignedBigInteger('details')->nullable(); //
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
