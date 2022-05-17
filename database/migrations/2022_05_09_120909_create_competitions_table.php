<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('competitions');
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('club_id')->unsigned();
            $table->bigInteger('discipline_id')->unsigned();
            $table->string('name_competition',100);
            $table->date('date_competition');
            $table->string('address_competition',100);
            $table->string('postal_code_competition',5);
            $table->string('city_competition',100);
            $table->double('lat_competition', 8, 6);
            $table->double('lon_competition', 8, 6);
            $table->string('organizational_details',200)->nullable();
            $table->timestamps();
            $table->foreign('club_id')
                ->references('id')
                ->on('clubs');
            $table->foreign('discipline_id')
                ->references('id')
                ->on('disciplines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competion');
    }
};
