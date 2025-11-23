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
       Schema::create('document_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_request_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('category');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('total_price', 8, 2)->default(0);
            $table->string('purpose')->nullable();
            $table->longtext('message')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_request_items');
    }
};
