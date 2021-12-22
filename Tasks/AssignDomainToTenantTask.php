<?php

namespace App\Containers\Vendor\Tenanter\Tasks;

use App\Containers\Vendor\Tenanter\Data\Repositories\DomainRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AssignDomainToTenantTask extends Task
{
    protected DomainRepository $repository;

    public function __construct(DomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($domainName, $new = false, $domainableId = null, $domainableType = null)
    {
        $domain = null;
        $dnsHostname = null;
        $dnsCode = null;
        $data = null;
        $index = null;

        if ($new == false) {
            $hostDomain = config('tenanter.host_domains');
            $domain = $domainName->name . '.' . $hostDomain[1];
            $data['tenant_id'] = $domainName->id;
        } else {
            $domain = $domainName;
            $dnsHostname = Str::random(5) . '.' . $domain;
            $dnsCode = Str::random(14);

        }

        foreach (config('tenanter.configurable_entities') as $key => $value) {
            if($key == $domainableType) {
                $index = $value['model'];
            }
        }

        $data['domain'] = $domain;
        $data['is_active'] = false;
        $data['is_verified'] = false;
        $data['dns_verification_hostname'] = $dnsHostname;
        $data['dns_verification_code'] = $dnsCode;
        $data['verified_at'] = null;
        $data['domainable_type'] = $index;
        $data['domainable_id'] = $domainableId;

        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException($exception);
        }
    }
}
