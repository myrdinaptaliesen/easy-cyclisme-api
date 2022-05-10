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
        Schema::create('competition_cyclists_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('competition_id')->unsigned();
            $table->bigInteger('cyclists_category_id')->unsigned();            
            $table->timestamps();
            $table->foreign('competition_id')
                ->references('id')
                ->on('competitions');
             $table->foreign('cyclists_category_id')
                ->references('id')
                ->on('cyclists_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_cyclists_category');
    }
};
