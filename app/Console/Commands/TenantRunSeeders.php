<?php
namespace App\Console\Commands;


use Illuminate\Console\Command;
use Spatie\Multitenancy\Commands\Concerns\TenantAware;
use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class TenantRunSeeders extends Command
{
    use TenantAware;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed-tenant {--tenant=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed tenants';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        echo "\n--------------------------------------------------\n";
        echo "Tenant ID:" . Tenant::current()->id . "\n";
        try {
            $tenantCon = config('multitenancy.tenant_database_connection_name');
            $params = [];
            $params['--class'] = 'TenantSeeder';
            $params['--database'] =  $tenantCon;

            Artisan::call('db:seed', $params);

             echo"Seed Success \n";
        } catch (\Throwable $th) {
            echo $th->getMessage() . "\n";
        }
    }
}
