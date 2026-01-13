<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('teacher_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('teacher_id');
            $table->string('document_number', 191)->unique();
            $table->string('onesignal_id', 191)->nullable();
            $table->string('password', 191);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->tinyInteger('is_active')->default(1);

            $table->timestamps();

            /*   $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade'); */

            $table->index('document_number', 'idx_document_number');
            $table->index('teacher_id', 'idx_teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_users');
    }
}
