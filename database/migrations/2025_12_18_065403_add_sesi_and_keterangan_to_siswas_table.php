<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('siswas', 'jumlah_sesi')) {
                $table->integer('jumlah_sesi')->nullable()->after('email');
            }

            if (!Schema::hasColumn('siswas', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('jumlah_sesi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'jumlah_sesi')) {
                $table->dropColumn('jumlah_sesi');
            }

            if (Schema::hasColumn('siswas', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
