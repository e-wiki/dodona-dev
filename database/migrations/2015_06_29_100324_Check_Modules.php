<?php

use Dodona\CheckModule;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CheckModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->_createCheckModulesTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		// Drop Foreign Keys
		DB::statement('ALTER TABLE checks DROP FOREIGN KEY checks_check_module_id_foreign');
		
		// Drop Columns
		DB::statement('ALTER TABLE checks DROP COLUMN check_module_id');
		
		// Drop tables
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		
		DB::statement('DROP TABLE check_modules');
		
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
	
	private function _createCheckModulesTable()
	{
		Schema::create('check_modules', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('name', 50)->unique();
			$table->timestamps();
			$table->softDeletes();
		});
		
		CheckModule::create(['name' => 'Core']);
		
		$this->_linkCheckModulesChecks();
	}
	
	private function _linkCheckModulesChecks()
	{
		Schema::table('checks', function(Blueprint $table)
		{
			$table->integer('check_module_id')
					->unsigned()
					->default(1)
					->after('check_category_id');
			
			$table->foreign('check_module_id')
					->references('id')->on('check_modules')
					->onDelete('restrict')->onUpdate('cascade');
		});
	}
}
