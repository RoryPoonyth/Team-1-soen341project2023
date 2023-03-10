<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->string('company');
            $table->string('location');
            $table->string('logo')->nullable();
            $table->boolean('is_highlighted')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('content');
            $table->boolean('apply_link');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    
    public function down(): void
    {
        Schema::dropIfExists('postings');
    }
};
