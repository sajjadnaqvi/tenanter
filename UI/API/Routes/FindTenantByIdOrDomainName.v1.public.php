<?php

/**
 * @apiGroup           Tenant
 * @apiName            findTenantByDomain
 *
 * @api                {GET} /v1/tenant/{id} Find Tanent by Domain name
 * @apiDescription     search on the base of domain name such as www/example.com
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User, tenant-admin, view-tenant
 *
 * @apiParam           {String}  domain name of domain eg. www.example.com
 *
 * @apiUse             TenantSuccessSingleResponse
 */

use App\Containers\Vendor\Tenanter\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('tenant/{id}', [Controller::class, 'findTenantByIdOrDomainName'])
    ->name('api_tenanter_find_tenant_by_domain')
    ->middleware(['auth:api']);
