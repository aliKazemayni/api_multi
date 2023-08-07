<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Miladshm\ControllerHelpers\Http\Traits\HasApiDatatable;
use Miladshm\ControllerHelpers\Http\Traits\HasDestroy;
use Miladshm\ControllerHelpers\Http\Traits\HasShow;
use Miladshm\ControllerHelpers\Http\Traits\HasStore;
use Miladshm\ControllerHelpers\Http\Traits\HasUpdate;

class CompanyController extends Controller
{
    use HasApiDatatable , HasStore , HasShow , HasUpdate , HasDestroy;

    private function extraData(Model $item = null): ?array
    {
       return [];
    }

    private function model(): Model
    {
        return new Company();
    }

    private function relations(): array
    {
        return [];
    }

    private function requestClass(): FormRequest
    {
        return new StoreCompanyRequest();
    }
}
