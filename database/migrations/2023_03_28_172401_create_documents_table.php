<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('documents')) {
            Schema::create('documents', static function (Blueprint $table) {
                $table->uuid('id')->default(DB::raw('public.uuid_generate_v4()'))->primary();
                $table->uuid('category_id');
                $table->string('title', 60);
                $table->text('contents');
                $table->timestamps();

                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade')
                    ->index();

                $table->index('category_id');
                $table->index('title');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
