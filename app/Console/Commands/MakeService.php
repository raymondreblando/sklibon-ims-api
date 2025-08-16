<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeService extends Command
{
    protected $signature = "make:service {name?} {--repository=}";
    protected $description = "Create a new service class";

    public function handle()
    {
        $name = $this->argument("name");

        if (! $name) {
            $name = $this->ask("What should the service be named?");
        }

        $name = Str::studly($name);
        $segments = explode("/", $name);
        $className = array_pop($segments);
        $subfolder = implode("/", $segments);

        $defaultPath = app_path("Services" . (!empty($subfolder) ? "/{$subfolder}" : ""));
        $filename = "{$className}Service.php";
        $path = "{$defaultPath}/{$filename}";

        if (! File::exists($defaultPath)) {
            File::makeDirectory($defaultPath, 0755, true);
        }

        if (File::exists($path)) {
            return $this->error("Service class already exists");
        }

        $content = $this->generate($className, $subfolder);
        File::put($path, $content);

        $messagePath = str_replace(app_path() . "/", "", $path);
        $this->components->info("Service [{$messagePath}] created successfully.");
    }

    private function generate(string $className, string $subfolder): string
    {
        $repository = $this->option("repository");
        $repositoryVariable = $repository ? "$" . Str::camel($repository) : '';

        $defaultNamespace = "App\Services";
        $namespace = empty($subfolder)
            ? $defaultNamespace
            : $defaultNamespace . "\\" . str_replace("/", "\\", $subfolder);

        return <<<PHP
        <?php

        namespace {$namespace};

        use App\Repositories\\{$repository};
        use App\Utils\Response;
        use Illuminate\Http\JsonResponse;

        class {$className}Service
        {
            public function __construct(
                private {$repository} {$repositoryVariable}
            ){}

            // Service content
        }
        PHP;
    }
}
