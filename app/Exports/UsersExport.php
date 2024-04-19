<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::get()->map(function ($user) {
            
            if ($user->hasRole('administrator')) {
                $role = 'Administrator';
            } elseif ($user->hasRole('staff')) {
                $role = 'Staff';
            }
            
            return [
                'Name' => $user->name,
                'Email' => $user->email,
                'Role' => $role,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['USERS REPORT'],
            [],
            [
            'Name',
            'Email',
            'Role',
            ],
        ];
    }
}
