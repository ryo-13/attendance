<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('残業ID') ;
            $table->unsignedBiginteger('attendance_id')->comment('出退勤ID');
            $table->time('overtime')->comment('残業時間');
            $table->string('overtime_reason')->comment('残業理由');
            $table->boolean('is_permitted')->comment('残業許可');
            $table->timestamps();

            $table->foreign('attendance_id')->references('id')->on('attendances');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overtimes');
    }
}
