<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'shipped'])->nullable();
            $table->enum('transaction_status', ['unpaid','pending','completed','cancel'])->default('unpaid');
            $table->string('transaction_id')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->string('payment_type')->nullable();
            $table->string('shipping');
            $table->integer('subtotal');
            $table->integer('grand_total');
            $table->string('pdf_url')->nullable();
            $table->dateTime('transaction_time')->nullable();
            $table->dateTime('transaction_expire')->nullable();
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('resi')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('product_id');
            $table->integer('quantity');
            $table->integer('subtotal');
            $table->timestamps();
        });

        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('province_id');
            $table->string('regency_id');
            $table->string('district_id');
            $table->string('village_id');
            $table->string('detail_address');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('order_addresses');
    }
};
