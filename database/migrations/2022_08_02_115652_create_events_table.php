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
        Schema::create('events', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('description');
            $table->string('location');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('pre_registration_enabled')->default(true);
            $table->boolean('team_registration_enabled')->default(false);
            $table->boolean('closed')->default(false);
            $table->integer('limit')->default(0);
            $table->string('preview_image')->nullable();
            $table->boolean('public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
