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
            $table->string('name');
            $table->double('amount', 12, 2);
            $table->double('old_amount', 12, 2);
            $table->string('img_url');
            $table->integer('age_limit')->nullable();
            $table->integer('time_limit')->nullable();
            $table->integer('purchase_frequency')->nullable();
            $table->integer('quantity')->default(0);
            $table->enum('duration', ['Months', 'Year'])->nullable();
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
        Schema::dropIfExists('products');
    }
}
