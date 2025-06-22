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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('table_guests', function (Blueprint $table) {
            $table->id();
            $table->date('birthdate');
            $table->boolean('has_deluxe_menu');
            $table->timestamps();
        });

        Schema::create('table_occupations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->foreignId('guest_id')->constrained('table_guests')->onDelete('cascade');
            $table->dateTime('datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
        Schema::dropIfExists('table_occupations');
        Schema::dropIfExists('table_guests');
    }
};
