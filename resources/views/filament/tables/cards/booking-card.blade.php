@php
    /** @var \Illuminate\Support\Collection $records */
    $records = $records ?? collect();
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    @foreach ($records as $record)
        @php
            $statusColors = match($record->status) {
                'new' => ['dot' => '#6366f1', 'label' => __('New')],
                'contacted' => ['dot' => '#06b6d4', 'label' => __('Contacted')],
                'interested' => ['dot' => '#eab308', 'label' => __('Interested')],
                'negotiation' => ['dot' => '#f97316', 'label' => __('Negotiation')],
                'sold' => ['dot' => '#22c55e', 'label' => __('Sold')],
                'rejected' => ['dot' => '#ef4444', 'label' => __('Rejected')],
                'cancelled' => ['dot' => '#94a3b8', 'label' => __('Cancelled')],
                default => ['dot' => '#94a3b8', 'label' => __('Unknown')],
            };

            $initials = collect(explode(' ', $record->client_name))
                ->map(fn ($w) => mb_substr($w, 0, 1))
                ->take(2)
                ->join('');
        @endphp

        <div class="group relative rounded-xl bg-white shadow-[0_1px_2px_0_rgb(0_0_0_/_0.03),0_1px_3px_0_rgb(0_0_0_/_0.06)] transition-all duration-200 hover:shadow-[0_4px_12px_0_rgb(0_0_0_/_0.08),0_2px_4px_0_rgb(0_0_0_/_0.04)] hover:-translate-y-0.5">
            {{-- Top colored indicator --}}
            <div style="height: 3px; background: {{ $statusColors['dot'] }}; border-radius: 0.75rem 0.75rem 0 0;"></div>

            <div class="p-4">
                {{-- Row 1: Client + Status --}}
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: {{ $statusColors['dot'] }}15; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: {{ $statusColors['dot'] }}; font-size: 0.8125rem; font-weight: 700;">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate leading-snug">{{ $record->client_name }}</p>
                            @if ($record->client_phone)
                                <p class="text-xs text-gray-400 mt-0.5" dir="ltr">{{ $record->client_phone }}</p>
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.375rem; padding: 0.1875rem 0.625rem; border-radius: 9999px; background: {{ $statusColors['dot'] }}12; flex-shrink: 0;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $statusColors['dot'] }}; display: inline-block;"></span>
                        <span style="font-size: 0.6875rem; font-weight: 600; color: {{ $statusColors['dot'] }}; white-space: nowrap;">{{ $statusColors['label'] }}</span>
                    </div>
                </div>

                {{-- Row 2: Car info --}}
                @if ($record->car)
                    <div class="flex items-center gap-2 mb-2.5">
                        <span class="text-sm text-gray-500">🚗</span>
                        <span class="text-sm font-medium text-gray-800 truncate">{{ $record->car->name }}</span>
                    </div>
                @endif

                {{-- Row 3: Price + Assigned --}}
                <div class="flex items-center justify-between">
                    @if ($record->total_price)
                        <div class="flex items-baseline gap-1">
                            <span class="text-sm font-bold text-gray-900">{{ number_format($record->total_price, 0) }}</span>
                            <span class="text-[0.6875rem] font-medium text-gray-400">{{ __('SAR') }}</span>
                        </div>
                    @else
                        <div></div>
                    @endif

                    @if ($record->assignedTo)
                        <span class="text-[0.6875rem] text-gray-400 truncate ml-2">{{ $record->assignedTo->name }}</span>
                    @endif
                </div>

                {{-- Row 4: Date --}}
                <div class="mt-2">
                    <span class="text-[0.6875rem] text-gray-400">{{ $record->created_at->format('d M Y, h:i A') }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex border-t border-gray-100 divide-x divide-gray-100">
                <a href="{{ route('filament.admin.resources.bookings.view', $record) }}" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-[0.6875rem] font-semibold text-gray-400 hover:text-indigo-600 hover:bg-indigo-50/40 transition-colors">
                    <x-filament::icon icon="heroicon-m-eye" class="w-3.5 h-3.5" />
                    {{ __('View') }}
                </a>
                <a href="{{ route('filament.admin.resources.bookings.edit', $record) }}" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-[0.6875rem] font-semibold text-gray-400 hover:text-indigo-600 hover:bg-indigo-50/40 transition-colors">
                    <x-filament::icon icon="heroicon-m-pencil-square" class="w-3.5 h-3.5" />
                    {{ __('Edit') }}
                </a>
            </div>
        </div>
    @endforeach
</div>
