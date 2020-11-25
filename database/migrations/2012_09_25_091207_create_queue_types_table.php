<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_types', function (Blueprint $table) {
            $table->increments('queue_type_id');
            $table->string('type');
            $table->string('color_regular');
            $table->string('color_pod');
            $table->unsignedSmallInteger('queue_limit_regular');
            $table->unsignedSmallInteger('queue_limit_pod');
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
        Schema::dropIfExists('queue_types');
    }
}
