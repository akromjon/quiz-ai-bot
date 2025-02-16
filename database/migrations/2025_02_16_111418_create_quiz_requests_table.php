<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('uuid')->unique();
            $table->string('status')->default('pending');
            $table->longText('reason')->nullable();
            $table->longText('text');
            $table->longText('prompt')->nullable();
            $table->string('language')->default('UZBEK');
            $table->string('format')->default('text');
            $table->string('difficulty')->default('Intermediate');
            $table->unsignedInteger('number_of_question')->default(10);
            $table->unsignedInteger('number_of_generated_question')->default(0);
            $table->string('type')->default('multiple choice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_requests');
    }
};
