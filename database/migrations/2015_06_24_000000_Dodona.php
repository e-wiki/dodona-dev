<?php
/**
 * Dodona Framework DB Schema
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Dodona Migration Class
 * 
 * Runs the separate migration scripts to create the
 * core Dodona Framework Database schema.
 */
class Dodona extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create tables
		$this->_createClients();
		$this->_createServices();
		$this->_createEnvironments();
		$this->_createSites();
		$this->_createOperatingSystems();
		$this->_createDatabaseTechnologies();
		$this->_createServers();
		$this->_createCheckCategories();
		$this->_createChecks();
		$this->_createAlerts();
		$this->_createCheckResults();
		$this->_createServerCheckResults();
		$this->_createTicketCategories();
		$this->_createTicketPriorities();
		$this->_createTicketTypes();
		$this->_createTickets();
        $this->_createReportLevels();
        $this->_createReportTypes();
        $this->_createReports();
		
		// Create views
		$this->_createViewExpandedServers();
		$this->_createViewMaxServerCheckResults();
		$this->_createViewLatestServerCheckResults();
		
		// Create procedures
		$this->_createNewServerCheckResultProc();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop procedures
		DB::unprepared("DROP PROCEDURE IF EXISTS sp_new_server_check_result");
		
		// Drop views
		DB::unprepared("DROP VIEW IF EXISTS v_latest_server_check_results");
		DB::unprepared("DROP VIEW IF EXISTS v_max_server_check_results");
		DB::unprepared("DROP VIEW IF EXISTS v_servers");
		
		// Drop tables
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		
        Schema::drop('reports');
        Schema::drop('report_types');
        Schema::drop('report_levels');
		Schema::drop('tickets');
		Schema::drop('ticket_types');
		Schema::drop('ticket_priorities');
		Schema::drop('ticket_categories');
		Schema::drop('server_check_results');
		Schema::drop('check_results');
		Schema::drop('alerts');
		Schema::drop('checks');
		Schema::drop('check_categories');
		Schema::drop('servers');
		Schema::drop('database_technologies');
		Schema::drop('operating_systems');
		Schema::drop('sites');
		Schema::drop('environments');
		Schema::drop('services');
		Schema::drop('clients');
		
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

	private function _createClients()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 2)->primary();
			$table->string('name', 45)->unique();
			$table->boolean('enabled')->default(0);
			$table->string('description', 200)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	private function _createServices()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 5)->primary();
			$table->string('name', 45);
			$table->boolean('enabled')->default(0);
			$table->string('description', 200)->nullable();
			$table->char('client_id', 2);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('client_id')
					->references('id')->on('clients')
					->onDelete('restrict')
					->onUpdate('cascade');
		});
	}
	
	private function _createEnvironments()
	{
		Schema::create('environments', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 1)->primary();
			$table->string('name', 45)->unique();
		});
	}
	
	private function _createSites()
	{
		Schema::create('sites', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->timestamps = false;
			
			$table->char('id', 7)->primary();
			$table->string('name', 45);
			$table->string('description', 200)->nullable();
			$table->char('service_id', 5);
			$table->char('environment_id', 1);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('service_id')
					->references('id')->on('services')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('environment_id')
					->references('id')->on('environments')
					->onDelete('restrict')->onUpdate('cascade');
		});
	}
	
	private function _createOperatingSystems()
	{
		Schema::create('operating_systems', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('name', 45)->unique();
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	private function _createDatabaseTechnologies()
	{
		Schema::create('database_technologies', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('name', 45)->unique();
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	private function _createServers()
	{
		Schema::create('servers', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 10)->primary();
			$table->string('name', 45);
			$table->boolean('enabled')->default(0);
			$table->string('description', 200)->nullable();
			$table->char('site_id', 7);
			$table->integer('operating_system_id')->unsigned();
			$table->integer('database_technology_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('site_id')
					->references('id')->on('sites')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('operating_system_id')
					->references('id')->on('operating_systems')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('database_technology_id')
					->references('id')->on('database_technologies')
					->onDelete('restrict')->onUpdate('cascade');
		});
	}
	
	private function _createCheckCategories()
	{
		Schema::create('check_categories', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 1)->primary();
			$table->string('name', 15)->unique();
		});
	}
	
	private function _createAlerts()
	{
		Schema::create('alerts', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 1)->primary();
			$table->char('name', 5)->unique();
			$table->string('css', 7);
			$table->string('css_i', 7);
		});
	}
	
	private function _createChecks()
	{
		Schema::create('checks', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 6)->primary();
			$table->string('name', 100);
			$table->char('check_category_id', 1);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('check_category_id')
					->references('id')->on('check_categories')
					->onDelete('restrict')->onUpdate('cascade');
		});
	}
	
	private function _createCheckResults()
	{
		Schema::create('check_results', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->char('id', 9)->primary();
			$table->string('name', 200);
			$table->char('check_id', 6);
			$table->char('alert_id', 1);
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('check_id')
					->references('id')->on('checks')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('alert_id')
					->references('id')->on('alerts')
					->onDelete('restrict')->onUpdate('cascade');
		});
	}
	
	private function _createTicketPriorities()
	{
		Schema::create('ticket_priorities', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->integer('id')->unsigned()->primary();
			$table->string('name', 10)->unique();
		});
	}
	
	private function _createTicketTypes()
	{
		Schema::create('ticket_types', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->integer('id')->unsigned()->primary();
			$table->string('name', 45)->unique();
		});
	}
	
	private function _createTicketCategories()
	{
		Schema::create('ticket_categories', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('name', 45)->unique();
		});
	}
	
	private function _createServerCheckResults()
	{
		Schema::create('server_check_results', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->char('server_id', 10);
			$table->char('check_result_id', 9);
			$table->timestamp('raised_at');
			$table->char('check_id', 6);
			$table->integer('server_check_result_id')->unsigned()->nullable();
			$table->unique(['server_id', 'check_result_id', 'raised_at']);
			$table->foreign('server_id')
					->references('id')->on('servers')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('check_result_id')
					->references('id')->on('check_results')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('check_id')
					->references('id')->on('checks')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('server_check_result_id')
					->references('id')->on('server_check_results')
					->onDelete('restrict')->onUpdate('cascade');
		});
	}
	
	private function _createTickets()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
            
			$table->increments('id');
			$table->integer('server_check_result_id')->unsigned();
			$table->timestamp('raised_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->char('reference', 33)->unique();
			$table->integer('ticket_category_id')->unsigned();
			$table->integer('ticket_priority_id')->unsigned();
			$table->integer('ticket_type_id')->unsigned();
            $table->boolean('resolved')->default(0);
			$table->string('summary', 100);
			$table->string('description', 500);
			$table->foreign('server_check_result_id')
					->references('id')->on('server_check_results')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('ticket_category_id')
					->references('id')->on('ticket_categories')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('ticket_priority_id')
					->references('id')->on('ticket_priorities')
					->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('ticket_type_id')
					->references('id')->on('ticket_types')
					->onDelete('restrict')->onUpdate('cascade');
		});
		
		$this->_linkServerChechResultTickets();
	}
	
	private function _linkServerChechResultTickets()
	{
		Schema::table('server_check_results', function(Blueprint $table)
		{
			$table->integer('ticket_id')
					->unsigned()
					->nullable()
					->after('server_check_result_id');
			
			$table->foreign('ticket_id')
					->references('id')->on('tickets')
					->onDelete('restrict')->onUpdate('cascade');
		});
	}
    
    private function _createReportLevels()
    {
        Schema::create('report_levels', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('name', 10)->unique();
        });
    }
    
    private function _createReportTypes()
    {
        Schema::create('report_types', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('name', 10)->unique();
        });
    }
    
    private function _createReports()
    {
        Schema::create('reports', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('report_level_id')->unsigned();
            $table->integer('report_type_id')->unsigned();
            $table->string('summary', 500)->nullable();
            $table->timestamp('start_at');
            $table->timestamp('end_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('report_level_id')
                    ->references('id')->on('report_levels')
                    ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('report_type_id')
                    ->references('id')->on('report_types')
                    ->onDelete('restrict')->onUpdate('cascade');
        });
    }
	
	private function _createViewExpandedServers()
	{
		DB::unprepared("DROP VIEW IF EXISTS v_servers");
		
		DB::unprepared("CREATE VIEW v_servers AS "
				. "SELECT s.id, s.name, s.enabled, s.description, s.site_id, "
				. "sites.name AS site_name, os.id AS operating_system_id, os.name AS operating_system_name, "
				. "dt.id AS database_technology_id, dt.name AS database_technology_name, s.created_at, s.updated_at, s.deleted_at "
				. "FROM servers s "
				. "JOIN sites ON sites.id = s.site_id "
				. "JOIN operating_systems os ON os.id = s.operating_system_id "
				. "JOIN database_technologies dt ON dt.id = s.database_technology_id");
	}
	
	private function _createViewMaxServerCheckResults()
	{
		DB::unprepared("DROP VIEW IF EXISTS v_max_server_check_results");
		
		DB::unprepared("CREATE VIEW v_max_server_check_results AS "
				. "SELECT server_id, check_id, MAX(raised_at) AS raised_at "
				. "FROM server_check_results "
				. "GROUP BY server_id , check_id");
	}
	
	private function _createViewLatestServerCheckResults()
	{
		DB::unprepared("DROP VIEW IF EXISTS v_latest_server_check_results");
		
		DB::unprepared("CREATE VIEW v_latest_server_check_results AS "
				. "SELECT scr.*, cc.id AS check_category_id, cc.name AS check_category_name "
				. "FROM server_check_results scr "
				. "JOIN v_max_server_check_results m "
				. "ON scr.server_id = m.server_id "
				. "AND scr.check_id = m.check_id "
				. "AND scr.raised_at = m.raised_at "
				. "JOIN checks c "
				. "ON c.id = scr.check_id "
				. "JOIN check_categories cc "
				. "ON cc.id = c.check_category_id");
	}
	
	private function _createNewServerCheckResultProc()
	{
		DB::unprepared("DROP PROCEDURE IF EXISTS sp_new_server_check_result");
		
		DB::unprepared(
				"CREATE PROCEDURE sp_new_server_check_result(IN a_server_id CHAR(10), IN a_check_result_id CHAR(9), IN a_raised_at TIMESTAMP)
BEGIN
	DECLARE v_id                       int;
    DECLARE v_check_result_id          CHAR(9);
	DECLARE v_server_check_result_id   CHAR(10);
	DECLARE v_ticket_id                INT;
	
	IF (SUBSTR(a_check_result_id, 7, 1) = 'G') THEN
		INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id)
			VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6));
		COMMIT;
    ELSE
		  SELECT id, check_result_id, server_check_result_id, ticket_id
            INTO v_id, v_check_result_id, v_server_check_result_id, v_ticket_id
		    FROM server_check_results
		   WHERE server_id = a_server_id AND check_id = SUBSTR(a_check_result_id, 1, 6)
		ORDER BY raised_at DESC
           LIMIT 1;
         
		CASE
			WHEN SUBSTR(a_check_result_id, 7, 1) = 'A'  AND v_check_result_id IS NULL THEN
				INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id)
					VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6));
			WHEN SUBSTR(a_check_result_id, 7, 1) = 'A'  AND SUBSTR(v_check_result_id, 7, 1) IN ('G', 'R') THEN
				INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id)
					VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6));
			WHEN SUBSTR(a_check_result_id, 7, 1) = 'A'  AND SUBSTR(v_check_result_id, 7, 1) = 'A' THEN
				CASE
					WHEN v_server_check_result_id IS NULL THEN
						INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id, server_check_result_id, ticket_id)
							VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6), v_id, v_ticket_id);
					ELSE
						INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id, server_check_result_id, ticket_id)
							VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6), v_server_check_result_id, v_ticket_id);
				END CASE;
			WHEN SUBSTR(a_check_result_id, 7, 1) = 'R'  AND v_check_result_id IS NULL THEN
				INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id)
					VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6));
			WHEN SUBSTR(a_check_result_id, 7, 1) = 'R'  AND SUBSTR(v_check_result_id, 7, 1) IN ('G', 'A') THEN
				INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id)
					VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6));
			WHEN SUBSTR(a_check_result_id, 7, 1) = 'R'  AND SUBSTR(v_check_result_id, 7, 1) = 'R' THEN
				CASE
					WHEN v_server_check_result_id IS NULL THEN
						INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id, server_check_result_id, ticket_id)
							VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6), v_id, v_ticket_id);
					ELSE
						INSERT INTO server_check_results (server_id, check_result_id, raised_at, check_id, server_check_result_id, ticket_id)
							VALUES (a_server_id, a_check_result_id, a_raised_at, SUBSTR(a_check_result_id, 1, 6), v_server_check_result_id, v_ticket_id);
				END CASE;
        END CASE;
	 END IF;
END"
		);
	}
}