<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_by')->nullable();
            $table->string('action')->comment('Create, Update, Delete');
            $table->string('subject')->comment('Model name');
            $table->dateTime('log_time');
            $table->string('ip');
            $table->text('browser');
            $table->longText('changes');
            $table->text('note')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('record_id');

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->foreign('action_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
