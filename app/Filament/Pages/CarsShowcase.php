<?php

namespace App\Filament\Pages;

use App\Models\Car;
use App\Models\CarCategory;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;

class CarsShowcase extends Page
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-cars';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 0;

    protected static ?string $slug = 'cars-showcase';

    protected string $view = 'filament.pages.cars-showcase';

    public static function getNavigationGroup(): ?string
    {
        return 'الكتالوج';
    }

    public static function getNavigationLabel(): string
    {
        return 'عرض السيارات';
    }

    public function getTitle(): string
    {
        return 'عرض السيارات';
    }

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'category')]
    public ?int $selectedCategory = null;

    public ?int $selectedCarId = null;

    public function updatedSearch(): void
    {
        $this->selectedCarId = null;
    }

    public function updatedSelectedCategory(): void
    {
        $this->selectedCarId = null;
    }

    public function selectCategory(?int $categoryId): void
    {
        $this->selectedCategory = $categoryId;
        $this->selectedCarId = null;
    }

    public function selectCar(int $id): void
    {
        $this->selectedCarId = ($this->selectedCarId === $id) ? null : $id;
    }

    public function getCategories(): Collection
    {
        return CarCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function getCars(): Collection
    {
        return Car::query()
            ->with(['brand', 'category', 'variants'])
            ->where('is_active', true)
            ->when(
                $this->selectedCategory,
                fn ($q) => $q->where('category_id', $this->selectedCategory)
            )
            ->when(
                filled($this->search),
                fn ($q) => $q->where(function ($q) {
                    $term = '%'.$this->search.'%';
                    $q->where('name->ar', 'like', $term)
                        ->orWhere('name->en', 'like', $term)
                        ->orWhere('model', 'like', $term);
                })
            )
            ->orderByDesc('created_at')
            ->get();
    }

    public function getSelectedCar(): ?Car
    {
        if (! $this->selectedCarId) {
            return null;
        }

        return Car::query()
            ->with(['brand', 'category', 'specifications', 'features_list', 'safety_features', 'variants'])
            ->find($this->selectedCarId);
    }

    public function copySpecs(): void
    {
        $car = $this->getSelectedCar();
        if (! $car) {
            return;
        }

        $text = $this->buildSpecsText($car);

        $this->dispatch('copy-to-clipboard', text: $text);
    }

    public function buildSpecsText(Car $car): string
    {
        $lines = [];
        $lines[] = '🚗 '.$car->name.' '.($car->year ?? '');
        $lines[] = '';

        if ($car->cash_price) {
            $lines[] = '💰 سعر الكاش: '.number_format($car->cash_price).' ريال';
        }

        if ($car->min_installment) {
            $lines[] = '📅 أقل قسط شهري: '.number_format($car->min_installment).' ريال/شهر';
        }

        if ($car->min_down_payment) {
            $lines[] = '🏦 أقل دفعة أولى: '.number_format($car->min_down_payment).' ريال';
        }

        if ($car->specifications->isNotEmpty()) {
            $lines[] = '';
            $lines[] = '📋 المواصفات:';
            foreach ($car->specifications as $spec) {
                $lines[] = '• '.$spec->name.($spec->value ? ': '.$spec->value : '');
            }
        }

        if ($car->features_list->isNotEmpty()) {
            $lines[] = '';
            $lines[] = '✨ المميزات:';
            foreach ($car->features_list as $feature) {
                $lines[] = '• '.$feature->name;
            }
        }

        if ($car->variants->isNotEmpty()) {
            $lines[] = '';
            $lines[] = '🔧 الفروقات والإضافات المتاحة:';
            foreach ($car->variants as $variant) {
                $lines[] = '• '.$variant->name;
                if ($variant->cash_price) {
                    $lines[] = '  - سعر الكاش: '.number_format($variant->cash_price).' ريال';
                }
            }
        }

        return implode("\n", $lines);
    }

    public function getAllImagesForDownload(): array
    {
        $car = $this->getSelectedCar();
        if (! $car) {
            return [];
        }

        $paths = [];

        if ($car->thumbnail) {
            $paths[] = $car->thumbnail;
        }

        $exteriorColors = $car->exterior_colors ?? $car->colors ?? [];
        foreach ($exteriorColors as $color) {
            foreach ($color['images'] ?? [] as $img) {
                if ($img) {
                    $paths[] = $img;
                }
            }
        }

        foreach ($car->interior_colors ?? [] as $color) {
            foreach ($color['images'] ?? [] as $img) {
                if ($img) {
                    $paths[] = $img;
                }
            }
        }

        foreach ($car->variants as $variant) {
            if ($variant->image) {
                $paths[] = $variant->image;
            }
        }

        return array_unique(array_filter($paths));
    }

    public function downloadImages(): void
    {
        $car = $this->getSelectedCar();
        if (! $car) {
            return;
        }

        $imagePaths = $this->getAllImagesForDownload();

        if (empty($imagePaths)) {
            $this->dispatch('notify', ['type' => 'warning', 'message' => 'لا توجد صور لتحميلها']);

            return;
        }

        $carName = preg_replace('/[^a-zA-Z0-9\-_\x{0600}-\x{06FF}]/u', '_', $car->name ?? 'car');
        $zipName = "car-{$car->id}-{$carName}.zip";
        $zipPath = storage_path('app/public/temp/'.$zipName);

        if (! is_dir(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive;
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($imagePaths as $path) {
            $absPath = Storage::disk('public')->path($path);
            if (file_exists($absPath)) {
                $zip->addFile($absPath, basename($path));
            }
        }

        $zip->close();

        $this->dispatch('download-file', url: Storage::disk('public')->url('temp/'.$zipName));
    }
}
