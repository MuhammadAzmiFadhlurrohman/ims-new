<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;
use App\Models\Department;
use App\Models\Employee;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    public function getHeader(): ?View
    {
        $totalDepartments = Department::count();
        $totalStaff = Employee::where('is_active', true)->count();

        return view('filament.headers.department-header', [
            'totalDepartments' => $totalDepartments,
            'totalStaff' => $totalStaff,
        ]);
    }
}
