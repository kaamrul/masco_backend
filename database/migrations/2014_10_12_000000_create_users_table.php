<?php

use App\Library\Enum;
use Illuminate\Support\Facades\DB;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('password');
            $table->enum('user_type', array_keys(Enum::getUserType()));
            $table->string('gender')->nullable()->comment('Comes from config');
            $table->string('dob')->nullable();;
            $table->string('location')->nullable();
            $table->enum('status', array_keys(Enum::getStatus()))->default(Enum::STATUS_PENDING)->comment('1 = PENDING, 2 = ACTIVE, 3 = INACTIVE');
            $table->string('avatar', 255)->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('operator_id')->references('id')->on('users');
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
};
