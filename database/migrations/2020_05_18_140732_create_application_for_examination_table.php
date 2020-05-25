<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationForExaminationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_for_examinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('patient_id')->unsigned();
            $table->bigInteger('examination_id')->unsigned();
            $table->bigInteger('applied_by_id')->unsigned();
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
            $table->foreign('applied_by_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
            $table->foreign('examination_id')
                ->references('id')->on('examinations')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_for_examination');
    }
}
