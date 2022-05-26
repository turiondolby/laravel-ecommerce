<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('email');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('shipping_addresses_id')->constrained();
            $table->foreignId('shipping_type_id')->constrained();
            $table->integer('subtotal');
            $table->timestamp('placed_at');
            $table->timestamp('packaged_at');
            $table->timestamp('shipped_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
