<?php

namespace App\Containers\Vendor\Tenanter\Actions;

use App\Containers\Vendor\Tenanter\Tasks\UpdateTenantTask;
use App\Containers\Vendor\Tenanter\UI\API\Requests\DeactivateTenantRequest;
use App\Ship\Parents\Actions\Action;

class DeactivateTenantAction extends Action
{
    public function run(DeactivateTenantRequest $request)
    {
        $tenant = app(UpdateTenantTask::class)->run($request->id, [
            'is_active' => false
        ]);

        return $tenant;
    }
}
