<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    public function getHeader(): ?View
    {
        $roleModel = Utils::getRoleModel();
        $permissionModel = Utils::getPermissionModel();

        $totalRoles = $roleModel::count();
        $totalPermissions = $permissionModel::count();

        return view('filament.headers.role-header', [
            'totalRoles' => $totalRoles,
            'totalPermissions' => $totalPermissions,
        ]);
    }
}
