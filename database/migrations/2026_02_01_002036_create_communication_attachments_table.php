<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('communication_id');
            $table->string('name', 191);
            $table->string('url', 500);
            $table->string('type', 50);
            $table->unsignedInteger('size')->nullable();
            $table->timestamp('created_at')->nullable();

            // Index
            $table->index('communication_id', 'idx_communication_id');

            // Foreign key
            $table->foreign('communication_id')
                ->references('id')
                ->on('communications')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communication_attachments');
    }
}