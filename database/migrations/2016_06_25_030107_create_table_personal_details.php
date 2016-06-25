<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePersonalDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', '128');
            $table->enum('gender', ['m', 'f']);
            $table->string('phone', '32')->unique();
            $table->string('email')->unique();
            $table->string('address');
            
            //country code
            $table->string('nationality', 2);

            $table->string('educational_background')->nullable();
            $table->enum('preferred_contact_mode', ['p', 'e', 'n']);
            $table->date('dob');
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
        Schema::drop('personal_details');
    }
}
