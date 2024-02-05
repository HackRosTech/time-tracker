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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->index()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('project_id')
                ->nullable()
                ->index()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('task_id')
                ->nullable()
                ->index()
                ->constrained()
                ->onDelete('cascade');

            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['project_id']);
            $table->dropIndex(['project_id']);

            $table->dropForeign(['task_id']);
            $table->dropIndex(['task_id']);
        });

        Schema::dropIfExists('statistics');
    }
};
