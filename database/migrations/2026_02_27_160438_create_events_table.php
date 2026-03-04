<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Públicos
            $table->string('title');
            $table->text('description');
            $table->dateTime('event_date');

            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->foreignId('knowledge_area_id')->constrained()->cascadeOnDelete();

            $table->enum('modality', ['presencial', 'online', 'hibrido']);
            $table->string('address')->nullable();

            $table->string('event_link');
            $table->string('registration_link')->nullable();

            $table->boolean('is_paid')->default(false);
            $table->boolean('has_interpreter')->default(false);
            $table->boolean('is_accessible')->default(false);


            $table->text('accessibility_notes')->nullable();

            $table->string('banner');
            $table->string('banner_alt_text');

            $table->enum('status', ['pendente', 'aprovado', 'rejeitado'])
                  ->default('pendente');

            // Internos (não públicos)
            $table->string('responsible_name');
            $table->string('responsible_phone');
            $table->string('responsible_email');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};