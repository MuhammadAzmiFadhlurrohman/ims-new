<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\CustomerSubscription;
use App\Models\PackageMutation;
use App\Models\ServiceSuspension;
use App\Models\ServiceTermination;
use App\Models\Ticket;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket-resource.pages.list-tickets';

    public function getHeading(): string
    {
        $category = request()->query('category');

        return match ($category) {
            'gangguan' => 'Daftar Tiket: Gangguan Layanan',
            'ubah_password' => 'Daftar Tiket: Ubah Password Wifi',
            'coverage' => 'Daftar Tiket: Cek Coverage Area',
            'all' => 'Daftar Semua Tiket Masuk',
            default => '',
        };
    }

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin') => 'IMS',
            '#' => 'Tiket',
        ];
    }

    protected function getHeaderActions(): array
    {
        $category = request()->query('category');

        if ($category) {
            return [
                Actions\Action::make('back_to_portal')
                    ->label('← Kembali ke Pilihan Tiket')
                    ->url(url('/admin/tickets'))
                    ->color('secondary')
                    ->button(),
                Actions\CreateAction::make()->label('+ Buat Tiket Baru'),
            ];
        }

        return [];
    }

    public function getCounts(): array
    {
        return [
            'gangguan' => Ticket::whereIn('category', ['LOS', 'LAMBAT', 'KABEL_PUTUS', 'GANGGUAN'])->count(),
            'ubah_password' => Ticket::whereIn('category', ['UBAH_PASSWORD', 'PASSWORD'])->count(),
            'coverage' => Ticket::where('category', 'COVERAGE')->count(),
            'terminasi' => ServiceTermination::whereNotIn('status', ['KD14', 'TERMINATED', 'Closed', 'Canceled', 'DONE', 'Selesai'])->count()
                ?: Ticket::whereIn('category', ['TERMINASI', 'PUTUS'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count(),
            'suspend' => ServiceSuspension::whereNotIn('status', ['DONE', 'Canceled', 'CLOSED'])->count()
                ?: Ticket::whereIn('category', ['SUSPEND', 'ISOLIR'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count(),
            'psb' => CustomerSubscription::where(function ($q) {
                $q->whereNotIn('registration_status', [
                    'LIVE', '20', 'Aktif', 'AKTIF', 'aktif', 'Active', 'ACTIVE',
                    'Selesai Aktivasi', '21', 'Suspend', 'SUSPEND', '23', 'Terminasi', 'TERMINASI', 'REQ. TERMINASI'
                ])->orWhereNull('registration_status');
            })->count() ?: Ticket::whereIn('category', ['PSB', 'PEMASANGAN_BARU'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count(),
            'ubah_layanan' => PackageMutation::whereNotIn('status', ['Closed', 'COMPLETED', 'Canceled', 'REJECTED'])->count()
                ?: Ticket::whereIn('category', ['UBAH_LAYANAN', 'MUTASI'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count(),
        ];
    }

    public function getTabs(): array
    {
        if (!request()->has('category')) {
            return [];
        }

        return [
            'all' => Tab::make('Semua'),
            'antrian' => Tab::make('Antrian (Open)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'OPEN')),
            'proses' => Tab::make('Dalam Proses')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'IN_PROGRESS')),
            'selesai' => Tab::make('Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', ['RESOLVED', 'CLOSED'])),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        $query = parent::getTableQuery();
        $category = request()->query('category');

        if (!$category) {
            return $query->whereRaw('1 = 0');
        }

        if ($category === 'gangguan') {
            return $query->whereIn('category', ['LOS', 'LAMBAT', 'KABEL_PUTUS', 'GANGGUAN']);
        }

        if ($category === 'ubah_password') {
            return $query->whereIn('category', ['UBAH_PASSWORD', 'PASSWORD']);
        }

        if ($category === 'coverage') {
            return $query->where('category', 'COVERAGE');
        }

        return $query;
    }
}
