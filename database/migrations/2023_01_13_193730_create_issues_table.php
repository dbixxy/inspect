<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspect_id');
            $table->foreign('inspect_id')->references('id')->on('inspects');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->integer('position_x')->default(0);
            $table->integer('position_y')->default(0);
            $table->unsignedInteger('number');
            $table->text('problem');
            $table->text('suggest');
            $table->boolean('is_closed')->default(false);
            $table->unsignedBigInteger('ref_issue_id')->nullable();
            $table->foreign('ref_issue_id')->references('id')->on('issues');
            
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
        Schema::dropIfExists('issues');
    }
}
