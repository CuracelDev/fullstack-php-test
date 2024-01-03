<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->string('provider_name');
            $table->string('hmo_id')->constrained();
            $table->string('batch_identifier');
            $table->json('items');
            $table->float('amount', 12, 2);
            $table->timestamp('encounter_date');
            $table->timestamps();

            $table->index(['provider_name', 'hmo_id', 'batch_identifier']);
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
    }
}
