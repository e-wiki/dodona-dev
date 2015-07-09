<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationDodona11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table)
        {
            $table->integer('user_id')->unsigned()->after('reference');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('servers', function (Blueprint $table)
        {
            $table->boolean('auto_refreshed')->default(0)->after('enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table)
        {
            $table->dropForeign('tickets_user_id_foreign');

            $table->dropColumn('user_id');
        });

        Schema::table('servers', function (Blueprint $table)
        {
            $table->dropColumn('auto_refreshed');
        });
    }
    
}
