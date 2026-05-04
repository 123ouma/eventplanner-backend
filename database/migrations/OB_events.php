<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ob_events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            // Datetime obligatoire (date + heure)
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->string('place');
            $table->decimal('price', 8, 2)->default(0);
            $table->boolean('is_free')->default(false);

            $table->integer('capacity');
            $table->string('image')->nullable();

            $table->foreignId('category_id')
                  ->constrained('ob_categories')
                  ->cascadeOnDelete();

            // Créateur de l’event (admin )
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ob_events');
    }
};
