<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:repository {name?} {--model=}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a new repository";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");
        $model = $this->option("model");

        if (! isset($name) || empty($name)) $this->ask("What should the repository be named?");
        if (! isset($model) || empty($model)) $this->ask("What model should be attached?");

        $path = app_path("Repositories/{$this->argument("name")}Repository.php");
        $eloquentPath = app_path("Repositories/Eloquent/Eloquent{$this->argument("name")}Repository.php");

        $this->createDirectory();

        if (File::exists($path)) return $this->error("Repository already exists");
        if (File::exists($eloquentPath)) return $this->error("Eloquent repository already exists");

        $repositoryContent = $this->generateInterface();
        File::put($path, $repositoryContent);
        $messagePath = str_replace(app_path() . "/", "", $path);
        $this->components->info("Repository [{$messagePath}] created successfully.");

        $this->newLine();

        $eloquentContent = $this->generateEloquent();
        File::put($eloquentPath, $eloquentContent);
        $messagePath = str_replace(app_path() . "/", "", $eloquentPath);
        $this->components->info("Repository eloquent [{$messagePath}] created successfully.");
    }

    private function createDirectory(): void
    {
        if (! File::exists(app_path("Repositories")))
            File::makeDirectory(app_path("Repositories"));

        if (! File::exists(app_path("Repositories/Eloquent")))
            File::makeDirectory(app_path("Repositories/Eloquent"));
    }

    private function generateInterface(): string
    {
        $name = $this->argument("name");
        $model = $this->option("model");
        $modelVariable = "$". Str::camel($model);

        return <<<PHP
        <?php

        namespace App\Repositories;

        use App\Models\\{$model};
        use Illuminate\Database\Eloquent\Collection;

        interface {$name}Repository
        {
            public function get(): Collection;
            public function create(array \$data): {$model};
            public function findById({$model} {$modelVariable}): ?{$model};
            public function update({$model} {$modelVariable}, array \$data): ?{$model};
            public function delete({$model} {$modelVariable}): bool;
        }
        PHP;
    }

    private function generateEloquent(): string
    {
        $name = $this->argument("name");
        $model = $this->option("model");
        $modelVariable = "$". Str::camel($model);

        return <<<PHP
        <?php

        namespace App\Repositories\Eloquent;

        use App\Models\\{$model};
        use App\Repositories\\{$name}Repository;
        use Illuminate\Database\Eloquent\Collection;

        class Eloquent{$name}Repository implements {$name}Repository
        {
            protected array \$relations = [];
            
            public function get(): Collection
            {
                return {$model}::all()->sortByDesc("primary");
            }

            public function create(array \$data): {$model}
            {
                return {$model}::create(\$data);
            }

            public function findById({$model} {$modelVariable}): ?{$model}
            {
                return {$modelVariable};
            }

            public function update({$model} {$modelVariable}, array \$data): ?{$model}
            {
                {$modelVariable}->update(\$data);
                return {$modelVariable};
            }

            public function delete({$model} {$modelVariable}): bool
            {
                return {$modelVariable}->delete();
            }
        }
        PHP;
    }
}
