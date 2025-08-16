<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create a new module structure';

    public function handle()
    {
        $name = $this->argument('name');
        $basePath = app_path('Modules/' . $name);

        // Проверка существования модуля
        if (File::exists($basePath)) {
            $this->error("Module $name already exists!");
            return;
        }

        // Создание директорий
        File::makeDirectory($basePath, 0755, true);
        File::makeDirectory("$basePath/Controllers", 0755);
        File::makeDirectory("$basePath/Models", 0755);
        File::makeDirectory("$basePath/Routes", 0755);

        // Генерация файлов
        $this->createModuleClass($name, $basePath);
        $this->createRouteFile($name, $basePath);
        $this->createController($name, $basePath);

        $this->info("Module $name created successfully!");
    }

    private function createModuleClass($name, $basePath)
    {
        $content = <<<EOT
        <?php

        namespace App\Modules\\$name;

        use App\Interfaces\ModuleInterface;
        use App\Modules\\$name\Routes\Route;

        class $name implements ModuleInterface
        {
            private \$name = '$name';
            private \$version = '0.0.1';

            public function enable(): bool
            {
                return true;
            }

            public function disable(): bool
            {
                return true;
            }

            public function registerRoutes(): ModuleInterface
            {
                Route::index();

                return \$this;
            }

            public function getName(): string
            {
                return \$this->name;
            }

            public function getVersion(): string
            {
                return \$this->version;
            }
        }
        EOT;

        File::put("$basePath/$name.php", $content);
    }

    private function createRouteFile($name, $basePath)
    {
        $routeName = Str::lower($name);
        $content = <<<EOT
        <?php

        namespace App\Modules\\$name\Routes;

        class Route extends \Illuminate\Support\Facades\Route
        {
            static function index(): void
            {
                self::namespace('App\Modules\\\\$name\\\\Controllers')
                    ->group(fn() => self::routers())
                    ->name('$routeName.routes');
            }

            private static function routers(): void
            {

            }
        }
        EOT;

        File::put("$basePath/Routes/Route.php", $content);
    }

    private function createController($name, $basePath)
    {
        $content = <<<EOT
        <?php

        namespace App\Modules\\$name\Controllers;

        abstract class Controller
        {

        }
        EOT;

        File::put("$basePath/Controllers/Controller.php", $content);
    }
}
