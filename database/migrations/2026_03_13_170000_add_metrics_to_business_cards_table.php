<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('business_cards', function (Blueprint $table) {
            $table->unsignedInteger('qr_scans')->default(0);
            $table->unsignedInteger('contacts_saved')->default(0);
        });
    }

    public function down()
    {
        Schema::table('business_cards', function (Blueprint $table) {
            $table->dropColumn(['qr_scans', 'contacts_saved']);
        });
    }
};
