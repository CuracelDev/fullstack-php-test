<?php

use App\Enums\HmoBatchCriteria;
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
        Schema::create('hmos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('email');
            $table->enum('batch_by', [HmoBatchCriteria::SUBMIT_DATE->value, HmoBatchCriteria::ENCOUNTER_DATE->value])->default(HmoBatchCriteria::ENCOUNTER_DATE->value);
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
        Schema::dropIfExists('hmos');
    }
};
