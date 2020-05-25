<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examination_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('illness_presence');
            $table->string('unit_name')->nullable();
            $table->decimal('result_value')->nullable();
            $table->decimal('result_lowest_norm')->nullable();
            $table->decimal('result_highest_norm')->nullable();
            $table->bigInteger('added_by')->unsigned();
            $table->bigInteger('application_id')->unsigned();
            $table->timestamps();

            $table->foreign('added_by')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
            $table->foreign('application_id')
                ->references('id')->on('application_for_examinations')
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
        Schema::dropIfExists('examination_results');
    }
}
