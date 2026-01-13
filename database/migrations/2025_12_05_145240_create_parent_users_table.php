<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('padre_id');

            // reemplazamos email por documento_number
            $table->string('document_number', 191)->unique();

            $table->string('password', 191);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->tinyInteger('is_active')->default(1);

            $table->timestamps();

            // Foreign Key
            $table->foreign('padre_id')
                ->references('id')
                ->on('padres')
                ->onDelete('cascade');

            // Indexes
            $table->index('document_number', 'idx_document_number');
            $table->index('padre_id', 'idx_padre_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_users');
    }
}
