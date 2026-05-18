<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_cards', function (Blueprint $table) {
            if (!Schema::hasColumn('business_cards', 'contacts_saved')) {
                $table->unsignedBigInteger('contacts_saved')->default(0)->after('views_count');
            }
            if (!Schema::hasColumn('business_cards', 'qr_scans')) {
                $table->unsignedBigInteger('qr_scans')->default(0)->after('contacts_saved');
            }
        });
    }

    public function down(): void
    {
        Schema::table('business_cards', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['contacts_saved', 'qr_scans'],
                fn($col) => Schema::hasColumn('business_cards', $col)
            ));
        });
    }
};
