<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('operator_id');
            $table->string('home_street_address', 255)->nullable();
            $table->string('home_suburb', 255)->nullable();
            $table->string('home_city', 255)->nullable();
            $table->integer('home_post_code')->nullable();
            $table->string('home_latitude', 255)->nullable();
            $table->string('home_longitude', 255)->nullable();
            $table->string('postal_street_address', 255)->nullable();
            $table->string('postal_suburb', 255)->nullable();
            $table->string('postal_city', 255)->nullable();
            $table->integer('postal_post_code')->nullable();
            $table->string('postal_latitude')->nullable();
            $table->string('postal_longitude')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('operator_id')->references('id')->on('users');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
