<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-interaction event log for cards — powers time-based analytics
 * (activity over time, channel breakdown) beyond cumulative counters.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_card_id')->constrained()->cascadeOnDelete();
            $table->string('type');            // view | scan | save
            $table->string('channel')->nullable(); // qr | nfc | link
            $table->timestamps();

            $table->index(['business_card_id', 'created_at']);
            $table->index(['business_card_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_events');
    }
};
