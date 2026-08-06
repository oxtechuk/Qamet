<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('2xl'),
            Actions\Action::make('export_csv')
                ->label(__('Export CSV'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $leads = \App\Models\Lead::with(['contactSource', 'car', 'assignedTo'])->get();
                    $csvData = "ID,Client Name,Client Phone,Client Email,Source,Interested Car,Status,Assigned To,Created At\n";

                    foreach ($leads as $lead) {
                        $csvData .= sprintf(
                            "\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                            $lead->id,
                            str_replace('"', '""', $lead->client_name),
                            str_replace('"', '""', $lead->client_phone),
                            str_replace('"', '""', $lead->client_email ?? ''),
                            str_replace('"', '""', $lead->contactSource?->name ?? ''),
                            str_replace('"', '""', $lead->car?->name ?? ''),
                            str_replace('"', '""', $lead->status_label),
                            str_replace('"', '""', $lead->assignedTo?->name ?? ''),
                            $lead->created_at->format('Y-m-d H:i')
                        );
                    }

                    return response()->streamDownload(function () use ($csvData) {
                        echo "\xEF\xBB\xBF";
                        echo $csvData;
                    }, 'leads_export_'.date('Y-m-d_H-i').'.csv', [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                    ]);
                }),
        ];
    }
}
