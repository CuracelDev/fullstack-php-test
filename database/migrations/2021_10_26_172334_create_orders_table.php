<?php

use App\Enums\OrderStatus;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Provider;
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
            $table->foreignIdFor(Provider::class, 'provider_id')->constrained();
            $table->foreignIdFor(Hmo::class, 'hmo_id')->constrained();
            $table->foreignIdFor(Batch::class, 'batch_id')->nullable()->constrained();
            $table->enum('status', [
                OrderStatus::PENDING->value,
                OrderStatus::PROCESSING->value,
                OrderStatus::COMPLETED->value,
            ])->default(OrderStatus::PENDING->value);
            $table->json('items');
            $table->date('encounter_date');
            $table->date('sent_date');
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
    }
};
