<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication_reads', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('communication_id')
                ->constrained('communications')
                ->onDelete('cascade');
            
            $table->foreignId('parent_user_id')
                ->constrained('parent_users')
                ->onDelete('cascade');
            
            $table->timestamp('read_at')->useCurrent();
            $table->timestamps();

            // Indexes for performance
            $table->index(['communication_id', 'parent_user_id'], 'idx_comm_parent');
            $table->index('read_at', 'idx_read_at');
            
            // Unique constraint to prevent duplicate reads
            $table->unique(['communication_id', 'parent_user_id'], 'unique_comm_parent_read');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communication_reads');
    }
}
