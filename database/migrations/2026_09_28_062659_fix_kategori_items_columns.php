<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kategori_items', function (Blueprint $table) {
            if (!Schema::hasColumn('kategori_items', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('kategori_items', 'code')) {
                $table->string('code')->unique()->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('kategori_items', function (Blueprint $table) {
            if (Schema::hasColumn('kategori_items', 'code')) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            }

            if (Schema::hasColumn('kategori_items', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};

