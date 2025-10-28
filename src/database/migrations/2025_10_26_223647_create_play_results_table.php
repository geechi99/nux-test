<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('play_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade');
            $table->integer('random_number');
            $table->boolean('win');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('play_results');
    }
};
