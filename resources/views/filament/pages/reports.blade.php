<x-filament-panels::page>
    <!-- Custom styling for premium look -->
    <style>
        .report-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(243, 246, 248, 0.9) 100%);
            border: 1px solid rgba(223, 198, 116, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dark .report-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
            border: 1px solid rgba(223, 198, 116, 0.15);
        }
        .report-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(223, 198, 116, 0.12);
            border-color: rgba(223, 198, 116, 0.5);
        }
        .progress-bar-fill {
            transition: width 0.8s ease-in-out;
        }
        .tab-btn {
            position: relative;
            transition: all 0.2s ease;
        }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #dfc674;
            border-radius: 9999px;
        }
    </style>

    <!-- Filters Section -->
    <x-filament::section class="mb-2">
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-filament::icon alias="panels::pages.dashboard.navigation-item" icon="heroicon-m-funnel" class="h-5 w-5 text-gray-500" />
                <span>{{ __('فلاتر التقارير والتحليلات') }}</span>
            </div>
        </x-slot>

        <form wire:submit.prevent="updatedFilters" class="mt-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Date From -->
                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-600 dark:text-gray-400">{{ __('تاريخ البداية (From)') }}</label>
                    <input type="date" wire:model.live="filters.date_from" class="fi-input block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-primary-500 focus:ring-primary-500">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-600 dark:text-gray-400">{{ __('تاريخ النهاية (To)') }}</label>
                    <input type="date" wire:model.live="filters.date_to" class="fi-input block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-primary-500 focus:ring-primary-500">
                </div>

                <!-- Employee Filter -->
                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-600 dark:text-gray-400">{{ __('فلترة بالموظف') }}</label>
                    <select wire:model.live="filters.employee_id" class="fi-select block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">{{ __('جميع الموظفين') }}</option>
                        @foreach($this->getFilterEmployees() as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Car Filter -->
                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-600 dark:text-gray-400">{{ __('فلترة بالسيارة') }}</label>
                    <select wire:model.live="filters.car_id" class="fi-select block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">{{ __('جميع السيارات') }}</option>
                        @foreach($this->getFilterCars() as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </x-filament::section>

    <!-- Tab Bar -->
    <div class="flex border-b border-gray-200 dark:border-gray-800 gap-6 mb-4 overflow-x-auto">
        <button wire:click="changeTab('overview')" class="tab-btn py-3 text-sm font-bold flex items-center gap-2 {{ $activeTab === 'overview' ? 'active text-primary-600 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400' }}">
            <x-filament::icon icon="heroicon-m-presentation-chart-bar" class="h-4 w-4" />
            {{ __('نظرة عامة') }}
        </button>
        <button wire:click="changeTab('sales_details')" class="tab-btn py-3 text-sm font-bold flex items-center gap-2 {{ $activeTab === 'sales_details' ? 'active text-primary-600 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400' }}">
            <x-filament::icon icon="heroicon-m-document-text" class="h-4 w-4" />
            {{ __('تفاصيل المبيعات') }}
        </button>
        <button wire:click="changeTab('employees')" class="tab-btn py-3 text-sm font-bold flex items-center gap-2 {{ $activeTab === 'employees' ? 'active text-primary-600 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400' }}">
            <x-filament::icon icon="heroicon-m-user-group" class="h-4 w-4" />
            {{ __('أداء فريق العمل') }}
        </button>
        <button wire:click="changeTab('sources')" class="tab-btn py-3 text-sm font-bold flex items-center gap-2 {{ $activeTab === 'sources' ? 'active text-primary-600 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400' }}">
            <x-filament::icon icon="heroicon-m-arrow-trending-up" class="h-4 w-4" />
            {{ __('مصادر العملاء') }}
        </button>
    </div>

    <!-- Active Tab Content -->
    @if($activeTab === 'overview')
        <!-- 1. OVERVIEW TAB -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Bookings -->
            <div class="report-card p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ __('إجمالي الحجوزات') }}</span>
                        <div class="p-2 bg-primary-50 dark:bg-primary-950/30 rounded-xl text-primary-600">
                            <x-filament::icon icon="heroicon-m-list-bullet" class="h-5 w-5" />
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format($this->getFinancialStats()['total_bookings']) }}</div>
                </div>
                <div class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ __('كل الطلبات المكتملة وغير المكتملة') }}</div>
            </div>

            <!-- Completed Sales -->
            <div class="report-card p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ __('المبيعات الناجحة') }}</span>
                        <div class="p-2 bg-emerald-50 dark:bg-emerald-950/30 rounded-xl text-emerald-600">
                            <x-filament::icon icon="heroicon-m-check-badge" class="h-5 w-5" />
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ number_format($this->getFinancialStats()['sold_count']) }}</div>
                </div>
                <div class="text-xs text-emerald-500 mt-2 font-medium">
                    @php 
                        $total = $this->getFinancialStats()['total_bookings'];
                        $sold = $this->getFinancialStats()['sold_count'];
                        $conv = $total > 0 ? round(($sold / $total) * 100, 1) : 0;
                    @endphp
                    {{ __('معدل نجاح:') }} {{ $conv }}%
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="report-card p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ __('إجمالي قيمة المبيعات') }}</span>
                        <div class="p-2 bg-yellow-50 dark:bg-yellow-950/30 rounded-xl text-yellow-600">
                            <x-filament::icon icon="heroicon-m-banknotes" class="h-5 w-5" />
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-primary-600 dark:text-primary-400">{{ number_format($this->getFinancialStats()['total_revenue'], 0) }} <span class="text-sm font-bold">{{ __('SAR') }}</span></div>
                </div>
                <div class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ __('السيارات التي تم بيعها واستلام قيمتها') }}</div>
            </div>

            <!-- Down Payments -->
            <div class="report-card p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ __('إجمالي الدفعات المقدمة') }}</span>
                        <div class="p-2 bg-blue-50 dark:bg-blue-950/30 rounded-xl text-blue-600">
                            <x-filament::icon icon="heroicon-m-credit-card" class="h-5 w-5" />
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">{{ number_format($this->getFinancialStats()['total_down_payments'], 0) }} <span class="text-sm font-bold">{{ __('SAR') }}</span></div>
                </div>
                <div class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ __('الدفعات المقدمة المحصلة') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Installment Analytics -->
            <x-filament::section class="report-card">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-m-calculator" class="h-5 w-5 text-gray-500" />
                        <span>{{ __('تحليل عمليات التقسيط والتمويل') }}</span>
                    </div>
                </x-slot>
                
                <div class="space-y-4 mt-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('متوسط الدفعة الأولى (Avg Down Payment)') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ number_format($this->getFinancialStats()['avg_down_payment'], 0) }} {{ __('SAR') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('متوسط القسط الشهري (Avg Installment)') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ number_format($this->getFinancialStats()['avg_monthly'], 0) }} {{ __('SAR') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('متوسط فترة التمويل بالسنوات') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ number_format($this->getFinancialStats()['avg_duration'], 1) }} {{ __('سنوات') }}</span>
                    </div>
                </div>
            </x-filament::section>

            <!-- Top Requested Cars -->
            <x-filament::section class="report-card">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-m-truck" class="h-5 w-5 text-gray-500" />
                        <span>{{ __('السيارات الأكثر طلباً ومبيعاً') }}</span>
                    </div>
                </x-slot>
                
                <ul class="divide-y divide-gray-100 dark:divide-gray-800 mt-2">
                    @forelse($this->getTopCars() as $index => $car)
                        <li class="py-3 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-xs px-2 py-1 rounded bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300">#{{ $index + 1 }}</span>
                                <div>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $car['car']['name'] ?? __('N/A') }}</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 block">{{ $car['car']['brand']['name'] ?? '' }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-primary-600 dark:text-primary-400">{{ $car['total'] }} {{ __('بيعة') }}</span>
                        </li>
                    @empty
                        <li class="py-6 text-center text-gray-400">{{ __('لا توجد بيانات كافية حالياً') }}</li>
                    @endforelse
                </ul>
            </x-filament::section>
        </div>

    @elseif($activeTab === 'sales_details')
        <!-- 2. SALES DETAILS TAB -->
        <x-filament::section class="report-card">
            <x-slot name="heading">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-2">
                        <x-filament::icon icon="heroicon-m-table-cells" class="h-5 w-5 text-gray-500" />
                        <span>{{ __('جدول تفاصيل المبيعات والحجوزات الأخيرة') }}</span>
                    </div>
                </div>
            </x-slot>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-right border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-800 text-gray-500">
                            <th class="py-3 px-4 font-bold text-xs uppercase">{{ __('العميل') }}</th>
                            <th class="py-3 px-4 font-bold text-xs uppercase">{{ __('السيارة') }}</th>
                            <th class="py-3 px-4 font-bold text-xs uppercase">{{ __('السعر الإجمالي') }}</th>
                            <th class="py-3 px-4 font-bold text-xs uppercase">{{ __('المسؤول') }}</th>
                            <th class="py-3 px-4 font-bold text-xs uppercase">{{ __('طريقة الدفع') }}</th>
                            <th class="py-3 px-4 font-bold text-xs uppercase">{{ __('الدفعة الأولى / القسط') }}</th>
                            <th class="py-3 px-4 font-bold text-xs uppercase text-center">{{ __('الحالة') }}</th>
                            <th class="py-3 px-4 font-bold text-xs uppercase">{{ __('التاريخ') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($this->getDetailedBookings() as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $booking['client_name'] }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $booking['client_phone'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold">{{ $booking['car']['name'] ?? __('N/A') }}</div>
                                    <div class="text-xs text-gray-400">{{ $booking['car']['brand']['name'] ?? '' }}</div>
                                </td>
                                <td class="py-3 px-4 font-bold text-gray-900 dark:text-white">
                                    {{ number_format($booking['total_price'], 0) }} {{ __('SAR') }}
                                </td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                    {{ $booking['employee']['name'] ?? __('غير معين') }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-xs px-2 py-1 rounded bg-gray-100 dark:bg-gray-800 font-medium">
                                        {{ $booking['payment_method'] === 'cash' ? __('كاش') : __('تقسيط / تمويل') }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($booking['payment_method'] === 'finance' || $booking['down_payment'] > 0)
                                        <div class="text-xs text-gray-700 dark:text-gray-300">
                                            {{ __('مقدم:') }} {{ number_format($booking['down_payment'], 0) }} {{ __('SAR') }}
                                        </div>
                                        @if($booking['monthly_installment'] > 0)
                                            <div class="text-xs text-primary-600 dark:text-primary-400 font-bold">
                                                {{ __('قسط:') }} {{ number_format($booking['monthly_installment'], 0) }} {{ __('SAR') }} / {{ $booking['duration_years'] }} {{ __('سنة') }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">{{ __('سداد كامل المبلغ') }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @php 
                                        $statusConfig = \App\Models\Booking::STATUSES[$booking['status']] ?? ['label' => $booking['status'], 'color' => 'gray'];
                                        $badgeColorClass = match($statusConfig['color']) {
                                            'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                            'primary' => 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300',
                                            'info' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300',
                                            'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300',
                                            'danger' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-950 dark:text-gray-300',
                                        };
                                    @endphp
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $badgeColorClass }}">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($booking['created_at'])->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-400">
                                    {{ __('لا توجد حجوزات تطابق الفلاتر المحددة') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>

    @elseif($activeTab === 'employees')
        <!-- 3. EMPLOYEES TAB -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($this->getEmployeePerformance() as $emp)
                <div class="report-card p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-950 flex items-center justify-center text-primary-600 font-bold">
                                {{ mb_substr($emp['name'], 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $emp['name'] }}</h4>
                                <span class="text-xs text-gray-400">{{ $emp['email'] }}</span>
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4 py-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl px-4 mb-4">
                            <div>
                                <span class="text-xs text-gray-400 block">{{ __('إجمالي الحالات') }}</span>
                                <span class="text-lg font-bold">{{ $emp['total_bookings'] }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block text-emerald-600">{{ __('ناجحة (تم البيع)') }}</span>
                                <span class="text-lg font-bold text-emerald-600">{{ $emp['sold_bookings'] }}</span>
                            </div>
                        </div>

                        <!-- Conversion Progress -->
                        @php 
                            $rate = ($emp['total_bookings'] ?? 0) > 0 ? round(($emp['sold_bookings'] ?? 0) / $emp['total_bookings'] * 100) : 0;
                            $progressColor = $rate >= 50 ? 'bg-emerald-500' : ($rate >= 25 ? 'bg-yellow-500' : 'bg-red-500');
                        @endphp
                        <div class="mb-2">
                            <div class="flex justify-between text-xs font-semibold mb-1">
                                <span>{{ __('معدل نجاح إغلاق الصفقات') }}</span>
                                <span>{{ $rate }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-2">
                                <div class="progress-bar-fill {{ $progressColor }} h-2 rounded-full" style="width: {{ $rate }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full report-card p-8 text-center text-gray-400 rounded-2xl">
                    {{ __('لا يوجد موظفون في قاعدة البيانات حالياً') }}
                </div>
            @endforelse
        </div>

    @elseif($activeTab === 'sources')
        <!-- 4. SOURCES TAB -->
        <x-filament::section class="report-card">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-m-globe-alt" class="h-5 w-5 text-gray-500" />
                    <span>{{ __('توزيع العملاء والمهتمين حسب قنوات الاستقطاب') }}</span>
                </div>
            </x-slot>

            <div class="space-y-6 mt-6">
                @php
                    $sources = $this->getSourcePerformance();
                    $grandTotalLeads = collect($sources)->sum('total_leads');
                @endphp
                
                @forelse($sources as $source)
                    @php 
                        $percentage = $grandTotalLeads > 0 ? round(($source['total_leads'] / $grandTotalLeads) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-sm font-semibold mb-1">
                            <span class="text-gray-800 dark:text-gray-300">{{ $source['contact_source']['name'] ?? __('طلب حجز من المتجر') }}</span>
                            <span class="text-primary-600 dark:text-primary-400">{{ $source['total_leads'] }} {{ __('عميل') }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-3">
                            <div class="progress-bar-fill bg-primary-500 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-gray-400">
                        {{ __('لا توجد بيانات قنوات استقطاب مسجلة للفترة المحددة') }}
                    </div>
                @endforelse
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
