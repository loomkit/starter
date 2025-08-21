<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\Permissions\Pages;

use App\Filament\Admin\Clusters\Settings\Resources\Permissions\PermissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;
}
