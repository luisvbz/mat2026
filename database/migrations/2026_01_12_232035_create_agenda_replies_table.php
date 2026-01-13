<?php

use App\Models\AgendaMessage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AgendaMessage::class)->constrained()->onDelete('cascade');
            $table->string('author_type');
            $table->unsignedBigInteger('author_id');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('agenda_replies');
    }
}
