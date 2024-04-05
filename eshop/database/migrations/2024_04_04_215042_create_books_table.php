<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('slug')->unique();
            $table->decimal('price', 8, 2);
            $table->string('language', 3);
            $table->date('publish_date');
            $table->text('description') -> nullable();
            $table->timestamps();
        });
   // Add the tsvector column with raw SQL
        DB::statement('ALTER TABLE books ADD COLUMN search_vector tsvector');

        // Update the tsvector column with concatenated name and description for existing records
        DB::statement("UPDATE books SET search_vector = to_tsvector('simple', coalesce(name, '') || ' ' || coalesce(description, ''))");

        // Create a GIN index on the tsvector column for performance
        DB::statement('CREATE INDEX search_vector_gin ON books USING GIN(search_vector)');
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 48);
            $table->timestamps();
        });

        Schema::create('genres',function (Blueprint $table) {
            $table->id();
            $table->string('name',32)->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->string('id', 64)->primary();
            $table->string('alt_text')->nullable();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('authors_books', function(Blueprint $table) {
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->primary(['author_id', 'book_id']);
        });

        Schema::create('genres_books', function (Blueprint $table) {
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->primary(['genre_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors_books');
        Schema::dropIfExists('genres_books');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('images');
        Schema::dropIfExists('genres');
        Schema::table('books', function (Blueprint $table) {
            // Remove the GIN index
            $table->dropIndex(['search_vector_gin']);

            // Remove the tsvector column
            $table->dropColumn('search_vector');
        });
        Schema::dropIfExists('books');
    }
};
