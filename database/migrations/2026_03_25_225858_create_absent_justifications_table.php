<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsentJustificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absent_justifications', function (Blueprint $table) {
            $table->id();
            $table->foreingIdFor(App\Models\Matricula::class);
            $table->date('from');
            $table->date('to');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('justification');
            $table->string('file')->nullable();
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
        Schema::dropIfExists('absent_justifications');
    }
}
