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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->unsigned()->index();
            $table->string("title");
            $table->string("description");
            $table->decimal("price");
            $table->text("completed_jobs")->nullable();
            $table->string("start_date");
            $table->string("end_date");
            $table->text("team_members")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
