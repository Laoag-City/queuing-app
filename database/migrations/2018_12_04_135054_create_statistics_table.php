<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('stat_id');
            $table->integer('queue_type_id')->unsigned()->nullable();
            $table->date('date');
            $table->smallInteger('total_regular')->unsigned()->nullable();
            $table->smallInteger('total_pod')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('queue_type_id')
                                    ->references('queue_type_id')
                                    ->on('queue_types')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
