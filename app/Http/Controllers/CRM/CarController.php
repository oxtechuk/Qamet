<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\Feature;
use App\Models\SafetyFeature;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'category'])->latest();

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")->orWhere('model', 'like', "%$s%");
            });
        }

        $cars = $query->paginate(8);
        $brands = Brand::where('is_active', true)->get();
        $categories = CarCategory::activeOrdered()->get();

        return view('crm.cars.index', compact('cars', 'brands', 'categories'));
    }

    public function create()
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = CarCategory::activeOrdered()->get();
        $specifications = Specification::all();
        $features_list = Feature::all();
        $safety_features = SafetyFeature::all();
        $carTypes = CarType::activeOrdered()->get();

        return view('crm.cars.create', compact('brands', 'categories', 'carTypes', 'specifications', 'features_list', 'safety_features'));
    }

    public function store(Request $request)
    {
        $this->normalizeCategoryId($request);

        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:car_categories,id',
            'name' => 'required|array',
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2030',
            'type' => 'required|exists:car_types,slug',
            'color' => 'nullable|string|max:100',
            'cash_price' => 'required|integer|min:0',
            'min_down_payment' => 'required|integer|min:0',
            'min_installment' => 'required|integer|min:0',
            'description' => 'nullable|array',
            'description.ar' => 'nullable|string',
            'description.en' => 'nullable|string',
            'features' => 'nullable|array',
            'features.ar' => 'nullable|string',
            'features.en' => 'nullable|string',
            'specs' => 'nullable|array',
            'thumbnail' => 'nullable|image|max:5120',
            'is_featured' => 'boolean',
            'is_highlighted' => 'nullable|string|max:255',
            'availability_status' => 'required|string|in:available,on_request,order_now',
            'interior_images.*' => 'nullable|image|max:5120',
            'exterior_images.*' => 'nullable|image|max:5120',
            'color_names' => 'nullable|array',
            'color_hexes' => 'nullable|array',
            'color_images' => 'nullable|array',
            'color_images.*' => 'nullable|image|max:5120',
        ]);

        // Build structured colors array
        $colors = [];
        $colorNames = $request->input('color_names', []);
        $colorHexes = $request->input('color_hexes', []);
        $colorFiles = $request->file('color_images', []);
        foreach ($colorNames as $i => $name) {
            if (empty($name) && empty($colorHexes[$i] ?? '')) {
                continue;
            }
            $entry = ['name' => $name, 'hex' => $colorHexes[$i] ?? '#000000', 'image' => null];
            if (! empty($colorFiles[$i])) {
                $entry['image'] = $colorFiles[$i]->store('cars/colors', 'public');
            }
            $colors[] = $entry;
        }
        $data['colors'] = $colors ?: null;

        $data['slug'] = [
            'en' => Car::generateUniqueSlug($data['name']['en'], $data['year'], 'en'),
            'ar' => Car::generateUniqueSlug($data['name']['ar'], $data['year'], 'ar'),
        ];
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_highlighted'] = $request->input('is_highlighted', 'none');
        $data['availability_status'] = $request->input('availability_status', 'available');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('cars/thumbnails', 'public');
        }

        $car = Car::create($data);

        // Sync Specifications and Features
        if ($request->has('specifications')) {
            $car->specifications()->sync($request->specifications);
        }
        if ($request->has('features_list')) {
            $car->features_list()->sync($request->features_list);
        }
        if ($request->has('safety_features')) {
            $car->safety_features()->sync($request->safety_features);
        }

        // Upload Interior Images
        if ($request->hasFile('interior_images')) {
            foreach ($request->file('interior_images') as $image) {
                $car->images()->create([
                    'image_path' => $image->store('cars/gallery', 'public'),
                    'type' => 'interior',
                ]);
            }
        }

        // Upload Exterior Images
        if ($request->hasFile('exterior_images')) {
            foreach ($request->file('exterior_images') as $image) {
                $car->images()->create([
                    'image_path' => $image->store('cars/gallery', 'public'),
                    'type' => 'exterior',
                ]);
            }
        }

        return redirect()->route('crm.cars.index')->with('success', 'تم تسجيل السيارة بنجاح');
    }

    public function edit(Car $car)
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = CarCategory::activeOrdered()->get();
        $specifications = Specification::all();
        $features_list = Feature::all();
        $safety_features = SafetyFeature::all();
        $carTypes = CarType::activeOrdered()->get();
        $car->load(['images', 'specifications', 'features_list', 'safety_features']);

        return view('crm.cars.edit', compact('car', 'brands', 'categories', 'carTypes', 'specifications', 'features_list', 'safety_features'));
    }

    public function update(Request $request, Car $car)
    {
        $this->normalizeCategoryId($request);

        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'nullable|exists:car_categories,id',
            'name' => 'required|array',
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2030',
            'type' => 'required|exists:car_types,slug',
            'color' => 'nullable|string|max:100',
            'cash_price' => 'required|integer|min:0',
            'min_down_payment' => 'required|integer|min:0',
            'min_installment' => 'required|integer|min:0',
            'description' => 'nullable|array',
            'description.ar' => 'nullable|string',
            'description.en' => 'nullable|string',
            'features' => 'nullable|array',
            'features.ar' => 'nullable|string',
            'features.en' => 'nullable|string',
            'specs' => 'nullable|array',
            'thumbnail' => 'nullable|image|max:5120',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'is_highlighted' => 'nullable|string|max:255',
            'availability_status' => 'required|string|in:available,on_request,order_now',
            'interior_images.*' => 'nullable|image|max:5120',
            'exterior_images.*' => 'nullable|image|max:5120',
            'color_names' => 'nullable|array',
            'color_hexes' => 'nullable|array',
            'color_images' => 'nullable|array',
            'color_images.*' => 'nullable|image|max:5120',
            'color_keep_images' => 'nullable|array',
        ]);

        // Build structured colors array (keep existing images if no new upload)
        $colors = [];
        $colorNames = $request->input('color_names', []);
        $colorHexes = $request->input('color_hexes', []);
        $colorFiles = $request->file('color_images', []);
        $keepImages = $request->input('color_keep_images', []);
        $existingColors = $car->colors ?? [];
        foreach ($colorNames as $i => $name) {
            if (empty($name) && empty($colorHexes[$i] ?? '')) {
                continue;
            }
            $entry = ['name' => $name, 'hex' => $colorHexes[$i] ?? '#000000', 'image' => $keepImages[$i] ?? null];
            if (! empty($colorFiles[$i])) {
                // Delete old image if exists
                if (! empty($keepImages[$i])) {
                    Storage::disk('public')->delete($keepImages[$i]);
                }
                $entry['image'] = $colorFiles[$i]->store('cars/colors', 'public');
            }
            $colors[] = $entry;
        }
        $data['colors'] = $colors ?: null;

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['is_highlighted'] = $request->input('is_highlighted', 'none');
        $data['availability_status'] = $request->input('availability_status', 'available');

        if ($request->hasFile('thumbnail')) {
            if ($car->thumbnail) {
                Storage::disk('public')->delete($car->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('cars/thumbnails', 'public');
        }

        $data['slug'] = [
            'en' => Car::generateUniqueSlug($data['name']['en'], $data['year'], 'en', $car->id),
            'ar' => Car::generateUniqueSlug($data['name']['ar'], $data['year'], 'ar', $car->id),
        ];

        $car->update($data);

        // Sync Specifications and Features
        if ($request->has('specifications')) {
            $car->specifications()->sync($request->specifications);
        } else {
            $car->specifications()->detach();
        }

        if ($request->has('features_list')) {
            $car->features_list()->sync($request->features_list);
        } else {
            $car->features_list()->detach();
        }

        if ($request->has('safety_features')) {
            $car->safety_features()->sync($request->safety_features);
        } else {
            $car->safety_features()->detach();
        }

        // Upload Interior Images
        if ($request->hasFile('interior_images')) {
            foreach ($request->file('interior_images') as $image) {
                $car->images()->create([
                    'image_path' => $image->store('cars/gallery', 'public'),
                    'type' => 'interior',
                ]);
            }
        }

        // Upload Exterior Images
        if ($request->hasFile('exterior_images')) {
            foreach ($request->file('exterior_images') as $image) {
                $car->images()->create([
                    'image_path' => $image->store('cars/gallery', 'public'),
                    'type' => 'exterior',
                ]);
            }
        }

        return redirect()->route('crm.cars.index')->with('success', 'تم تحديث بيانات السيارة');
    }

    public function destroy(Car $car)
    {
        if ($car->thumbnail) {
            Storage::disk('public')->delete($car->thumbnail);
        }
        foreach ($car->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $car->delete();

        return redirect()->route('crm.cars.index')->with('success', 'تم حذف السيارة');
    }

    public function deleteImage(CarImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'تم حذف الصورة');
    }

    private function normalizeCategoryId(Request $request): void
    {
        if ($request->input('category_id') === '' || $request->input('category_id') === null) {
            $request->merge(['category_id' => null]);
        }
    }
}
