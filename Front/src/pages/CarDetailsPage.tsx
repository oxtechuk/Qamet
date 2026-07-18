import { useMemo } from "react";
import { useParams } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { useLanguageStore } from "../store/language.store";
import CarDetailsHero from "../components/car-details/CarDetailsHero";
import CarDetailsSpecs from "../components/car-details/CarDetailsSpecs";
import FeaturedCarsSection from "../components/FeaturedCarsSection";
import { getCarBySlug } from "../services/api/cars.service";
import { getImageUrl } from "../constants/app-images";
import { mapRelatedCar, buildTabs } from "../utils/car-mappers";
import { useSEO } from "../utils/useSEO";
import type { CarCardProps } from "../components/CarCard";

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

    </>
  );
}
