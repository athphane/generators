<?php

namespace Dash8x\Generators\Commands;

use Dash8x\Generators\Commands\Traits\HasGeneratorOptions;
use Dash8x\Generators\Commands\Traits\CanReplaceKeywords;

class GeneratorsRoutesInstallCommand extends AppendContentCommand
{
    use HasGeneratorOptions;
    use CanReplaceKeywords;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Routes';

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getSettings()
    {
        $admin_routes_stub = $this->softDeletes() ? 'admin-soft-deletes' : 'admin';

        return [
            'admin_routes' => [
                'path' => '/routes/admin.php',
                'search' => 'Route::resource(\'users\', \'UsersController\');',//."\n\n",
                'stub' => __DIR__ . '/../stubs/routes/'.$admin_routes_stub.'.stub',
                'prefix' => false,
            ],
            'admin_sidebar_links' => [
                'path' => '/resources/views/admin/partials/sidebar.blade.php',
                'search' => '$menu_items = [',
                'stub' => __DIR__ . '/../stubs/views/sidebar-links.blade.stub',
                'prefix' => false,
            ],
        ];
    }
}
