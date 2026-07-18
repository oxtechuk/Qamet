<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index()
    {
        $enFile = base_path('lang/en.json');
        $arFile = base_path('lang/ar.json');

        $enData = [];
        if (file_exists($enFile)) {
            $enData = json_decode(file_get_contents($enFile), true) ?: [];
        }

        $arData = [];
        if (file_exists($arFile)) {
            $arData = json_decode(file_get_contents($arFile), true) ?: [];
        }

        $allKeys = array_unique(array_merge(array_keys($enData), array_keys($arData)));
        sort($allKeys); // Optional: sort keys alphabetically

        return view('crm.translations.index', compact('enData', 'arData', 'allKeys'));
    }

    public function update(Request $request)
    {
        $keys = $request->keys ?? [];
        $enValues = $request->en_values ?? [];
        $arValues = $request->ar_values ?? [];

        if (count($keys) !== count($enValues) || count($keys) !== count($arValues)) {
            return redirect()->back()->with('error', 'Warning: Data limit reached! Please increase "max_input_vars" in php.ini.');
        }

        $newEn = [];
        $newAr = [];

        foreach ($keys as $index => $key) {
            $n = trim($key);
            if (! empty($n)) {
                $newEn[$n] = $enValues[$index] ?? '';
                $newAr[$n] = $arValues[$index] ?? '';
            }
        }

        $enFile = base_path('lang/en.json');
        $arFile = base_path('lang/ar.json');

        file_put_contents($enFile, json_encode($newEn, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents($arFile, json_encode($newAr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'تم حفظ التحديثات بنجاح!');
    }
}
