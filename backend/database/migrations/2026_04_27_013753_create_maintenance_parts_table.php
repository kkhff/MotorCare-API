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
        Schema::create('maintenance_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorcycle_id')->constrained()->onDelete('cascade');
            $table->string('part_name');
            $table->integer('interval_km');
            $table->decimal('last_replace_km', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_parts');
    }
};
