<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The company plan is now a single account with seats — there are no
 * separate member accounts and no invites. Drop the now-unused table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('company_invites');
    }

    public function down(): void
    {
        Schema::create('company_invites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->foreignId('invited_by')->constrained('users')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->string('token')->unique();
            $table->enum('status', ['pending', 'accepted', 'declined', 'expired'])->default('pending');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index(['email', 'status']);
            $table->unique(['company_id', 'email', 'status']);
        });
    }
};
