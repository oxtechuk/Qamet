<x-filament-panels::page>
    <x-filament-widgets::widgets
        :columns="[
            'xl' => 4,
            'lg' => 3,
            'md' => 2,
            'sm' => 1,
        ]"
        :widgets="$this->getWidgets()"
    />
</x-filament-panels::page>
