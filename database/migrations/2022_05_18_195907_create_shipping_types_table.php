<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingTypesTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('price')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_types');
    }
}
