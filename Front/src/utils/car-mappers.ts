import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { formatPrice } from "./format";
import type { CarCardProps } from "../components/CarCard";
import type { CarItem } from "../types/home.types";
import type { CarDetails } from "../types/cars.types";
import type { ITab } from "../interfaces/ICarDetailsSpecsProps";

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
    return [
        {
            label: t("carDetails.specs.tab.features"),
            type: "other",
            items: car.features_list ?? [],
        },
        {
            label: t("carDetails.specs.tab.specifications"),
            type: "other",
            items: car.specifications ?? [],
        },
        {
            label: t("carDetails.specs.tab.security"),
            type: "safety",
            items: car.safety_features ?? [],
        },
    ];
}
