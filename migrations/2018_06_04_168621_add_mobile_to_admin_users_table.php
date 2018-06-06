<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class AddMobileToAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('admin_users', function (Blueprint $table) {
            $table->string('mobile')->after('name')->unique()->nullale();
            $table->string('email')->after('username')->unique()->nullale();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn('mobile');
            $table->dropColumn('email');
        });
    }
}
