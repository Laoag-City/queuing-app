<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->integer('queue_type_id')->unsigned()->nullable();
            $table->string('username', 30)->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->string('window_number', 2)->nullable();
            $table->integer('current_regular_queue_number')->unsigned()->nullable();
            $table->integer('current_pod_queue_number')->unsigned()->nullable();
            $table->boolean('is_currently_serving_regular')->default(null)->nullable();
            $table->string('picture_path');
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
        Schema::dropIfExists('users');
    }
}
