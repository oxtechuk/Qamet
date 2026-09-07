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
            Actions\Action::make('rebalance_all_leads')
                ->label('إعادة التوزيع العادل للعملاء')
                ->icon('heroicon-o-arrow-path-rounded-square')
                ->color('warning')
                ->visible(fn () => (bool) (\Illuminate\Support\Facades\Auth::guard('employee')->user()?->isAdmin() || \Illuminate\Support\Facades\Auth::guard('employee')->user()?->hasPermission('manage-leads')))
                ->requiresConfirmation()
                ->modalHeading('إعادة التوزيع العادل للعملاء المحتملين')
                ->modalDescription('سيقوم النظام بتوزيع جميع العملاء غير المغلقين بالتساوي بين كافة مناديب المبيعات النشطين.')
                ->action(function () {
                    $leads = \App\Models\Lead::whereNotIn('status', ['lost', 'rejected', 'cancelled'])->get();
                    $service = app(\App\Services\BookingAssignmentService::class);
                    $result = $service->redistributeLeads($leads);

                    $repsBreakdown = [];
                    foreach ($result['reps_summary'] as $repName => $count) {
                        $repsBreakdown[] = "• {$repName}: {$count} عميل";
                    }

                    \Filament\Notifications\Notification::make()
                        ->title('تمت إعادة التوزيع العادل للعملاء بنجاح')
                        ->body("تم توزيع {$result['assigned']} عميل بالتساوي:\n".implode("\n", $repsBreakdown))
                        ->success()
                        ->duration(8000)
                        ->send();
                }),
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
