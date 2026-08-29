<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    public function getHeader(): ?View
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('is_active', true)->count();
        $totalDepartments = Department::count();

        return view('filament.headers.employee-header', [
            'totalEmployees' => $totalEmployees,
            'activeEmployees' => $activeEmployees,
            'totalDepartments' => $totalDepartments,
        ]);
    }
}
