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
        Schema::create('table', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('table_occupation', function (Blueprint $table) {
            $table->id();
            $table->date('birthdate');
            $table->boolean('has_deluxe_menu');
            $table->timestamps();
        });

        Schema::create('table_guest', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('table')->onDelete('cascade');
            $table->foreignId('guest_id')->constrained('table_guest')->onDelete('cascade');
            $table->dateTime('datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table');
        Schema::dropIfExists('table_occupation');
        Schema::dropIfExists('table_guest');
    }
};
