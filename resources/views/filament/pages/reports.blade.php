<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('Reports & Analytics') }}
        </x-slot>

        <form wire:submit="updatedFilters" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('From') }}</label>
                    <input type="date" wire:model.live="filters.date_from" class="fi-input block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('To') }}</label>
                    <input type="date" wire:model.live="filters.date_to" class="fi-input block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                </div>
            </div>
        </form>
    </x-filament::section>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-filament::section>
            <div class="text-sm text-gray-500">{{ __('Total Bookings') }}</div>
            <div class="text-2xl font-bold">{{ number_format($this->getFinancialStats()['total_bookings']) }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">{{ __('Completed Sales') }}</div>
            <div class="text-2xl font-bold text-emerald-600">{{ number_format($this->getFinancialStats()['sold_count']) }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">{{ __('Total Revenue') }}</div>
            <div class="text-2xl font-bold text-primary-600">{{ number_format($this->getFinancialStats()['total_revenue'], 0) }} {{ __('SAR') }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">{{ __('Total Down Payments') }}</div>
            <div class="text-2xl font-bold">{{ number_format($this->getFinancialStats()['total_down_payments'], 0) }} {{ __('SAR') }}</div>
        </x-filament::section>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <x-filament::section>
            <x-slot name="heading">{{ __('Installment Analysis') }}</x-slot>
            <dl class="space-y-3 mt-4">
                <div class="flex justify-between">
                    <dt>{{ __('Avg Down Payment') }}</dt>
                    <dd class="font-semibold">{{ number_format($this->getFinancialStats()['avg_down_payment'] ?? 0, 0) }} {{ __('SAR') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt>{{ __('Avg Monthly Installment') }}</dt>
                    <dd class="font-semibold">{{ number_format($this->getFinancialStats()['avg_monthly'] ?? 0, 0) }} {{ __('SAR') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt>{{ __('Avg Duration') }}</dt>
                    <dd class="font-semibold">{{ number_format($this->getFinancialStats()['avg_duration'] ?? 0, 1) }} {{ __('years') }}</dd>
                </div>
            </dl>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">{{ __('Top Requested Cars') }}</x-slot>
            <ul class="divide-y mt-4">
                @forelse($this->getTopCars() as $car)
                    <li class="py-2 flex justify-between">
                        <span>{{ $car['car']['name'] ?? __('N/A') }} <span class="text-gray-400">{{ $car['car']['brand']['name'] ?? '' }}</span></span>
                        <span class="font-semibold">{{ $car['total'] }} {{ __('sales') }}</span>
                    </li>
                @empty
                    <li class="py-4 text-center text-gray-400">{{ __('No data yet') }}</li>
                @endforelse
            </ul>
        </x-filament::section>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-filament::section>
            <x-slot name="heading">{{ __('Employee Performance') }}</x-slot>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="py-2 font-medium">{{ __('Employee') }}</th>
                            <th class="py-2 font-medium">{{ __('Total') }}</th>
                            <th class="py-2 font-medium">{{ __('Sold') }}</th>
                            <th class="py-2 font-medium">{{ __('Rate') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->getEmployeePerformance() as $emp)
                            <tr class="border-b">
                                <td class="py-2">{{ $emp['name'] }}</td>
                                <td class="py-2">{{ $emp['total_bookings'] ?? 0 }}</td>
                                <td class="py-2 text-emerald-600">{{ $emp['sold_bookings'] ?? 0 }}</td>
                                <td class="py-2">
                                    @php $rate = ($emp['total_bookings'] ?? 0) > 0 ? round(($emp['sold_bookings'] ?? 0) / $emp['total_bookings'] * 100) : 0; @endphp
                                    {{ $rate }}%
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 text-center text-gray-400">{{ __('No data yet') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">{{ __('Customer Sources') }}</x-slot>
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="py-2 font-medium">{{ __('Source') }}</th>
                            <th class="py-2 font-medium">{{ __('Leads') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->getSourcePerformance() as $source)
                            <tr class="border-b">
                                <td class="py-2">{{ $source['source']['name'] ?? __('N/A') }}</td>
                                <td class="py-2">{{ $source['total_leads'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-4 text-center text-gray-400">{{ __('No data yet') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
