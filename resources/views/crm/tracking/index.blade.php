@extends('partials.Layouts.crm-master')
@section('title', __('تتبع الحالات') . ' | AutoCRM')

@section('css')
<style>
    .kanban-board { 
        display: grid; 
        grid-template-columns: repeat(5, 1fr); 
        gap: 20px; 
        align-items: start; 
        padding-bottom: 20px;
    }
    .kanban-col { 
        background: #f8f9fa; 
        border-radius: 20px; 
        min-height: 80vh; 
        display: flex; 
        flex-direction: column;
        border: 1px solid #edf2f7;
    }
    .kanban-col-header { 
        padding: 20px; 
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        border-bottom: 1px solid #edf2f7;
    }
    .kanban-col-title { 
        font-weight: 800; 
        font-size: 15px; 
        color: #2d3748; 
    }
    .kanban-col-count { 
        background: #fff; 
        border-radius: 10px; 
        font-size: 12px; 
        font-weight: 800; 
        color: #4a5568; 
        padding: 4px 12px; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .kanban-col-body { 
        padding: 15px; 
        display: flex; 
        flex-direction: column; 
        gap: 12px; 
        flex-grow: 1;
    }
    .kanban-card { 
        background: #fff; 
        border-radius: 15px; 
        padding: 18px; 
        border: 1px solid #edf2f7; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        cursor: pointer; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .kanban-card:hover { 
        box-shadow: 0 10px 20px rgba(0,0,0,0.06); 
        transform: translateY(-5px); 
        border-color: var(--crm-red);
    }
    .kanban-card-id { 
        font-size: 11px; 
        font-weight: 800; 
        color: #a0aec0; 
        margin-bottom: 8px; 
        display: block;
    }
    .kanban-card-name { 
        font-size: 15px; 
        font-weight: 800; 
        color: #1a202c; 
        margin-bottom: 6px; 
    }
    .kanban-card-car {
        font-size: 13px;
        color: #718096;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .kanban-card-footer { 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        margin-top: 15px;
        padding-top: 12px;
        border-top: 1px dashed #edf2f7;
    }
    .kanban-card-time { 
        font-size: 11px; 
        color: #a0aec0;
        font-weight: 600;
    }
    .kanban-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .kanban-note-badge {
        font-size: 10px;
        font-weight: 800;
        background: #f1f5f9;
        color: #64748b;
        padding: 2px 8px;
        border-radius: 6px;
    }
    .kanban-avatar { 
        width: 28px; 
        height: 28px; 
        border-radius: 10px; 
        background: var(--crm-red); 
        color: #fff; 
        font-size: 11px; 
        font-weight: 800; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border: 2px solid #fff; 
    }
    
    @media (max-width: 1200px) { .kanban-board { grid-template-columns: repeat(3, 1fr); } }

    /* Mobile: horizontal scroll with snap */
    @media (max-width: 768px) {
        .kanban-board {
            display: flex;
            flex-direction: row;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            gap: 14px;
            padding-bottom: 16px;
            padding-right: 4px;
            padding-left: 4px;
        }
        .kanban-board::-webkit-scrollbar { height: 4px; }
        .kanban-board::-webkit-scrollbar-thumb { background: var(--crm-border); border-radius: 4px; }

        .kanban-col {
            flex: 0 0 calc(100vw - 60px);
            scroll-snap-align: start;
            min-height: 60vh;
        }

        /* Mobile scroll hint strip */
        .kanban-scroll-hint {
            display: flex !important;
        }
    }

    /* Scroll hint (hidden on desktop) */
    .kanban-scroll-hint {
        display: none;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--crm-text-muted);
        font-weight: 600;
        margin-bottom: 12px;
        padding: 8px 12px;
        background: #F8F9FC;
        border-radius: 10px;
        border: 1px solid var(--crm-border);
    }

</style>
@endsection

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="mb-4">
        <h4 class="mb-1 fw-bold">{{ __('تتبع مسار العمل') }}</h4>
        <p class="text-muted mb-0 small">{{ __('متابعة حالة الطلبات من الاستلام حتى التنفيذ النهائي') }}</p>
    </div>

    {{-- Mobile scroll hint (only visible on mobile) --}}
    <div class="kanban-scroll-hint">
        <i class="bi bi-arrow-left-right"></i>
        {{ __('اسحب يميناً أو يساراً للتنقل بين الحالات') }}
    </div>

    <div class="kanban-board">
        @foreach($columns as $key => $col)
        <div class="kanban-col">
            <div class="kanban-col-header" style="border-top: 4px solid {{ $col['color'] }}">
                <span class="kanban-col-title">{{ __($col['label']) }}</span>
                <span class="kanban-col-count">{{ $col['count'] }}</span>
            </div>
            <div class="kanban-col-body">
                @forelse($col['items'] as $booking)
                <a href="{{ route('crm.bookings.show', $booking) }}" class="text-decoration-none">
                    <div class="kanban-card">
                        <span class="kanban-card-id">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <div class="kanban-card-name">{{ $booking->client_name }}</div>
                        <div class="kanban-card-car text-truncate">
                            <i class="bi bi-car-front"></i>
                            {{ $booking->car?->brand?->name }} {{ $booking->car?->name }}
                        </div>
                        
                        <div class="kanban-card-footer">
                            <div class="kanban-card-meta">
                                <span class="kanban-card-time">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $booking->created_at->diffForHumans() }}
                                </span>
                                @if($booking->notes_list_count > 0)
                                <span class="kanban-note-badge">
                                    <i class="bi bi-chat-left-text me-1"></i>
                                    {{ $booking->notes_list_count }}
                                </span>
                                @endif
                            </div>
                            
                            @if($booking->assignedTo)
                            <div class="kanban-avatar" title="{{ $booking->assignedTo->name }}">
                                {{ strtoupper(substr($booking->assignedTo->name, 0, 1)) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-5 opacity-25">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    <span class="x-small fw-bold">{{ __('فارغ') }}</span>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
