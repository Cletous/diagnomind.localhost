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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // doctor who created it
            $table->timestamps();
        });

        Schema::create('hospital_doctor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('diagnosis_requests', function (Blueprint $table) {
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals')->nullOnDelete()->cascadeOnUpdate()->after('patient_id');
        });

        Schema::create('doctor_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->text('review');
            $table->tinyInteger('rating')->comment('1 to 5');
            $table->timestamps();
        });

        Schema::create('hospital_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->text('review');
            $table->tinyInteger('rating')->comment('1 to 5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
        Schema::dropIfExists('hospital_doctor');
        Schema::dropIfExists('doctor_reviews');
        Schema::dropIfExists('hospital_reviews');
    }
};
