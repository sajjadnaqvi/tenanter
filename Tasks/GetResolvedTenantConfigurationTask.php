<?php

namespace App\Containers\Vendor\Tenanter\Tasks;

use App\Containers\Vendor\Configurationer\Configurationer;
use App\Containers\Vendor\Configurationer\Data\Repositories\ConfigurationRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Exceptions\Exception;

class GetResolvedTenantConfigurationTask extends Task
{
    protected ConfigurationRepository $repository;

    public function __construct(ConfigurationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(Request $request, $type, $transform=null)
    {
         if(tenancy()->initialized && tenancy()->tenantInitialized) {

             $configurations = $this->repository->findWhere([
                 'configurable_id' => tenant()->getTenantKey(),
                 'configurable_type' => configurationer()::getModel($type)
             ])->first();

             if ($configurations) {
                 $configurations->configuration = (array) json_decode($configurations->configuration);
                 if($transform) {
                     return $configurations;
                 }
                 return $configurations->configuration;
             }
         }

        return [];
    }
}
