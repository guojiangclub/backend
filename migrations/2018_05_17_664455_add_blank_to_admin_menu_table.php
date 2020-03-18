<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlankToAdminMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('admin_menu') && !Schema::hasColumn('admin_menu', 'blank')) {
            Schema::table('admin_menu', function (Blueprint $table) {
                $table->integer('blank')->after('icon')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('admin_menu', function (Blueprint $table) {
            $table->dropColumn('blank');
        });
    }
}
