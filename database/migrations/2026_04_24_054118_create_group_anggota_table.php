<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('group_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('nama');
            $table->string('nim');
            $table->integer('semester');
            $table->boolean('is_ketua')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_anggota');
    }
};  