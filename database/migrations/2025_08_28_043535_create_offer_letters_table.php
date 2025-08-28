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
        Schema::create('offer_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id'); // relasi ke pelamar
            $table->unsignedBigInteger('job_id'); // relasi ke jobs
            $table->string('letter_number')->unique(); // nomor surat
            $table->date('offer_date'); // tanggal surat
            $table->date('join_date')->nullable(); // tanggal mulai kerja
            $table->integer('contract_duration')->nullable(); // durasi kontrak dalam bulan
            $table->decimal('basic_salary', 12, 2);
            $table->decimal('allowance', 12, 2)->nullable();
            $table->decimal('responsibility_allowance', 12, 2)->default(0);
            $table->decimal('total_salary', 12, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_letters');
    }
};
