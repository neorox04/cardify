<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Contacts shared back by a visitor after scanning someone's card —
 * the reciprocity loop. Delivered by email and/or a short-lived QR, and
 * always kept in the recipient's "received contacts" list.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shared_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipient_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('token', 40)->unique();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('method');            // email | qr
            $table->timestamp('expires_at')->nullable(); // for the live QR
            $table->timestamps();

            $table->index(['recipient_user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shared_contacts');
    }
};
