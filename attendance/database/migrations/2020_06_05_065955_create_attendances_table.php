<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('出退勤ID');
            $table->unsignedBigInteger('user_id')->comment('作業者ID');
            $table->date('date')->nullable()->comment('日付');
            $table->time('arrival')->nullable()->comment('出社時間');
            $table->time('leave')->nullable()->comment('退社時間');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
