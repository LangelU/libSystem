<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('second_name', 255)->nullable();
            $table->string('first_lastname', 255);
            $table->string('second_lastname', 255)->nullable();
            $table->string('city_birth', 255);
            $table->string('country_birth', 255);
            $table->date('date_birth');
            $table->date('death_birth')->nullable();
            $table->string('biography', 4000);
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
        Schema::dropIfExists('authors');
    }
}
