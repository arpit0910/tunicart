<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentDetailsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('payment_method')->default('UPI');
            $table->string('payment_status')->default('pending');
            $table->string('transaction_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['city', 'pincode', 'payment_method', 'payment_status', 'transaction_id']);
        });
    }
}
