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
        Schema::create('applicants', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('jurusan_id'); // Foreign key column
                $table->unsignedBigInteger('education_id'); // Foreign key column
                $table->unsignedBigInteger('job_id'); // Foreign key column
                $table->string('name');
                $table->text('address');
                $table->string('number');
                $table->string('email');
                $table->string('profil_linkedin')->nullable();
                $table->string('certificates');
                $table->string('experience_period');
                $table->string('photo_pass');
                $table->text('profile');
                $table->text('languages')->nullable();
                $table->text('mbti')->nullable();
                $table->text('iq')->nullable();
                $table->text('achievement')->nullable();;
                $table->text('skills');
                $table->bigInteger('salary_expectation', 20);
                $table->enum('status', ['applied', 'interview', 'offer', 'accepted', 'rejected', 'bankcv','not_qualify'])->default('applied');
                $table->timestamps();
                $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
                $table->foreign('education_id')->references('id')->on('education')->onDelete('cascade');
                $table->foreign('jurusan_id')->references('id')->on('jurusan')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
};
