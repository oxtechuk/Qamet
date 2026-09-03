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

    protected static string|array|null $permission = 'view-cars-showcase';

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

        if ($this->selectedCarId) {
            $this->dispatch('scroll-to-detail');
        }
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
            ->with(['brand', 'category', 'specifications', 'features_list', 'safety_features', 'variants', 'images'])
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
        $carTitle = str_contains($car->name, (string) $car->year) ? $car->name : "{$car->name} {$car->year}";
        $lines[] = $carTitle;
        $lines[] = str_repeat('─', 24);

        if ($car->cash_price) {
            $lines[] = 'سعر الكاش: '.number_format($car->cash_price).' ريال';
        }

        if ($car->min_installment) {
            $lines[] = 'أقل قسط شهري: '.number_format($car->min_installment).' ريال/شهر';
        }

        if ($car->min_down_payment) {
            $lines[] = 'أقل دفعة أولى: '.number_format($car->min_down_payment).' ريال';
        }

        if ($car->specifications->isNotEmpty()) {
            $lines[] = '';
            $lines[] = 'المواصفات:';
            foreach ($car->specifications as $spec) {
                $lines[] = '- '.$spec->name.($spec->value ? ': '.$spec->value : '');
            }
        }

        if ($car->features_list->isNotEmpty()) {
            $lines[] = '';
            $lines[] = 'المميزات والتجهيزات:';
            foreach ($car->features_list as $feature) {
                $lines[] = '- '.$feature->name;
            }
        }

        if ($car->safety_features->isNotEmpty()) {
            $lines[] = '';
            $lines[] = 'أنظمة السلامة والأمان:';
            foreach ($car->safety_features as $sf) {
                $lines[] = '- '.$sf->name;
            }
        }

        if ($car->variants->isNotEmpty()) {
            $lines[] = '';
            $lines[] = 'الفروقات والفئات المتاحة:';
            foreach ($car->variants as $variant) {
                $lines[] = '- '.$variant->name;
                if ($variant->cash_price) {
                    $lines[] = '  سعر الكاش: '.number_format($variant->cash_price).' ريال';
                }
                if ($variant->min_installment) {
                    $lines[] = '  القسط: '.number_format($variant->min_installment).' ريال/شهر';
                }
            }
        }

        return implode("\n", $lines);
    }

    public function downloadImages(): void
    {
        $car = $this->getSelectedCar();
        if (! $car) {
            return;
        }

        $carName = preg_replace('/[^a-zA-Z0-9\-_\x{0600}-\x{06FF}]/u', '_', $car->name ?? 'car');
        $zipName = "car-{$car->id}-{$carName}.zip";
        $zipPath = storage_path('app/public/temp/'.$zipName);

        if (! is_dir(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return;
        }

        $filesAdded = 0;

        // 1. الصورة الرئيسية / صورة الواجهة
        if ($car->thumbnail) {
            if ($this->addImageToZip($zip, $car->thumbnail, 'الرئيسية/صورة_الواجهة.'.$this->getImageExtension($car->thumbnail))) {
                $filesAdded++;
            }
        }

        // 2. صور عامة إضافية للسيارة
        if ($car->relationLoaded('images') || $car->images()->exists()) {
            foreach ($car->images as $idx => $img) {
                $folder = $img->type === 'interior' ? 'صور_عامة_داخلية' : 'صور_عامة_خارجية';
                if ($this->addImageToZip($zip, $img->image_path, "{$folder}/صورة_".($idx + 1).'.'.$this->getImageExtension($img->image_path))) {
                    $filesAdded++;
                }
            }
        }

        // 3. الألوان الخارجية مجمعة حسب اسم اللون
        $exteriorColors = $car->exterior_colors ?? $car->colors ?? [];
        if (is_array($exteriorColors)) {
            foreach ($exteriorColors as $cIdx => $color) {
                $colorName = $this->sanitizeFileName($color['name'] ?? 'لون_خارجي_'.($cIdx + 1));
                $images = $color['images'] ?? (! empty($color['image']) ? [$color['image']] : []);
                foreach ((array) $images as $imgIdx => $img) {
                    if ($img && $this->addImageToZip($zip, $img, "الألوان_الخارجية/{$colorName}/صورة_".($imgIdx + 1).'.'.$this->getImageExtension($img))) {
                        $filesAdded++;
                    }
                }
            }
        }

        // 4. الألوان الداخلية مجمعة حسب اسم اللون
        $interiorColors = $car->interior_colors ?? [];
        if (is_array($interiorColors)) {
            foreach ($interiorColors as $cIdx => $color) {
                $colorName = $this->sanitizeFileName($color['name'] ?? 'لون_داخلي_'.($cIdx + 1));
                $images = $color['images'] ?? (! empty($color['image']) ? [$color['image']] : []);
                foreach ((array) $images as $imgIdx => $img) {
                    if ($img && $this->addImageToZip($zip, $img, "الألوان_الداخلية/{$colorName}/صورة_".($imgIdx + 1).'.'.$this->getImageExtension($img))) {
                        $filesAdded++;
                    }
                }
            }
        }

        // 5. الفروقات والإضافات / الفئات مجمعة حسب اسم الفئة
        if ($car->variants->isNotEmpty()) {
            foreach ($car->variants as $vIdx => $variant) {
                if ($variant->image) {
                    $variantName = $this->sanitizeFileName($variant->name ?? 'فئة_'.($vIdx + 1));
                    if ($this->addImageToZip($zip, $variant->image, "الفروقات_والفئات/{$variantName}/صورة.".$this->getImageExtension($variant->image))) {
                        $filesAdded++;
                    }
                }
            }
        }

        $zip->close();

        if ($filesAdded === 0) {
            $this->dispatch('toast-message', message: 'لا توجد صور متوفرة للتحميل لهذه السيارة');

            return;
        }

        $this->dispatch('download-file', url: Storage::disk('public')->url('temp/'.$zipName));
    }

    private function addImageToZip(\ZipArchive $zip, string $path, string $zipInternalPath): bool
    {
        // 1. Try public disk
        $cleanPath = preg_replace('#^https?://[^/]+/storage/#', '', $path);
        $cleanPath = ltrim(preg_replace('#^storage/#', '', $cleanPath), '/');

        $diskPath = Storage::disk('public')->path($cleanPath);
        if (file_exists($diskPath) && is_file($diskPath)) {
            return $zip->addFile($diskPath, $zipInternalPath);
        }

        // 2. Try raw filesystem path
        if (file_exists($path) && is_file($path)) {
            return $zip->addFile($path, $zipInternalPath);
        }

        // 3. Try HTTP URL if absolute URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            try {
                $context = stream_context_create([
                    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
                    'http' => ['timeout' => 8],
                ]);
                $content = @file_get_contents($path, false, $context);
                if ($content !== false && strlen($content) > 0) {
                    return $zip->addFromString($zipInternalPath, $content);
                }
            } catch (\Throwable) {
                // Skip if unreachable
            }
        }

        return false;
    }

    private function getImageExtension(string $path): string
    {
        $parsed = parse_url($path, PHP_URL_PATH);
        $ext = strtolower(pathinfo($parsed ?: $path, PATHINFO_EXTENSION));

        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']) ? $ext : 'webp';
    }

    private function sanitizeFileName(string $name): string
    {
        $clean = preg_replace('/[\\\\\/:\*\?"<>\|\s]+/u', '_', trim($name));

        return trim($clean, '_') ?: 'item';
    }
}
