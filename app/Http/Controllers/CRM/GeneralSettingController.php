<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $cars = \App\Models\Car::select('id', 'name')->where('is_active', true)->orderBy('name')->get();
        $offers = \App\Models\Offer::active()->select('id', 'title')->orderBy('title')->get();

        $bentoCars = $settings['bento_cars'] ?? [];
        if (! is_array($bentoCars) && is_string($bentoCars)) {
            $bentoCars = json_decode($bentoCars, true) ?: [];
        }

        $socialMedia = $settings['social_media'] ?? [];
        if (! is_array($socialMedia) && is_string($socialMedia)) {
            $socialMedia = json_decode($socialMedia, true) ?: [];
        }

        $homepageStats = $settings['homepage_stats'] ?? [];
        if (! is_array($homepageStats) && is_string($homepageStats)) {
            $homepageStats = json_decode($homepageStats, true) ?: [];
        }

        $homepageSections = $settings['homepage_sections'] ?? [];
        if (! is_array($homepageSections) && is_string($homepageSections)) {
            $homepageSections = json_decode($homepageSections, true) ?: [];
        }

        $aboutSections = $settings['about_sections'] ?? [];
        if (! is_array($aboutSections) && is_string($aboutSections)) {
            $aboutSections = json_decode($aboutSections, true) ?: [];
        }

        $aboutStats = $settings['about_stats'] ?? [];
        if (! is_array($aboutStats) && is_string($aboutStats)) {
            $aboutStats = json_decode($aboutStats, true) ?: [];
        }

        $aboutBranches = $settings['about_branches'] ?? [];
        if (! is_array($aboutBranches) && is_string($aboutBranches)) {
            $aboutBranches = json_decode($aboutBranches, true) ?: [];
        }

        $financeStats = $settings['finance_stats'] ?? [];
        if (! is_array($financeStats) && is_string($financeStats)) {
            $financeStats = json_decode($financeStats, true) ?: [];
        }

        $bookingHeroRaw = $settings['store_booking_hero'] ?? [];
        $bookingHero = is_array($bookingHeroRaw) ? $bookingHeroRaw : (json_decode((string) $bookingHeroRaw, true) ?: []);

        $bookingStepsRaw = $settings['store_booking_steps'] ?? [];
        $bookingSteps = is_array($bookingStepsRaw) ? $bookingStepsRaw : (json_decode((string) $bookingStepsRaw, true) ?: []);

        $bookingSectionsRaw = $settings['store_booking_sections'] ?? [];
        $bookingSections = is_array($bookingSectionsRaw) ? $bookingSectionsRaw : (json_decode((string) $bookingSectionsRaw, true) ?: []);

        $homeHeroRaw = $settings['store_home_hero'] ?? [];
        $homeHero = is_array($homeHeroRaw) ? $homeHeroRaw : (json_decode((string) $homeHeroRaw, true) ?: []);

        $carsHeroRaw = $settings['store_hero'] ?? [];
        $carsHero = is_array($carsHeroRaw) ? $carsHeroRaw : (json_decode((string) $carsHeroRaw, true) ?: []);

        $offersHeroRaw = $settings['store_offers_hero'] ?? [];
        $offersHero = is_array($offersHeroRaw) ? $offersHeroRaw : (json_decode((string) $offersHeroRaw, true) ?: []);

        return view('crm.settings.general', compact('settings', 'cars', 'offers', 'bentoCars', 'socialMedia', 'homepageStats', 'homepageSections', 'aboutSections', 'aboutStats', 'aboutBranches', 'bookingHero', 'bookingSteps', 'bookingSections', 'homeHero', 'carsHero', 'offersHero', 'financeStats'));
    }

    public function seo()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('crm.settings.seo', compact('settings'));
    }

    public function integrations()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('crm.settings.integrations', compact('settings'));
    }

    public function maintenance()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('crm.settings.maintenance', compact('settings'));
    }

    public function update(Request $request)
    {
        // Whitelist of settings to update
        $keys = [
            'site_name', 'footer_text', 'contact_email', 'contact_phone',
            'contact_whatsapp', 'contact_address', 'bento_cars',
            'hero_ad_1_link', 'hero_ad_2_link', 'auto_assign_bookings',
            'page_loader_enabled',
            'twilio_sid', 'twilio_auth_token', 'twilio_whatsapp_number', 'twilio_sms_number',
            'whatsapp_template_new_lead', 'whatsapp_template_status_update',
            'google_analytics_id', 'meta_pixel_id',
            'homepage_featured',
            'homepage_sections',
            'about_sections',
            'store_booking_sections',
            'maintenance_enabled', 'maintenance_title', 'maintenance_message', 'maintenance_allowed_ips',
        ];

        // Update text/array settings
        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->get($key)]);
            } elseif (in_array($key, ['twilio_sid', 'twilio_auth_token', 'twilio_whatsapp_number', 'twilio_sms_number', 'whatsapp_template_new_lead', 'whatsapp_template_status_update'])) {
                // Allow empty values for these keys
                Setting::updateOrCreate(['key' => $key], ['value' => $request->get($key, '')]);
            }
        }

        // Checkbox unchecked case
        if (! $request->has('page_loader_enabled')) {
            Setting::updateOrCreate(['key' => 'page_loader_enabled'], ['value' => '0']);
        }
        if (! $request->has('maintenance_enabled')) {
            Setting::updateOrCreate(['key' => 'maintenance_enabled'], ['value' => '0']);
        }

        // Handle maintenance_image removal
        if ($request->has('remove_maintenance_image') && $request->remove_maintenance_image) {
            $existing = Setting::where('key', 'maintenance_image')->first();
            if ($existing && ! empty($existing->value)) {
                $path = $existing->value;
                if (\Storage::disk('public')->exists($path)) {
                    \Storage::disk('public')->delete($path);
                }
                Setting::where('key', 'maintenance_image')->delete();
            }
        }

        // Handle Social Media Array
        $socialIcons = $request->input('social_icon', []);
        $socialLinks = $request->input('social_link', []);
        $socialColors = $request->input('social_color', []);
        $socialMedia = [];
        foreach ($socialIcons as $index => $icon) {
            if (! empty($icon) && ! empty($socialLinks[$index])) {
                $socialMedia[] = [
                    'icon' => $icon,
                    'link' => $socialLinks[$index],
                    'color' => $socialColors[$index] ?? '#333333',
                ];
            }
        }
        Setting::updateOrCreate(['key' => 'social_media'], ['value' => $socialMedia]);

        // Handle Homepage Stats Array
        $statValues = $request->input('stat_value', []);
        $statLabels = $request->input('stat_label', []);
        $homepageStats = [];
        foreach ($statValues as $index => $value) {
            if (! empty($value)) {
                $homepageStats[] = [
                    'value' => $value,
                    'label' => $statLabels[$index] ?? '',
                ];
            }
        }
        Setting::updateOrCreate(['key' => 'homepage_stats'], ['value' => $homepageStats]);

        // Handle About Stats Array
        $aboutStatValues = $request->input('about_stat_value', []);
        $aboutStatLabels = $request->input('about_stat_label', []);
        $aboutStats = [];
        foreach ($aboutStatValues as $index => $value) {
            if (! empty($value)) {
                $aboutStats[] = [
                    'value' => $value,
                    'label' => $aboutStatLabels[$index] ?? '',
                ];
            }
        }
        Setting::updateOrCreate(['key' => 'about_stats'], ['value' => $aboutStats]);

        // Handle Finance Stats Array
        $financeStatValues = $request->input('finance_stat_value', []);
        $financeStatLabels = $request->input('finance_stat_label', []);
        $financeStats = [];
        foreach ($financeStatValues as $index => $value) {
            if (! empty($value)) {
                $financeStats[] = [
                    'value' => $value,
                    'label' => $financeStatLabels[$index] ?? '',
                ];
            }
        }
        Setting::updateOrCreate(['key' => 'finance_stats'], ['value' => $financeStats]);

        // Handle About Branches Array
        $branchCities = $request->input('branch_city', []);
        $branchNames = $request->input('branch_name', []);
        $branchAddresses = $request->input('branch_address', []);
        $branchPhones = $request->input('branch_phone', []);
        $branchHours = $request->input('branch_hours', []);
        $branchMapLinks = $request->input('branch_map_link', []);
        $aboutBranches = [];
        foreach ($branchCities as $index => $city) {
            if (! empty($city)) {
                $aboutBranches[] = [
                    'city' => $city,
                    'name' => $branchNames[$index] ?? '',
                    'address' => $branchAddresses[$index] ?? '',
                    'phone' => $branchPhones[$index] ?? '',
                    'working_hours' => $branchHours[$index] ?? '',
                    'map_link' => $branchMapLinks[$index] ?? '',
                ];
            }
        }
        Setting::updateOrCreate(['key' => 'about_branches'], ['value' => $aboutBranches]);

        // Handle File Uploads (Only if new files are uploaded)
        $files = ['site_logo', 'site_logo_color', 'site_favicon', 'breadcrumb_bg', 'hero_video', 'hero_ad_1_image', 'hero_ad_2_image', 'page_loader_image', 'maintenance_image'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('settings', 'public');
                Setting::updateOrCreate(['key' => $fileKey], ['value' => $path]);
            }
        }

        // Handle Hero Slides (Carousel Slider Banners)
        if ($request->has('hero_slides_submitted')) {
            $existingSlidesSetting = Setting::where('key', 'hero_slides')->first();
            $existingSlides = [];
            if ($existingSlidesSetting && ! empty($existingSlidesSetting->value)) {
                $existingSlides = is_array($existingSlidesSetting->value) ? $existingSlidesSetting->value : (json_decode($existingSlidesSetting->value, true) ?: []);
            }

            $newSlides = [];
            $slidesData = $request->input('hero_slides', []);

            foreach ($slidesData as $index => $slide) {
                $imagePath = $slide['image_path'] ?? null;

                // Check if a new file is uploaded for this slide
                if ($request->hasFile("hero_slides.{$index}.image")) {
                    $path = $request->file("hero_slides.{$index}.image")->store('settings/hero', 'public');
                    // Delete old image if exists
                    if ($imagePath && \Storage::disk('public')->exists($imagePath)) {
                        \Storage::disk('public')->delete($imagePath);
                    }
                    $imagePath = $path;
                }

                // If we have an image path (either new or existing), we add the slide
                if ($imagePath) {
                    $newSlides[] = [
                        'image' => $imagePath,
                        'link' => $slide['link'] ?? '',
                        'button_text' => $slide['button_text'] ?? __('اكتشف السيارات'),
                        'link_2' => $slide['link_2'] ?? '',
                        'button_2_text' => $slide['button_2_text'] ?? '',
                    ];
                }
            }

            // Clean up deleted slides (files that are on disk but not in the new slides)
            $newPaths = array_column($newSlides, 'image');
            foreach ($existingSlides as $oldSlide) {
                $oldPath = $oldSlide['image'] ?? null;
                if ($oldPath && ! in_array($oldPath, $newPaths)) {
                    if (\Storage::disk('public')->exists($oldPath)) {
                        \Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            Setting::updateOrCreate(['key' => 'hero_slides'], ['value' => $newSlides]);
        }

        // Handle Promo Popup
        $existingPopup = Setting::where('key', 'promo_popup')->first();
        $existingPopupValue = [];
        if ($existingPopup && ! empty($existingPopup->value)) {
            $existingPopupValue = is_array($existingPopup->value) ? $existingPopup->value : (json_decode($existingPopup->value, true) ?: []);
        }

        $popupImage = $existingPopupValue['image'] ?? null;
        if ($request->hasFile('popup_image')) {
            $popupImage = $request->file('popup_image')->store('settings/popup', 'public');
            if (! empty($existingPopupValue['image']) && \Storage::disk('public')->exists($existingPopupValue['image'])) {
                \Storage::disk('public')->delete($existingPopupValue['image']);
            }
        }

        $popupData = [
            'enabled' => $request->boolean('popup_enabled', false),
            'image' => $popupImage,
            'title' => $request->input('popup_title', ''),
            'text' => $request->input('popup_text', ''),
            'link' => $request->input('popup_link', ''),
            'button_text' => $request->input('popup_button_text', __('تصفح العروض')),
        ];
        Setting::updateOrCreate(['key' => 'promo_popup'], ['value' => $popupData]);

        // Handle Main Gallery (Multiple Images)
        if ($request->hasFile('main_gallery')) {
            $existingGallery = Setting::where('key', 'main_gallery')->first();
            $galleryPaths = [];
            if ($existingGallery && ! empty($existingGallery->value)) {
                $galleryPaths = is_array($existingGallery->value) ? $existingGallery->value : (json_decode($existingGallery->value, true) ?: []);
            }

            foreach ($request->file('main_gallery') as $image) {
                $path = $image->store('settings/gallery', 'public');
                $galleryPaths[] = $path;
            }
            Setting::updateOrCreate(['key' => 'main_gallery'], ['value' => $galleryPaths]);
        }

        // Handle Gallery Image Deletion
        if ($request->has('delete_gallery_image')) {
            $imageToDelete = $request->get('delete_gallery_image');
            $existingGallery = Setting::where('key', 'main_gallery')->first();
            if ($existingGallery && ! empty($existingGallery->value)) {
                $galleryPaths = is_array($existingGallery->value) ? $existingGallery->value : (json_decode($existingGallery->value, true) ?: []);
                $galleryPaths = array_values(array_filter($galleryPaths, function ($path) use ($imageToDelete) {
                    return $path !== $imageToDelete;
                }));
                Setting::updateOrCreate(['key' => 'main_gallery'], ['value' => $galleryPaths]);

                // Optionally delete the physical file
                if (\Storage::disk('public')->exists($imageToDelete)) {
                    \Storage::disk('public')->delete($imageToDelete);
                }
            }
        }

        // Handle Booking Hero
        $bookingHeroData = $request->input('store_booking_hero', []);
        if ($request->hasFile('booking_hero_image')) {
            $existingHero = Setting::where('key', 'store_booking_hero')->first();
            $oldImage = is_array($existingHero?->value) ? ($existingHero->value['image'] ?? null) : null;
            if ($oldImage && \Storage::disk('public')->exists($oldImage)) {
                \Storage::disk('public')->delete($oldImage);
            }
            $bookingHeroData['image'] = $request->file('booking_hero_image')->store('settings/booking', 'public');
        } elseif (! isset($bookingHeroData['image'])) {
            $existingHero = Setting::where('key', 'store_booking_hero')->first();
            $bookingHeroData['image'] = is_array($existingHero?->value) ? ($existingHero->value['image'] ?? null) : null;
        }
        Setting::updateOrCreate(['key' => 'store_booking_hero'], ['value' => $bookingHeroData]);

        // Handle Home Page Hero
        $homeHeroData = $request->input('store_home_hero', []);
        if ($request->hasFile('home_hero_image')) {
            $existingHomeHero = Setting::where('key', 'store_home_hero')->first();
            $oldHomeHeroImage = is_array($existingHomeHero?->value) ? ($existingHomeHero->value['image'] ?? null) : null;
            if ($oldHomeHeroImage && \Storage::disk('public')->exists($oldHomeHeroImage)) {
                \Storage::disk('public')->delete($oldHomeHeroImage);
            }
            $homeHeroData['image'] = $request->file('home_hero_image')->store('settings/home', 'public');
        } elseif (! isset($homeHeroData['image'])) {
            $existingHomeHero = Setting::where('key', 'store_home_hero')->first();
            $homeHeroData['image'] = is_array($existingHomeHero?->value) ? ($existingHomeHero->value['image'] ?? null) : null;
        }
        Setting::updateOrCreate(['key' => 'store_home_hero'], ['value' => $homeHeroData]);

        // Handle All Cars Page Hero
        $carsHeroData = $request->input('store_hero', []);
        if ($request->hasFile('cars_hero_image')) {
            $existingCarsHero = Setting::where('key', 'store_hero')->first();
            $oldCarsHeroImage = is_array($existingCarsHero?->value) ? ($existingCarsHero->value['image'] ?? null) : null;
            if ($oldCarsHeroImage && \Storage::disk('public')->exists($oldCarsHeroImage)) {
                \Storage::disk('public')->delete($oldCarsHeroImage);
            }
            $carsHeroData['image'] = $request->file('cars_hero_image')->store('settings/cars', 'public');
        } elseif (! isset($carsHeroData['image'])) {
            $existingCarsHero = Setting::where('key', 'store_hero')->first();
            $carsHeroData['image'] = is_array($existingCarsHero?->value) ? ($existingCarsHero->value['image'] ?? null) : null;
        }
        Setting::updateOrCreate(['key' => 'store_hero'], ['value' => $carsHeroData]);

        // Handle Offers Page Hero
        $offersHeroData = $request->input('store_offers_hero', []);
        if ($request->hasFile('offers_hero_image')) {
            $existingOffersHero = Setting::where('key', 'store_offers_hero')->first();
            $oldOffersHeroImage = is_array($existingOffersHero?->value) ? ($existingOffersHero->value['image'] ?? null) : null;
            if ($oldOffersHeroImage && \Storage::disk('public')->exists($oldOffersHeroImage)) {
                \Storage::disk('public')->delete($oldOffersHeroImage);
            }
            $offersHeroData['image'] = $request->file('offers_hero_image')->store('settings/offers', 'public');
        } elseif (! isset($offersHeroData['image'])) {
            $existingOffersHero = Setting::where('key', 'store_offers_hero')->first();
            $offersHeroData['image'] = is_array($existingOffersHero?->value) ? ($existingOffersHero->value['image'] ?? null) : null;
        }
        Setting::updateOrCreate(['key' => 'store_offers_hero'], ['value' => $offersHeroData]);

        // Handle Booking Steps
        $stepIcons = $request->input('booking_step_icon', []);
        $stepTitlesAr = $request->input('booking_step_title_ar', []);
        $stepTitlesEn = $request->input('booking_step_title_en', []);
        $stepDescsAr = $request->input('booking_step_desc_ar', []);
        $stepDescsEn = $request->input('booking_step_desc_en', []);
        $bookingSteps = [];
        foreach ($stepIcons as $idx => $icon) {
            if (! empty($icon) || ! empty($stepTitlesAr[$idx])) {
                $bookingSteps[] = [
                    'icon' => $icon,
                    'title' => ['ar' => $stepTitlesAr[$idx] ?? '', 'en' => $stepTitlesEn[$idx] ?? ''],
                    'description' => ['ar' => $stepDescsAr[$idx] ?? '', 'en' => $stepDescsEn[$idx] ?? ''],
                ];
            }
        }
        Setting::updateOrCreate(['key' => 'store_booking_steps'], ['value' => $bookingSteps]);

        // Invalidate hero-related cache
        Cache::forget('settings.hero.store_booking_hero');
        Cache::forget('settings.hero.store_home_hero');
        Cache::forget('settings.hero.store_hero');
        Cache::forget('settings.hero.store_offers_hero');

        return back()->with('success', __('تم تحديث الإعدادات بنجاح'));
    }
}
