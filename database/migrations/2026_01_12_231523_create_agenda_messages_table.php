<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Matricula::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(App\Models\TeacherUser::class)->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('subject');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->dateTime('read_at')->nullable();
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
        Schema::dropIfExists('agenda_messages');
    }
}
