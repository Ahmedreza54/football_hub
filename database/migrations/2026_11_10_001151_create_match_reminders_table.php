<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_reminders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('match_id')
                ->unique()
                ->constrained('matches')
                ->cascadeOnDelete();

            $table->dateTime('reminder_at');

            $table->dateTime('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_reminders');
    }
};
