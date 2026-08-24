import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { formatPrice } from "./format";
import type { CarCardProps } from "../components/CarCard";
import type { CarItem } from "../types/home.types";
import type { CarDetails } from "../types/cars.types";
import type { ITab, ISpecItem, IFeatureItem } from "../interfaces/ICarDetailsSpecsProps";

const SPEC_KEY_MAP: Record<string, string> = {
    "Fuel Type": "fuel",
    Transmission: "gearbox",
    seats: "seats",
};

export function getSpecValue(
    specs: CarItem["specs"],
    label: string,
): string {
    if (Array.isArray(specs)) {
        const spec = specs.find((s) => "label" in s && s.label === label);
        const v = spec?.value;
        return v != null && typeof v === "string" ? v : "";
    }
    if (specs && typeof specs === "object") {
        const key = SPEC_KEY_MAP[label];
        const v = key ? (specs as Record<string, unknown>)[key] : undefined;
        return v != null && typeof v === "string" ? v : "";
    }
    return "";
}

export function mapCarToCardProps(car: CarItem): CarCardProps | null {
    try {
        const slug = car.slug?.trim();
        if (!slug) return null;
        return {
            id: car.id,
            image:
                getImageUrl(car.main_image) || APP_IMAGES.CAR_PLACEHOLDER,
            brand: car.brand?.name ?? "",
            name: car.name ?? "",
            year: String(car.year ?? ""),
            type: car.type ?? "",
            slug,
            fuelType:
                getSpecValue(car.specs, "Fuel Type") ||
                car.fuel_type ||
                "",
            transmission:
                getSpecValue(car.specs, "Transmission") ||
                car.transmission ||
                "",
            seats: getSpecValue(car.specs, "seats") || car.seats || "",
            oldPrice:
                car.current_price != null &&
                car.current_price < (car.cash_price ?? 0)
                    ? formatPrice(
                          car.cash_price ?? 0,
                          "var(--brand-primary-color)",
                      )
                    : undefined,
            price: formatPrice(
                car.current_price ?? car.cash_price ?? 0,
                "var(--brand-primary-color)",
            ),
            monthlyPrice: formatPrice(
                car.min_installment ?? 0,
                "var(--brand-secondary-color)",
            ),
            detailsTo: `/cars/${slug}`,
            badgeText: car.highlight?.text_ar ?? car.highlight?.text ?? undefined,
            badgeColor: car.highlight?.color ?? undefined,
        };
    } catch {
        return null;
    }
}

export function unique<T>(arr: T[]): T[] {
    return arr.filter((v, i, a) => a.indexOf(v) === i);
}

export function specValue(car: CarItem, key: string, altKey?: string): string {
    if (altKey) {
        const v = (car as unknown as Record<string, unknown>)[altKey];
        if (v != null && typeof v === "string") return v;
    }
    if (typeof car.specs === "object" && !Array.isArray(car.specs)) {
        const v = (car.specs as Record<string, unknown>)[key];
        if (v != null && typeof v === "string") return v;
    }
    return "";
}

export function mapRelatedCar(car: CarItem): CarCardProps | null {
    try {
        const slug = car.slug?.trim();
        if (!slug) return null;
        return {
            id: car.id,
            image: getImageUrl(car.main_image) || APP_IMAGES.CAR_PLACEHOLDER,
            brand: car.brand?.name ?? "",
            name: car.name ?? "",
            year: String(car.year ?? ""),
            type: car.type ?? "",
            slug,
            fuelType: specValue(car, "fuel", "fuel_type"),
            transmission: specValue(car, "gearbox", "transmission"),
            seats: specValue(car, "seats"),
            oldPrice:
                car.current_price != null &&
                car.current_price < (car.cash_price ?? 0)
                    ? formatPrice(
                          car.cash_price ?? 0,
                          "var(--brand-primary-color)",
                      )
                    : undefined,
            price: formatPrice(
                car.current_price ?? car.cash_price ?? 0,
                "var(--brand-primary-color)",
            ),
            monthlyPrice: formatPrice(
                car.min_installment ?? 0,
                "var(--brand-secondary-color)",
            ),
            detailsTo: `/cars/${slug}`,
            badgeText: car.highlight?.text_ar ?? car.highlight?.text ?? undefined,
            badgeColor: car.highlight?.color ?? undefined,
        };
    } catch {
        return null;
    }
}

export function buildTabs(car: CarDetails, t: (key: string) => string): ITab[] {
    // 1. Technical specifications tab
    const specItems: ISpecItem[] = [];

    // From Specs JSON object if available
    if (car.specs && typeof car.specs === "object" && !Array.isArray(car.specs)) {
        const specMap: Record<string, string> = {
            fuel: "نوع الوقود",
            gearbox: "ناقل الحركة",
            engine: "المحرك",
            hp: "القوة (حصان)",
            drivetrain: "نظام الدفع",
            seats: "عدد المقاعد",
            color: "اللون",
            type: "نوع السيارة",
        };
        for (const [key, val] of Object.entries(car.specs)) {
            if (val && typeof val === "string" && val.trim() !== "") {
                const label = specMap[key] || key;
                specItems.push({ label, value: val });
            }
        }
    }

    // Combine pivot specifications
    if (Array.isArray(car.specifications) && car.specifications.length > 0) {
        for (const s of car.specifications) {
            const label = typeof s.name === "string" ? s.name : (s.name as any)?.ar || String(s.name || "");
            const val = s.value != null ? String(s.value) : "متوفر";
            if (label) specItems.push({ label, value: val });
        }
    }

    // Add fallback basics if empty
    if (specItems.length === 0) {
        if (car.year) specItems.push({ label: "سنة الصنع", value: String(car.year) });
        if (car.type) specItems.push({ label: "نوع السيارة", value: String(car.type) });
        if (car.brand?.name) specItems.push({ label: "الماركة", value: String(car.brand.name) });
    }

    // 2. Features list tab
    const featureItems: IFeatureItem[] = [];

    if (Array.isArray(car.features_list) && car.features_list.length > 0) {
        for (const f of car.features_list) {
            const name = typeof f.name === "string" ? f.name : (f.name as any)?.ar || String(f.name || "");
            if (name) {
                featureItems.push({
                    id: f.id || Math.random(),
                    name,
                    value: f.value != null ? String(f.value) : "متوفر",
                    icon: f.icon || "",
                });
            }
        }
    }

    // If empty, parse from car.features string or description if available
    if (featureItems.length === 0 && car.features) {
        const rawFeatures = typeof car.features === "string" ? car.features : (car.features as any)?.ar || "";
        if (rawFeatures) {
            const list = rawFeatures
                .split(/[\n,;•·-]/)
                .map((s: string) => s.trim())
                .filter(Boolean);
            list.forEach((name: string, idx: number) => {
                featureItems.push({ id: idx + 1, name, value: "متوفر", icon: "" });
            });
        }
    }

    // 3. Safety features tab
    const safetyItems: IFeatureItem[] = [];

    if (Array.isArray(car.safety_features) && car.safety_features.length > 0) {
        for (const sf of car.safety_features) {
            const name = typeof sf.name === "string" ? sf.name : (sf.name as any)?.ar || String(sf.name || "");
            if (name) {
                safetyItems.push({
                    id: sf.id || Math.random(),
                    name,
                    value: sf.value != null ? String(sf.value) : "متوفر",
                    icon: sf.icon || "",
                });
            }
        }
    }

    // If safety items empty, add default standard safety features
    if (safetyItems.length === 0) {
        const defaultSafety = [
            "وسائد هوائية أمامية وخلفية",
            "نظام منع انغلاق المكابح (ABS)",
            "نظام التوزيع الإلكتروني للمكابح (EBD)",
            "نظام التحكم بالثبات الإلكتروني (ESP)",
            "حساسات قياس ضغط الإطارات (TPMS)",
            "نظام تثبيت أركان السيارة للحماية",
        ];
        defaultSafety.forEach((name, idx) => {
            safetyItems.push({ id: idx + 1, name, value: "قياسي", icon: "" });
        });
    }

    return [
        {
            label: t("carDetails.specs.tab.specifications"),
            type: "specs",
            items: specItems,
        },
        {
            label: t("carDetails.specs.tab.features"),
            type: "other",
            items: featureItems,
        },
        {
            label: t("carDetails.specs.tab.security"),
            type: "safety",
            items: safetyItems,
        },
    ];
}

