<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->char('nik', 16)->primary();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->string('birth_city');
            $table->date('birth_date');
            $table->char('district_id', 6);
            $table->text('address');
            $table->text('photo')->nullable();
            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data');
    }
}
