<?php

namespace App\Tasks;

use Spatie\Multitenancy\Tasks\SwitchTenantTask;

use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;

class SwitchFilesystemTask implements SwitchTenantTask
{

    /** @var Application */
    protected $app;

    /** @var array */
    public $originalPaths = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->originalPaths = [
            'disks' => [],
            'storage' => $this->app->storagePath(),
            'asset_url' => $this->app['config']['app.asset_url'],
        ];


        $this->app['url']->macro('setAssetRoot', function ($root) {
            $this->assetRoot = $root;

            return $this;
        });
    }

    public function makeCurrent(Tenant $tenant): void
    {
        $this->bootstrap($tenant);
    }

    public function forgetCurrent(): void
    {
        $this->revert();
    }


    public function bootstrap(Tenant $tenant)
    {
        $suffix = $this->app['config']['multitenancy.filesystem.suffix_base'] . $tenant->id;

        // storage_path()
        if ($this->app['config']['multitenancy.filesystem.suffix_storage_path'] ?? true) {
            $this->app->useStoragePath($this->originalPaths['storage'] . "/tenants/{$suffix}");
        }
        
        // asset()
        if ($this->app['config']['multitenancy.filesystem.asset_helper_tenancy'] ?? true) {
            if ($this->originalPaths['asset_url']) {
                $this->app['config']['app.asset_url'] = ($this->originalPaths['asset_url'] ?? $this->app['config']['app.url']) . "/tenants/$suffix";
                $this->app['url']->setAssetRoot($this->app['config']['app.asset_url']);
            } else {
                $this->app['url']->setAssetRoot($this->app['url']->route('multitenancy.asset', ['path' => '']));
            }
        }

        // Storage facade
        Storage::forgetDisk($this->app['config']['multitenancy.filesystem.disks']);

        foreach ($this->app['config']['multitenancy.filesystem.disks'] as $disk) {
            $originalRoot = $this->app['config']["filesystems.disks.{$disk}.root"];
            $this->originalPaths['disks'][$disk] = $originalRoot;

            $finalPrefix = str_replace(
                ['%storage_path%', '%tenant%'],
                [storage_path(), $tenant->id],
                $this->app['config']["multitenancy.filesystem.root_override.{$disk}"] ?? '',
            );

            if (!$finalPrefix) {
                $finalPrefix = $originalRoot
                    ? rtrim($originalRoot, '/') . '/tenants/' . $suffix
                    : 'tenants/' . $suffix;
            }

            $this->app['config']["filesystems.disks.{$disk}.root"] = $finalPrefix;
        }
    }



    public function revert()
    {
        // storage_path()
        $this->app->useStoragePath($this->originalPaths['storage']);

        // asset()
        $this->app['config']['app.asset_url'] = $this->originalPaths['asset_url'];
        $this->app['url']->setAssetRoot($this->app['config']['app.asset_url']);

        // Storage facade
        Storage::forgetDisk($this->app['config']['multitenancy.filesystem.disks']);
        foreach ($this->app['config']['multitenancy.filesystem.disks'] as $disk) {
            $this->app['config']["filesystems.disks.{$disk}.root"] = $this->originalPaths['disks'][$disk];
        }
    }
}
