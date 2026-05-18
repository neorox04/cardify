<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_cards', function (Blueprint $table) {
            $table->unsignedBigInteger('contacts_saved')->default(0)->after('views_count');
            $table->unsignedBigInteger('qr_scans')->default(0)->after('contacts_saved');
        });
    }

    public function down(): void
    {
        Schema::table('business_cards', function (Blueprint $table) {
            $table->dropColumn(['contacts_saved', 'qr_scans']);
        });
    }
};
