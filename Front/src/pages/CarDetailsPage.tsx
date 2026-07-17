import { useMemo } from "react";
import { useParams } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { useLanguageStore } from "../store/language.store";
import CarDetailsHero from "../components/car-details/CarDetailsHero";
import CarDetailsSpecs from "../components/car-details/CarDetailsSpecs";
import FeaturedCarsSection from "../components/FeaturedCarsSection";
import FinanceSolutionsSection from "../components/FinanceSolutionsSection";
import { getCarBySlug } from "../services/api/cars.service";
import { getFinanceSettings } from "../services/api";
import { getImageUrl, APP_IMAGES } from "../constants/app-images";
import { formatPrice } from "../utils/format";
import { useSEO } from "../utils/useSEO";
import type { CarDetails } from "../types/cars.types";
import type { CarItem } from "../types/home.types";
import type { CarCardProps } from "../components/CarCard";
import type { Tab } from "../components/car-details/CarDetailsSpecs";

function specValue(car: CarItem, key: string, altKey?: string): string {
  if (altKey) {
    const v = (car as any)[altKey];
    if (v != null && typeof v === "string") return v;
  }
  if (typeof car.specs === "object" && !Array.isArray(car.specs)) {
    const v = (car.specs as Record<string, unknown>)[key];
    if (v != null && typeof v === "string") return v;
  }
  return "";
}

function mapRelatedCar(car: CarItem): CarCardProps | null {
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
        car.current_price != null && car.current_price < (car.cash_price ?? 0)
          ? formatPrice(car.cash_price ?? 0, "var(--brand-primary-color)")
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
      badgeText: car.highlight,
    };
  } catch {
    return null;
  }
}

function buildTabs(car: CarDetails, t: (key: string) => string): Tab[] {
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

export default function CarDetailsPage() {
  const { t } = useTranslation();
  useSEO(t("nav.cars"), t("carDetails.hero.metaDescription"));
  const language = useLanguageStore((s) => s.language);
  const { slug } = useParams<{ slug: string }>();

  const { data: car, isLoading, isError } = useQuery({
    queryKey: ["car-details", slug, language],
    queryFn: () => getCarBySlug(slug!),
    enabled: !!slug,
    retry: 1,
  });

  const { data: financeData } = useQuery({
    queryKey: ["finance-solution", language],
    queryFn: getFinanceSettings,
    staleTime: 5 * 60 * 1000,
  });

  const tabs = useMemo(() => (car ? buildTabs(car, t) : []), [car, t]);

  const relatedCars = useMemo(
    () =>
      car?.related_cars
        ?.map(mapRelatedCar)
        .filter((c): c is CarCardProps => c !== null) ?? [],
    [car?.related_cars],
  );

  if (isLoading) {
    return (
      <div className="flex items-center justify-center py-20 text-xl font-bold text-gray-500">
        {t("carDetails.page.loading")}
      </div>
    );
  }

  if (isError) {
    return (
      <div className="flex items-center justify-center py-20 text-xl font-bold text-red-500">
        {t("carDetails.page.error")}
      </div>
    );
  }

  if (!car) {
    return (
      <div className="flex items-center justify-center py-20 text-xl font-bold text-gray-500">
        {t("carDetails.page.notFound")}
      </div>
    );
  }

  const saving = car.cash_price - car.current_price;

  return (
    <>
      <script type="application/ld+json">
        {JSON.stringify({
          "@context": "https://schema.org",
          "@type": "Product",
          name: car.name,
          description: car.description?.replace(/<[^>]*>/g, "").slice(0, 200),
          image: getImageUrl(car.main_image),
          brand: { "@type": "Brand", name: car.brand?.name },
          offers: {
            "@type": "Offer",
            price: car.current_price,
            priceCurrency: "SAR",
            availability: "https://schema.org/InStock",
          },
        })}
      </script>
      <CarDetailsHero
        title={car.name}
        description={car.description}
        images={car.images?.length ? car.images : [car.main_image]}
        exteriorImages={car.exterior_images}
        interiorImages={car.interior_images}
        price={car.current_price}
        oldPrice={saving > 0 ? car.cash_price : undefined}
        monthlyInstallment={car.min_installment}
        savingAmount={saving > 0 ? saving : undefined}
        colors={(car.colors ?? []).map((c) => ({ name: c.name, value: c.hex, image: c.image }))}
        orderTo="/contact"
        financeTo="/finance-calculator"
      />
      <CarDetailsSpecs tabs={tabs} />

      {relatedCars.length > 0 && (
        <FeaturedCarsSection
          titleBlue={t("carDetails.relatedCars.titleBlue")}
          titleOrange={t("carDetails.relatedCars.titleOrange")}
          description={t("carDetails.relatedCars.description")}
          buttonText={t("carDetails.relatedCars.buttonText")}
          buttonTo="/cars"
          cars={relatedCars}
          className="bg-[#F9FAFB]"
        />
      )}

      <FinanceSolutionsSection
        className="mb-20 mt-10"
        backgroundImage={APP_IMAGES.BG_IMAGE}
        titleBlue={financeData?.finance?.badge?.trim() || t("financeSolutions.titleBlue")}
        titleOrange={financeData?.finance?.title?.trim() || t("financeSolutions.titleOrange")}
        description={financeData?.finance?.subtitle?.trim() || t("financeSolutions.description")}
        buttonText={financeData?.finance?.button_text?.trim() || t("financeSolutions.buttonText")}
        buttonTo="/contact"
        stats={
          financeData?.stats?.length
            ? financeData.stats
            : [
                { value: "+500", label: t("financeSolutions.stats.0.label") },
                { value: "+1000", label: t("financeSolutions.stats.1.label") },
                { value: "+50", label: t("financeSolutions.stats.2.label") },
              ]
        }
        features={
          financeData?.finance?.features?.length
            ? financeData.finance.features
            : [
                t("financeSolutions.features.0"),
                t("financeSolutions.features.1"),
                t("financeSolutions.features.2"),
                t("financeSolutions.features.3"),
              ]
        }
      />
    </>
  );
}
