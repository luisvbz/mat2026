<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();

            $table->string('title', 191);
            $table->longText('content');

            $table->enum('category', [
                'general',
                'academico',
                'administrativo',
                'evento',
                'urgente',
                'cobro',
                'actividad',
                'otro'

            ])->default('general');

            $table->unsignedBigInteger('author_id');
            $table->string('author_name', 191);
            $table->foreignIdFor(App\Models\Alumno::class)->nullable()->constrained('alumnos')->onDelete('set null');

            $table->boolean('is_published')->default(true);
            $table->dateTime('published_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['category', 'published_at'], 'idx_category_date');
            $table->index('published_at', 'idx_published_at');
            $table->index('is_published', 'idx_published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communications');
    }
}