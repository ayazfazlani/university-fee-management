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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->unique()->onDelete('cascade');
            $table->foreignId('section_id')->unsignedBigInt()->onDelete('cascade');
            $table->string('roll_number')->unique();
            $table->integer('status')->default('0');
            $table->decimal('fee_amount', 10, 2); // Fixed fee for every semester
            $table->date('admission_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
