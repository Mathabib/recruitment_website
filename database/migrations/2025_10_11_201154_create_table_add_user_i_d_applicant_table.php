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
        // Perhatikan: "Schema", bukan "Scheema"
        Schema::table('applicants', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable() // <-- ini penting
                  ->constrained('users')
                  ->onDelete('set null')
                  ->after('job_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Di down() kita cukup hapus kolom user_id saja
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
