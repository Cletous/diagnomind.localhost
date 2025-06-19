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
        Schema::create('ai_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->longText('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_feedback');
    }
};
