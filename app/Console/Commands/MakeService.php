<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:service {name?} {--repository=} {--folder=}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a new service class";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");
        $folder = $this->option("folder");

        if (! isset($name) || empty($name)) $this->ask("What should the service be named?");

        $defaultPath = app_path(empty($folder) ? "Services" : "Services/{$folder}");
        $filename = "{$this->argument("name")}Service.php";

        $path = "{$defaultPath}/{$filename}";

        if (! File::exists($defaultPath)) File::makeDirectory($defaultPath);

        if (File::exists($path)) return $this->error("Service class already exist");

        $content = $this->generate();
        File::put($path, $content);
        $messagePath = str_replace(app_path() . "/", "", $path);
        $this->components->info("Service [{$messagePath}] created successfully.");
    }

    private function generate(): string
    {
        $name = $this->argument("name");
        $folder = $this->option("folder");
        $repository = $this->option("repository");
        $repositoryVariable = "$". Str::camel($repository);

        $defaultNamespace = "App\Services";
        $namespace = empty($folder) ? $defaultNamespace : "{$defaultNamespace}\\{$folder}";

        return <<<PHP
        <?php

        namespace {$namespace};

        use App\Repositories\\{$repository};
        use App\Utils\Response;
        use Exception;
        use Illuminate\Database\Eloquent\ModelNotFoundException;
        use Illuminate\Http\JsonResponse;

        class {$name}Service
        {
            public function __construct(
                private {$repository} {$repositoryVariable}
            ){}

            // Service content
        }
        PHP;
    }
}
