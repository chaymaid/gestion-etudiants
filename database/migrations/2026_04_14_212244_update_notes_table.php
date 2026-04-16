<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('notes', 'matiere')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->dropColumn('matiere');
            });
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('notes', 'matiere')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->string('matiere')->nullable();
            });
        }
    }
};
