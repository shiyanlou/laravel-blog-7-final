<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExportUsersCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'export:users';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Export all users';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$output_path = $this->argument('file');
		$headers = ['ID', 'E-mail', 'NickName', 'is_admin', 'is_block', 'CreateDateTime'];
		$rows = $this->getUsersData();
		if ($output_path) {
			$handle = fopen($output_path, 'w');
			if ($this->option('headers')) {
				fputcsv($handle, $headers);
			}
			foreach ($rows as $row) {
				fputcsv($handle, $row);
			}
			fclose($handle);
			$this->info("Exported list to $output_path");
		} else {
			$table = $this->getHelperSet()->get('table');
			$table->setHeaders($headers)->setRows($rows);
			$table->render($this->getOutput());
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('file', InputArgument::OPTIONAL, 'The output file path', null),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('headers', null, InputOption::VALUE_NONE, 'Display headers?', null),
		);
	}

	protected function getUsersData()
	{
		$users = User::all();
	    foreach ($users as $user) {
	        $output[] = [$user->id, $user->email, $user->nickname, 
	                     $user->is_admin, $user->block, $user->created_at];
	    }
	    return $output;
	}
}