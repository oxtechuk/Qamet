<x-filament-panels::page>
    {{ $this->content }}

    @assets
    <script>
        document.addEventListener('livewire:initialized', function () {
            Livewire.on('settings-saved', function () {
                $filament.notify('success', '{{ __('Settings saved successfully!') }}');
            });
        });
    </script>
    @endassets
</x-filament-panels::page>
