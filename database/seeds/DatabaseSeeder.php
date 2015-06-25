<?php
/**
 * Dodona Framework DB Seeder.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Alert;
use Dodona\Check;
use Dodona\CheckCategory;
use Dodona\CheckResult;
use Dodona\Client;
use Dodona\DatabaseTechnology;
use Dodona\Environment;
use Dodona\OperatingSystem;
use Dodona\ReportLevel;
use Dodona\ReportType;
use Dodona\Server;
use Dodona\ServerCheckResult;
use Dodona\Service;
use Dodona\Site;
use Dodona\TicketCategory;
use Dodona\TicketPriority;
use Dodona\TicketType;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * DatabaseSeeder class
 * 
 * Populates the database with the necessary seeds based on the environment.
 */
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	
	public function run()
	{
		Model::unguard();
		
		/**
		 * Disable foreign key checks for this
		 * connection before running seeders.
		 */
		DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

		$this->call('AlertsTableSeeder');
		$this->call('CheckCategoriesTableSeeder');
		$this->call('ChecksTableSeeder');
		$this->call('CheckResultsTableSeeder');
		$this->call('DatabaseTechnologiesTableSeeder');
		$this->call('EnvironmentsTableSeeder');
		$this->call('OperatingSystemsTableSeeder');
        $this->call('ReportLevelsTableSeeder');
        $this->call('ReportTypesTableSeeder');
		$this->call('TicketCategoriesTableSeeder');
		$this->call('TicketPrioritiesTableSeeder');
		$this->call('TicketTypesTableSeeder');
		
		/**
		 * Will not seed clients, services, servers, and server check
		 * results if this is the production environment.
		 */
		if (getenv('APP_ENV') !== 'production')
		{
			$this->call('ClientsTableSeeder');
			$this->call('ServicesTableSeeder');
			$this->call('SitesTableSeeder');
			$this->call('ServersTableSeeder');
			$this->call('ServerCheckResultsTableSeeder');
		}
		
		// Reset foreign key checks.
		DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
	}

}

class DatabaseTechnologiesTableSeeder extends Seeder {
	
	/**
	 * Run the database_technologies table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		DatabaseTechnology::truncate();
		
		DatabaseTechnology::create(['name' => 'All Database Technologies']);
		DatabaseTechnology::create(['name' => 'Microsoft SQL Server']);
		DatabaseTechnology::create(['name' => 'Microsoft SQL Server 2000']);
		DatabaseTechnology::create(['name' => 'Microsoft SQL Server 2005']);
		DatabaseTechnology::create(['name' => 'Microsoft SQL Server 2008']);
		DatabaseTechnology::create(['name' => 'Microsoft SQL Server 2008 R2']);
		DatabaseTechnology::create(['name' => 'Microsoft SQL Server 2012']);
		DatabaseTechnology::create(['name' => 'Microsoft SQL Server 2014']);
		DatabaseTechnology::create(['name' => 'MySQL Server']);
		DatabaseTechnology::create(['name' => 'MySQL Server 5.1']);
		DatabaseTechnology::create(['name' => 'MySQL Server 5.5']);
		DatabaseTechnology::create(['name' => 'MySQL Server 5.6']);
		DatabaseTechnology::create(['name' => 'MySQL Server 5.7']);
		DatabaseTechnology::create(['name' => 'Oracle Database Server']);
		DatabaseTechnology::create(['name' => 'Oracle Database Server 10g']);
		DatabaseTechnology::create(['name' => 'Oracle Database Server 11gR1']);
		DatabaseTechnology::create(['name' => 'Oracle Database Server 11gR2']);
		DatabaseTechnology::create(['name' => 'Oracle Database Server 12cR1']);
	}
	
}

class ClientsTableSeeder extends Seeder {
	
	/**
	 * Run the clients table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		Client::truncate();
		
		Client::create(['id' => 'ZZ', 'name' => 'Sample Client 1', 'enabled' => 1, 'description' => 'Sample demo client 1']);
		Client::create(['id' => 'ZY', 'name' => 'Sample Client 2', 'enabled' => 1, 'description' => 'Sample demo client 2']);
		Client::create(['id' => 'ZX', 'name' => 'Sample Client 3', 'enabled' => 1, 'description' => 'Sample demo client 3']);
	}
	
}

class EnvironmentsTableSeeder extends Seeder {
	
	/**
	 * Run the environments table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		Environment::truncate();
		
		Environment::create(['id' => 'P', 'name' => 'Production']);
		Environment::create(['id' => 'S', 'name' => 'Staging/Pre-Production']);
		Environment::create(['id' => 'T', 'name' => 'Testing']);
		Environment::create(['id' => 'D', 'name' => 'Development']);
	}
	
}

class OperatingSystemsTableSeeder extends Seeder {
	
	/**
	 * Run the operating systems table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		Dodona\OperatingSystem::truncate();
		
		OperatingSystem::create(['name' => 'Linux']);
		OperatingSystem::create(['name' => 'Oracle Linux 6.5']);
		OperatingSystem::create(['name' => 'Oracle Linux 7.0']);
		OperatingSystem::create(['name' => 'Redhat 4.5']);
		OperatingSystem::create(['name' => 'Redhat 5.4']);
		OperatingSystem::create(['name' => 'Redhat 6.5']);
		OperatingSystem::create(['name' => 'Redhat 7.0']);
		OperatingSystem::create(['name' => 'CentOS 6.5']);
		OperatingSystem::create(['name' => 'CentOS 7.0']);
		OperatingSystem::create(['name' => 'Windows']);
		OperatingSystem::create(['name' => 'Windows Server 2003']);
		OperatingSystem::create(['name' => 'Windows Server 2005']);
		OperatingSystem::create(['name' => 'Windows Server 2008']);
		OperatingSystem::create(['name' => 'Windows Server 2012']);
	}
	
}

class ServicesTableSeeder extends Seeder {
	
	/**
	 * Run the services table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		Service::truncate();
		
		$clients = Client::all()->lists('id');
		
		foreach ($clients as $client)
		{
			$limit = rand(2, 10);
			
			for ($i = 1; $i < $limit; $i++)
			{
				Service::create(['id' => "{$client}" . str_pad($i, 3, '0', STR_PAD_LEFT), 'name' => "Sample Service {$i}", 'enabled' => rand(0, 1), 'description' => "Sample service {$i}", 'client_id' => "{$client}"]);
			}
		}
	}
	
}

class SitesTableSeeder extends Seeder {
	
	/**
	 * Run the sites table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		Site::truncate();
		
		$services     = Service::lists('id')->all();
		$environments = Environment::lists('id')->all();
		
		foreach ($services as $service)
		{
			$limit = rand(2, 4);
			
			for ($i = 1; $i < $limit; $i++)
			{
				$environment = $environments[array_rand($environments, 1)];
				Site::create([
					'id'             => "{$service}{$environment}{$i}",
					'name'           => "Sample site {$i}",
					'description'    => "Sample site {$i}",
					'service_id'     => "{$service}",
					'environment_id' => "{$environment}"]);
			}
		}
	}
	
}

class ServersTableSeeder extends Seeder {
	
	public function run()
	{
		Server::truncate();
		
		$services              = Service::lists('id')->all();
		$operating_systems     = OperatingSystem::lists('id')->all();
		$database_technologies = DatabaseTechnology::lists('id')->all();
		
		foreach ($services as $service)
		{
			$limit = rand(2, 20);
			
			for ($i = 1; $i < $limit; $i++)
			{
				$sites = Site::where('service_id', $service)->lists('id')->all();
				$site  = $sites[array_rand($sites, 1)];
				
				Server::create([
					'id'                     => "{$site}" . str_pad($i, 3, '0', STR_PAD_LEFT),
					'name'                   => "Sample server {$i}",
					'enabled'                => rand(0, 1),
					'description'            => "Sample server {$i}",
					'site_id'                => "{$site}",
					'operating_system_id'    => array_rand($operating_systems, 1),
					'database_technology_id' => array_rand($database_technologies, 1)
				]);
			}
		}
	}
	
}

class CheckCategoriesTableSeeder extends Seeder {
	
	/**
	 * Run the check categories table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		CheckCategory::truncate();
		
		CheckCategory::create(['id' => 'C', 'name' => 'Capacity']);
		CheckCategory::create(['id' => 'R', 'name' => 'Recoverability']);
		CheckCategory::create(['id' => 'A', 'name' => 'Availability']);
		CheckCategory::create(['id' => 'P', 'name' => 'Performance']);
	}
	
}

class AlertsTableSeeder extends Seeder {
	
	/**
	 * Run the alerts table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		Alert::truncate();
		
		Alert::create(['id' => 'R', 'name' => 'Red', 'css' => 'danger', 'css_i' => 'danger']);
		Alert::create(['id' => 'A', 'name' => 'Amber', 'css' => 'warning', 'css_i' => 'warning']);
		Alert::create(['id' => 'G', 'name' => 'Green', 'css' => 'success', 'css_i' => 'default']);
		Alert::create(['id' => 'B', 'name' => 'Blue', 'css' => 'info', 'css_i' => 'info']);
	}
	
}

class TicketCategoriesTableSeeder extends Seeder {
	
	/**
	 * Run the ticket categories table seeder.
	 * 
	 * @return void
	 */
	public function run()
	{
		TicketCategory::truncate();
		
		TicketCategory::create(['name' => 'Database']);
		TicketCategory::create(['name' => 'Hardware']);
		TicketCategory::create(['name' => 'IT Service']);
		TicketCategory::create(['name' => 'Network']);
		TicketCategory::create(['name' => 'Server']);
		TicketCategory::create(['name' => 'Software']);
	}
	
}

class TicketPrioritiesTableSeeder extends Seeder {
	
	/**
	 * Run the ticket priorities table seeds.
	 * 
	 * @return void
	 */
	public function run()
	{
		TicketPriority::truncate();
		
		TicketPriority::create(['id' => 1, 'name' => 'Critical']);
		TicketPriority::create(['id' => 2, 'name' => 'High']);
		TicketPriority::create(['id' => 3, 'name' => 'Medium']);
		TicketPriority::create(['id' => 4, 'name' => 'Low']);
		TicketPriority::create(['id' => 5, 'name' => 'Planning']);
	}
}

class TicketTypesTableSeeder extends Seeder {
	
	/**
	 * Run the ticket types table seeder.
	 * 
	 * @return void
	 */
	public function run()
	{
		TicketType::truncate();
		
		TicketType::create(['id' => 1, 'name' => 'Incident']);
		TicketType::create(['id' => 2, 'name' => 'Problem']);
		TicketType::create(['id' => 3, 'name' => 'Service Request']);
	}
	
}

class ChecksTableSeeder extends Seeder {
	
	/**
	 * Run the checks table seeder.
	 * 
	 * @return void
	 */
	public function run()
	{
		Check::truncate();
		
		Check::create(['id' => 'AML001', 'name' => 'Connection Availability', 'check_category_id' => 'A']);
		Check::create(['id' => 'AML002', 'name' => 'Security Access', 'check_category_id' => 'A']);
		Check::create(['id' => 'AOL001', 'name' => 'Connection Availability', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW001', 'name' => 'Instance Availability', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW002', 'name' => 'Agent Availability', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW003', 'name' => 'Offline Databases', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW004', 'name' => '[master] Database Online', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW005', 'name' => 'Logon Errors', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW006', 'name' => 'Database Start/Stop', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW007', 'name' => 'User Password Policy', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW008', 'name' => 'User Expiration Policy', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW009', 'name' => 'User [master] Default', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW010', 'name' => 'xp_CmdShell', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW011', 'name' => 'Encrypted Connections', 'check_category_id' => 'A']);
		Check::create(['id' => 'ASW012', 'name' => 'HideInstance', 'check_category_id' => 'A']);
		Check::create(['id' => 'CML001', 'name' => 'Backups Directory', 'check_category_id' => 'C']);
		Check::create(['id' => 'CML002', 'name' => 'Binlog Directory', 'check_category_id' => 'C']);
		Check::create(['id' => 'CML003', 'name' => 'Error Log Directory', 'check_category_id' => 'C']);
		Check::create(['id' => 'CML004', 'name' => 'Slow Query Log Directory', 'check_category_id' => 'C']);
		Check::create(['id' => 'CML005', 'name' => 'General Log Directory', 'check_category_id' => 'C']);
		Check::create(['id' => 'CNL001', 'name' => 'Partition', 'check_category_id' => 'C']);
		Check::create(['id' => 'COL001', 'name' => 'Tablespace', 'check_category_id' => 'C']);
		Check::create(['id' => 'PML001', 'name' => 'Connection Pool', 'check_category_id' => 'P']);
		Check::create(['id' => 'PNL001', 'name' => 'Memory', 'check_category_id' => 'P']);
		Check::create(['id' => 'PNL002', 'name' => 'Swap', 'check_category_id' => 'P']);
		Check::create(['id' => 'PNL003', 'name' => 'CPU', 'check_category_id' => 'P']);
		Check::create(['id' => 'PSW001', 'name' => 'Failed Jobs', 'check_category_id' => 'P']);
		Check::create(['id' => 'PSW002', 'name' => 'Log Errors', 'check_category_id' => 'P']);
		Check::create(['id' => 'PSW003', 'name' => 'Signal CPU Waits', 'check_category_id' => 'P']);
		Check::create(['id' => 'RML001', 'name' => 'Master Process', 'check_category_id' => 'R']);
		Check::create(['id' => 'RML002', 'name' => 'Slave Process', 'check_category_id' => 'R']);
		Check::create(['id' => 'RSW001', 'name' => 'Backup', 'check_category_id' => 'R']);
	}
	
}

class CheckResultsTableSeeder extends Seeder {
	
	/**
	 * Run the check results table seeder.
	 * 
	 * @return void
	 */
	public function run()
	{
		CheckResult::truncate();
		
		CheckResult::create(['id' => 'AML001G01', 'name' => 'Successful connection to the instance', 'check_id' => 'AML001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'AML001R01', 'name' => 'Cannot connect to the instance', 'check_id' => 'AML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002G01', 'name' => 'No instance security access configuration breaches', 'check_id' => 'AML002', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'AML002R01', 'name' => 'Cannot connect to the instance', 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R02', 'name' => "Users with '%' as host, no or null password, and no username found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R03', 'name' => "Users with '%' as host, and no or null password", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R04', 'name' => "Users with '%' as host, and no username found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R05', 'name' => "Users with '%' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R06', 'name' => "Users with no or null password, and no username found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R07', 'name' => "Users no or null password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R08', 'name' => "Users with no username found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R09', 'name' => "Users with either '%' as host, no or null password, no username, and/or expired password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R10', 'name' => "Users with either '%' as host, no or null password, and/or expired password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R11', 'name' => "Users with either '%' as host, no username, and/or expired password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R12', 'name' => "Users with either '%' as host, and/or expired password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R13', 'name' => "Users with either no or null password, no username, and/or expired password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R14', 'name' => "Users with either no or null password, and/or expired password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R15', 'name' => "Users with either no username, and/or expired password found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R16', 'name' => "Users with either '%' as host, no or null password, no username, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R17', 'name' => "Users with either '%' as host, no or null password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R18', 'name' => "Users with either '%' as host, no username, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R19', 'name' => "Users with either '%' as host, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R20', 'name' => "Users with either no or null password, no username, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R21', 'name' => "Users with either no or null password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R22', 'name' => "Users with either no username, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R23', 'name' => "Users with either '%' as host, no or null password, no username, expired password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R24', 'name' => "Users with either '%' as host, no or null password, expired password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R25', 'name' => "Users with either '%' as host, no username, expired password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R26', 'name' => "Users with either '%' as host, expired password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R27', 'name' => "Users with either no or null password, no username, expired password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R28', 'name' => "Users with either no or null password, expired password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AML002R29', 'name' => "Users with either no username, expired password, and/or '127.0.0.1' or '::1' as host found", 'check_id' => 'AML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'AOL003G01', 'name' => 'Successful connection to the instance', 'check_id' => 'AOL003', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'AOL003R01', 'name' => 'Cannot connect to the instance', 'check_id' => 'AOL003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW001G01', 'name' => 'The instance is running', 'check_id' => 'ASW001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW001R01', 'name' => 'Cannot connect to the instance', 'check_id' => 'ASW001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW001R02', 'name' => 'Instance not available for standard operations', 'check_id' => 'ASW001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW002G01', 'name' => 'The agent is running', 'check_id' => 'ASW002', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW002R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW002R02', 'name' => 'Agent not available for standard operations', 'check_id' => 'ASW002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW003A01', 'name' => 'At least one database is offline', 'check_id' => 'ASW003', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'ASW003G01', 'name' => 'All databases are online', 'check_id' => 'ASW003', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW003R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW004G01', 'name' => 'The [master] database is online', 'check_id' => 'ASW004', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW004R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW004', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW004R02', 'name' => 'The [master] database is offline', 'check_id' => 'ASW004', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW005A01', 'name' => 'At least one Logon error found ', 'check_id' => 'ASW005', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'ASW005G01', 'name' => 'No Logon errors found', 'check_id' => 'ASW005', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW005R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW005', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW006G01', 'name' => 'No database start/stop events found', 'check_id' => 'ASW006', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW006R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW006', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW006R02', 'name' => 'At least one database start/stop event found', 'check_id' => 'ASW006', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW007A01', 'name' => 'Password Policy not enforced on all users', 'check_id' => 'ASW007', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'ASW007G01', 'name' => 'Password Policy enforced on all users', 'check_id' => 'ASW007', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW007R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW007', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW008A01', 'name' => 'Expiration Policy not enforced on all users', 'check_id' => 'ASW008', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'ASW008G01', 'name' => 'Expiration Policy enforced on all users', 'check_id' => 'ASW008', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW008R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW008', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW009A01', 'name' => '[master] database default for some users', 'check_id' => 'ASW009', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'ASW009G01', 'name' => '[master] database not default for normal users', 'check_id' => 'ASW009', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW009R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW009', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW010A01', 'name' => 'xp_CmdShell enabled', 'check_id' => 'ASW010', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'ASW010G01', 'name' => 'xp_CmdShell disabled', 'check_id' => 'ASW010', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW010R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW010', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW011A01', 'name' => 'At least one connection is unencrypted', 'check_id' => 'ASW011', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'ASW011G01', 'name' => 'All connections are encrypted', 'check_id' => 'ASW011', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW011R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW011', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW012G01', 'name' => 'HideInstance is enabled', 'check_id' => 'ASW012', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'ASW012R01', 'name' => 'Cannot connect to instance', 'check_id' => 'ASW012', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'ASW012R02', 'name' => 'HideInstance is disabled', 'check_id' => 'ASW012', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML001A01', 'name' => 'Capacity measured between AMBER (inclusive) and RED (exclusive) level', 'check_id' => 'CML001', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'CML001G01', 'name' => 'Capacity measured at below AMBER level', 'check_id' => 'CML001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'CML001R01', 'name' => 'Capacity measured at RED level and up', 'check_id' => 'CML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML001R02', 'name' => 'Directory is not available', 'check_id' => 'CML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML001R03', 'name' => 'Directory is not given', 'check_id' => 'CML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML002A01', 'name' => 'Capacity measured between AMBER (inclusive) and RED (exclusive) level', 'check_id' => 'CML002', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'CML002G01', 'name' => 'Capacity measured at below AMBER level', 'check_id' => 'CML002', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'CML002R01', 'name' => 'Capacity measured at RED level and up', 'check_id' => 'CML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML002R02', 'name' => 'Directory not found', 'check_id' => 'CML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML002R03', 'name' => 'Cannot connect to the instance', 'check_id' => 'CML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML003A01', 'name' => 'Capacity measured between AMBER (inclusive) and RED (exclusive) level', 'check_id' => 'CML003', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'CML003G01', 'name' => 'Capacity measured at below AMBER level', 'check_id' => 'CML003', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'CML003R01', 'name' => 'Capacity measured at RED level and up', 'check_id' => 'CML003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML003R02', 'name' => 'File not found', 'check_id' => 'CML003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML003R03', 'name' => 'Cannot connect to the instance', 'check_id' => 'CML003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML004A01', 'name' => 'Capacity measured between AMBER (inclusive) and RED (exclusive) level', 'check_id' => 'CML004', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'CML004G01', 'name' => 'Capacity measured at below AMBER level', 'check_id' => 'CML004', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'CML004R01', 'name' => 'Capacity measured at RED level and up', 'check_id' => 'CML004', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML004R02', 'name' => 'File not found', 'check_id' => 'CML004', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML004R03', 'name' => 'Cannot connect to the instance', 'check_id' => 'CML004', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML005A01', 'name' => 'Capacity measured between AMBER (inclusive) and RED (exclusive) level', 'check_id' => 'CML005', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'CML005G01', 'name' => 'Capacity measured at below AMBER level', 'check_id' => 'CML005', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'CML005R01', 'name' => 'Capacity measured at RED level and up', 'check_id' => 'CML005', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML005R02', 'name' => 'File not found', 'check_id' => 'CML005', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CML005R03', 'name' => 'Cannot connect to the instance', 'check_id' => 'CML005', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'CNL001A01', 'name' => 'Capacity measured between AMBER (inclusive) and RED (exclusive) level for at least one filesystem', 'check_id' => 'CNL001', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'CNL001G01', 'name' => 'Capacity measured at below AMBER level for all filesystems', 'check_id' => 'CNL001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'CNL001R01', 'name' => 'Capacity measured at RED level and up for at least one filesystem', 'check_id' => 'CNL001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'COL001A01', 'name' => 'Capacity measured between AMBER (inclusive) and RED (exclusive) level for at least one tablespace', 'check_id' => 'COL001', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'COL001G01', 'name' => 'Capacity measured at below AMBER level for all tablespaces', 'check_id' => 'COL001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'COL001R01', 'name' => 'Capacity measured at RED level and up for at least one tablespace', 'check_id' => 'COL001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'COL001R02', 'name' => 'Cannot connect to the instance', 'check_id' => 'COL001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PML001G01', 'name' => 'Connection pool utilisation is less than AMBER level', 'check_id' => 'PML001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'PML001A01', 'name' => 'Connection pool utilisation is between AMBER (inclusive) and RED (exclusive) level', 'check_id' => 'PML001', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'PML001R01', 'name' => 'Cannot connect to the instance', 'check_id' => 'PML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PML001R02', 'name' => 'Connection pool utilisation is at RED level and up', 'check_id' => 'PML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PNL001A01', 'name' => 'Physical memory utilisation is between AMBER and RED level', 'check_id' => 'PNL001', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'PNL001G01', 'name' => 'Physical memory utilisation is less than AMBER level', 'check_id' => 'PNL001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'PNL001R01', 'name' => 'Physical memory utilisation is at RED level and up', 'check_id' => 'PNL001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PNL002A01', 'name' => 'Virtual memory utilisation is between AMBER and RED level', 'check_id' => 'PNL002', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'PNL002G01', 'name' => 'Virtual memory utilisation is less than AMBER level', 'check_id' => 'PNL002', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'PNL002R01', 'name' => 'Virtual memory utilisation is at RED level and up', 'check_id' => 'PNL002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PNL003A01', 'name' => 'CPU utilisation is between AMBER and RED level', 'check_id' => 'PNL003', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'PNL003G01', 'name' => 'CPU utilisation is less than AMBER level', 'check_id' => 'PNL003', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'PNL003R01', 'name' => 'CPU utilisation is at RED level and up', 'check_id' => 'PNL003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PSW001A01', 'name' => 'There is at least on current failed job', 'check_id' => 'PSW001', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'PSW001G01', 'name' => 'No current failed jobs', 'check_id' => 'PSW001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'PSW001R01', 'name' => 'Cannot connect to the instance', 'check_id' => 'PSW001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PSW002A01', 'name' => 'There is at least one error in the current error log file', 'check_id' => 'PSW002', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'PSW002G01', 'name' => 'No errors in the current error log file', 'check_id' => 'PSW002', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'PSW003A01', 'name' => 'Signal CPU Waits between 10% (inclusive) and 15% (exclusive)', 'check_id' => 'PSW003', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'PSW003G01', 'name' => 'Signal CPU Waits below 10%', 'check_id' => 'PSW003', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'PSW003R01', 'name' => 'Cannot connect to instance', 'check_id' => 'PSW003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'PSW003R02', 'name' => 'Signal CPU Waits at least 15%', 'check_id' => 'PSW003', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML001G01', 'name' => 'Master process enabled', 'check_id' => 'RML001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'RML001R01', 'name' => 'Master process not enabled (server_id = 0)', 'check_id' => 'RML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML001R02', 'name' => 'Multiple master entries identified', 'check_id' => 'RML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML001R03', 'name' => 'Cannot connect to the instance', 'check_id' => 'RML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML001R04', 'name' => 'Binlogs not enabled (log_bin = OFF)', 'check_id' => 'RML001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML002A01', 'name' => 'Slave behind master by between AMBER and RED seconds', 'check_id' => 'RML002', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'RML002A02', 'name' => 'Slave IO indicates network problems', 'check_id' => 'RML002', 'alert_id' => 'A']);
		CheckResult::create(['id' => 'RML002G01', 'name' => 'Slave process running', 'check_id' => 'RML002', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'RML002R01', 'name' => 'Cannot connect to the instance', 'check_id' => 'RML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML002R02', 'name' => 'Master process faulty', 'check_id' => 'RML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML002R03', 'name' => 'No slave process defined', 'check_id' => 'RML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML002R04', 'name' => 'Slave IO process is not running', 'check_id' => 'RML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML002R05', 'name' => 'Slave SQL process is not running', 'check_id' => 'RML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML002R06', 'name' => 'Replication errors present', 'check_id' => 'RML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RML002R07', 'name' => 'Slave behind master by more than RED seconds', 'check_id' => 'RML002', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RSW001G01', 'name' => 'Backup successful', 'check_id' => 'RSW001', 'alert_id' => 'G']);
		CheckResult::create(['id' => 'RSW001R01', 'name' => 'Cannot connect to instance', 'check_id' => 'RSW001', 'alert_id' => 'R']);
		CheckResult::create(['id' => 'RSW001R02', 'name' => 'At least one database backup failed', 'check_id' => 'RSW001', 'alert_id' => 'R']);
	}
	
}

class ServerCheckResultsTableSeeder extends Seeder {
	
	/**
	 * Randomly creates server check results for test purposes.
	 * 
	 * @param type $healthchecks
	 * @return void
	 */
	public function run($healthchecks = 1000)
	{
		ServerCheckResult::truncate();
		
		$faker = \Faker\Factory::create();
		
		$servers       = Server::lists('id')->all();
		$check_results = CheckResult::lists('id')->all();
		
		for ($i = 0; $i < $healthchecks; $i++)
		{
			$check_result = $faker->randomElement($check_results);
			$date         = date("H-m-d H:i:s");
			
			DB::unprepared(
				"CALL sp_new_server_check_result('"
				. "{$faker->randomElement($servers)}', "
				. "'{$check_result}', "
				. "'{$date}')"
			);
			
			sleep(1);
		}
	}
}

class ReportLevelsTableSeeder extends Seeder {
    
    /**
     * Run the report levels table seeder.
     *
     * @return void
     */
    public function run()
    {
        ReportLevel::truncate();
        
        ReportLevel::create(['id' => 1, 'name' => 'Client']);
        ReportLevel::create(['id' => 2, 'name' => 'Service']);
        ReportLevel::create(['id' => 3, 'name' => 'Site']);
        ReportLevel::create(['id' => 4, 'name' => 'Server']);
    }
}

class ReportTypesTableSeeder extends Seeder {
    
    /**
     * Run the report types table seeder.
     *
     * @return void
     */
    public function run()
    {
        ReportType::truncate();
        
        ReportType::create(['id' => 1, 'name' => 'Daily']);
        ReportType::create(['id' => 2, 'name' => 'Weekly']);
        ReportType::create(['id' => 3, 'name' => 'Monthly']);
        ReportType::create(['id' => 4, 'name' => 'Yearly']);
        ReportType::create(['id' => 5, 'name' => 'Custom']);
    }
}