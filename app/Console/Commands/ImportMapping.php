<?php

namespace App\Console\Commands;

use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use App\Services\RequestValidator;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:jsonData {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import User company data
                                {filePath : File path of the json file}
                                ';
    /**
     * @var RequestValidator
     */
    private $validator;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RequestValidator $validator, UserRepository $userRepo, CompanyRepository $compRepo)
    {
        parent::__construct();
        $this->validator = $validator;
        $this->userRepo = $userRepo;
        $this->compRepo = $compRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Do you wish to continue?', true)) {
            try {
                $filePath = $this->argument('filePath');

                $this->info('The command has started');

                $content =  file_get_contents($filePath);
                $dataArr = json_decode($content, true);
                if (array_key_exists("users", $dataArr)) {
                    $errors = $this->validator->validate($dataArr);

                    if ($errors) {
                        $this->error("Validation failed while processing the json data" . json_encode($errors));
                    }

                    $data = $dataArr["users"];
                    foreach ($data as $attr) {
                        $companies = $attr['companies'];
                        unset($attr['companies']);
                        $user = $this->userRepo->firstOrCreate($attr);
                        $companyIds = [];
                        foreach ($companies as $companyData) {
                            $company = $this->compRepo->firstOrCreate($companyData);
                            $companyIds[] = $company->id;
                        }
                        $user->companies()->sync($companyIds);
                    }
                }
                $this->info('The command has completed');
            } catch (\Throwable $exception) {
                $this->error("Exception thrown while processing the file" . $exception->getMessage());
            }
        }
        return 0;
    }
}
