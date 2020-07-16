<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->string('price');
            $table->string('pix');
            $table->enum('age_limit_status', ['yes', 'no']);
            $table->string('start_age_range')->nullable();
            $table->string('end_age_range')->nullable();
            $table->enum('coupon_status', ['yes', 'no']);
            $table->string('coupon_id')->nullable();
            $table->enum('frequency_limit_status', ['yes', 'no']);
            $table->string('frequency_limit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
