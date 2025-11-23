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
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('studentname');
            $table->string('student_id');
            $table->string('student_type');
            $table->string('year')->nullable();
            $table->string('batch_year')->nullable();
            $table->string('course');
            $table->date('request_date')->nullable();
            $table->date('claimed_date')->nullable();
            $table->string('reference_number')->unique();
            $table->decimal('total_amount', 8, 2)->default(0);
            $table->enum('status', [
                'Pending',
                'Receipt Uploaded',
                'Under Verification',
                'Processing',
                'Ready for Pick-up',
                'Completed',
                'Cancelled'
            ])->default('Pending');
            $table->longText('remarks')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
