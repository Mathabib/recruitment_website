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
        Schema::create('jurusan2s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();            
            $table->unsignedBigInteger('applicant_id');
            $table->unsignedBigInteger('education_id');
            $table->string('jurusan2');
            $table->foreign('education_id')->references('id')->on('education');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurusan2s');
    }
};
