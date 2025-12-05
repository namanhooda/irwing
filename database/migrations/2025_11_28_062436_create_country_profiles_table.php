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
         Schema::create('country_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id')->unique(); // One profile per country
            $table->string('capital')->nullable();
            $table->string('official_language')->nullable();
            $table->string('currency')->nullable();
            $table->text('political_structure')->nullable();
            $table->text('economic_overview')->nullable();
            $table->text('bilateral_ties')->nullable();
            $table->string('flag_image')->nullable(); // Image upload
            $table->string('profile_document')->nullable(); // PDF
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_profiles');
    }
};
