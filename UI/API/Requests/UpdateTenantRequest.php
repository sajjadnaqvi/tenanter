<?php

namespace App\Containers\Vendor\Tenanter\UI\API\Requests;

use App\Containers\Vendor\Tenanter\Traits\CheckDomainNameTrait;
use App\Containers\Vendor\Tenanter\Traits\IsTenantOwnerTrait;
use App\Ship\Parents\Requests\Request;

/**
 * Class UpdateTenantRequest.
 */
class UpdateTenantRequest extends Request
{
    use IsTenantOwnerTrait;

    /**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'permissions' => 'edit-tenant',
        'roles' => 'admin|tenant-admin',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [
        // 'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
     */
    protected $urlParameters = [
        'id',
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'unique:tenants,name',
            'domain' => "regex:/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/|unique:tenants,domain"

        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess',
            'IsTenantOwner'
        ]);
    }
}
