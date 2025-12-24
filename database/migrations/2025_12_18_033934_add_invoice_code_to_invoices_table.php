<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_code')->nullable()->after('id');
            $table->string('order_id')->nullable()->after('invoice_code');
            $table->timestamp('paid_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['invoice_code', 'order_id', 'paid_at']);
        });
    }
};
