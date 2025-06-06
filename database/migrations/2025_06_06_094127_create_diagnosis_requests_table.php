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
        Schema::create('diagnosis_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade')->cascadeOnUpdate();
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->longText('prompt');
            $table->longText('ai_response')->nullable();
            $table->enum('rating', ['like', 'dislike', 'none'])->default('none');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_requests');
    }
};
