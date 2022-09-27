<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Illuminate\Support\Facades\DB;

class Tenant extends BaseTenant
{

    protected $fillable = ['name', 'database', 'domain'];

    protected static $db_prefix = 'spttestt_';


    protected static function booted()
    {
        static::creating(function (Tenant $model) {
            $model->database = Tenant::$db_prefix . $model->name;
        });


        static::created(function (Tenant $model) {
            $model->createDB();
        });
    }

    /**
     * create database when create a Tenant
     */

    public function createDB()
    {
        DB::beginTransaction();
        try {
            $tenantCon = config('multitenancy.tenant_database_connection_name');

            DB::connection($tenantCon)
                ->statement('CREATE DATABASE ' . $this->database . ';');


            \Artisan::call('tenants:artisan "migrate --path=database/migrations/tenant --database='
                . $tenantCon
                . '"  --tenant=' . $this->id);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getDBName()
    {
        return   self::$db_prefix . $this->database;
    }
}
