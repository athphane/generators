<?php

namespace Dash8x\Generators\Commands;

use Dash8x\Generators\Commands\Traits\HasGeneratorOptions;

class GeneratorsPolicyInstallCommand extends InstallFilesAndAppendContentCommand
{
    use HasGeneratorOptions;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generators:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Policy';

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getSettings()
    {
        $permissions_stub = $this->softDeletes() ? 'add-soft-delete-permissions' : 'add-permissions';
        $reg_permissions_stub = $this->softDeletes() ? 'register-soft-delete-permissions-to-roles' : 'register-permissions-to-roles';

        return [
            'add_permissions' => [
                'path' => '/database/seeds/PermissionsSeeder.php',
                'search' => 'protected $data = [',//."\n",
                'stub' => __DIR__ . '/../stubs/seeds/'.$permissions_stub.'.stub',
                'prefix' => false,
            ],
            'register_permissions_to_roles' => [
                'path' => '/database/seeds/RolesSeeder.php',
                'search' => '\'super_admin\' => [\'description\' => \'Super Admin\', \'permissions\' => [',//."\n",
                'stub' => __DIR__ . '/../stubs/seeds/'.$reg_permissions_stub.'.stub',
                'prefix' => false,
            ],
            /*'register_policy' => [
                'path' => '/app/Providers/AuthServiceProvider.php',
                'search' => 'protected $policies = [',//."\n",
                'stub' => __DIR__ . '/../stubs/Providers/register-policy.stub',
                'prefix' => false,
            ],*/
        ];
    }

    /**
     * Get the destination path.
     *
     * @return array
     */
    public function getFiles()
    {
        $name = $this->getSingularClassNameInput();
        $policy_stub = $this->softDeletes() ? 'ModelPolicySoftDeletes' : 'ModelPolicy';

        return [
            'model' => [
                'path' => '/app/Policies/' . $name .'Policy.php',
                'stub' => __DIR__ . '/../stubs/Policies/'.$policy_stub.'.stub',
            ],
        ];
    }
}
