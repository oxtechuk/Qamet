import { useState, useMemo } from "react";
import { useTranslation } from "react-i18next";
import { useSearchParams } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import AllCarsHero from "../components/AllCarsHero";
import AllCarsFilterBar from "../components/AllCarsFilterBar";
import CarsSidebarFilter from "../components/CarsSidebarFilter";
import CarsResultsGrid from "../components/CarsResultsGrid";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { getHomePageData, getCarsMeta } from "../services/api";
import { getCars } from "../services/api/cars.service";
import { useLanguageStore } from "../store/language.store";
import type { CarCardProps } from "../components/CarCard";
import { formatPrice } from "../utils/format";
import { useSEO } from "../utils/useSEO";
import type { FilterValues, CarsQueryParams } from "../types/cars.types";
import { DEFAULT_FILTER_VALUES } from "../types/cars.types";
import type { CarItem } from "../types/home.types";
import ContactCtaSection from "../components/ContactCtaSection";

const PAGE_SIZE = 6;

const SPEC_KEY_MAP: Record<string, string> = {
  "Fuel Type": "fuel",
  Transmission: "gearbox",
  seats: "seats",
};

function getSpecValue(specs: CarItem["specs"], label: string): string {
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

function mapCarToCardProps(car: CarItem): CarCardProps | null {
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
      fuelType: getSpecValue(car.specs, "Fuel Type") || car.fuel_type || "",
      transmission:
        getSpecValue(car.specs, "Transmission") || car.transmission || "",
      seats: getSpecValue(car.specs, "seats") || car.seats || "",
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

function unique<T>(arr: T[]): T[] {
  return arr.filter((v, i, a) => a.indexOf(v) === i);
}

export default function AllCarsPage() {
  const { t } = useTranslation();
  useSEO(t("nav.cars"), t("allCarsHero.description"));
  const language = useLanguageStore((s) => s.language);
  const [searchParams] = useSearchParams();
  const offerId = searchParams.get("offerId");

  const { data: homeData } = useQuery({
    queryKey: ["home-data", language],
    queryFn: getHomePageData,
    staleTime: 5 * 60 * 1000,
  });

  const { data: carsMeta } = useQuery({
    queryKey: ["cars-meta", language],
    queryFn: getCarsMeta,
    staleTime: 5 * 60 * 1000,
  });

  const [filters, setFilters] = useState<FilterValues>(DEFAULT_FILTER_VALUES);
  const [currentPage, setCurrentPage] = useState(1);

  function buildParams(): CarsQueryParams {
    const params: CarsQueryParams = {};

    if (filters.brandId !== null) {
      params.brands = [filters.brandId];
    }
    if (filters.type !== "all") {
      params.type = Number(filters.type);
    }
    if (filters.year) {
      params.year = filters.year;
    }
    if (filters.priceMin > 0) {
      params.min_price = filters.priceMin;
    }
    if (filters.priceMax < 200000) {
      params.max_price = filters.priceMax;
    }
    if (filters.search) {
      params.search = filters.search;
    }
    if (offerId) {
      params.offer_id = Number(offerId);
    }

    return params;
  }

  const { data: carsResponse } = useQuery({
    queryKey: ["cars-data", language, filters, currentPage, offerId],
    queryFn: () => getCars(buildParams()),
    staleTime: 5 * 60 * 1000,
    retry: 1,
  });

  const allCars = useMemo(() => {
    if (carsResponse) {
      return carsResponse.data
        .map(mapCarToCardProps)
        .filter(Boolean) as CarCardProps[];
    }

    const fallback = homeData?.featured_cars ?? homeData?.bento_cars ?? [];
    return fallback.map(mapCarToCardProps).filter(Boolean) as CarCardProps[];
  }, [carsResponse, homeData?.featured_cars, homeData?.bento_cars]);

  const sidebarData = useMemo(() => {
    const transmissions = unique(
      allCars.map((c) => c.transmission).filter(Boolean),
    );
    const fuelTypes = unique(allCars.map((c) => c.fuelType).filter(Boolean));
    return { transmissions, fuelTypes };
  }, [allCars]);

  const filteredCars = useMemo(() => {
    let result = allCars.slice();

    if (filters.transmission !== "all") {
      result = result.filter((c) => c.transmission === filters.transmission);
    }
    if (filters.fuelType !== "all") {
      result = result.filter((c) => c.fuelType === filters.fuelType);
    }

    return result;
  }, [allCars, filters]);

  const totalPages = Math.max(1, Math.ceil(filteredCars.length / PAGE_SIZE));
  const safePage = Math.min(currentPage, totalPages);
  const pagedCars = filteredCars.slice(
    (safePage - 1) * PAGE_SIZE,
    safePage * PAGE_SIZE,
  );

  const handleFilterChange = (newFilters: FilterValues) => {
    setFilters(newFilters);
    setCurrentPage(1);
  };

  return (
    <main>
      <AllCarsHero
        offerImage={
          carsMeta?.hero_slides?.[0]?.image
            ? getImageUrl(carsMeta.hero_slides[0].image)
            : APP_IMAGES.ALL_CARS_OFFER_IMAGE
        }
        badge={carsMeta?.hero_badge?.trim()}
        titleLine1={carsMeta?.hero_title_line1?.trim()}
        titleLine2Prefix={carsMeta?.hero_title_line2_prefix?.trim()}
        titleLine2Highlight={carsMeta?.hero_title_line2_highlight?.trim()}
        description={carsMeta?.hero_description?.trim()}
        stats={carsMeta?.homepage_stats}
        primaryButtonText={t("allCarsHero.button1")}
        primaryButtonTo="/offers"
      />

      <AllCarsFilterBar
        activeFilter={filters.type}
        onFilterChange={(v) =>
          handleFilterChange({ ...filters, type: v, brandId: filters.brandId })
        }
        onSearchChange={(v) => handleFilterChange({ ...filters, search: v })}
      />

      {/* Mobile filter trigger */}
      <div className="mx-auto max-w-7xl px-4 pb-4 pt-2 sm:px-6 lg:hidden">
        <CarsSidebarFilter
          transmissions={sidebarData.transmissions}
          fuelTypes={sidebarData.fuelTypes}
          filters={filters}
          onFilterChange={handleFilterChange}
        />
      </div>

      <section className="mx-auto flex max-w-7xl items-start gap-6 px-4 py-6 sm:px-6 lg:px-8">
        {/* Desktop sidebar */}
        <div className="hidden shrink-0 lg:block">
          <CarsSidebarFilter
            transmissions={sidebarData.transmissions}
            fuelTypes={sidebarData.fuelTypes}
            filters={filters}
            onFilterChange={handleFilterChange}
          />
        </div>

        {/* Main content */}
        <div className="min-w-0 flex-1">
          {pagedCars.length > 0 ? (
            <CarsResultsGrid
              cars={pagedCars}
              currentPage={safePage}
              totalPages={totalPages}
              onPageChange={setCurrentPage}
            />
          ) : (
            <div className="py-20 text-center">
              <p className="text-lg font-medium text-gray-400">
                {t("allCarsPage.noCarsMatch")}
              </p>
            </div>
          )}
        </div>
      </section>

      <ContactCtaSection
        badgeText={t("allCarsPage.contactBadge")}
        titleWhite={t("allCarsPage.contactTitleWhite")}
        titleOrange={t("allCarsPage.contactTitleOrange")}
        description={t("allCarsPage.contactDescription")}
        phoneText={t("allCarsPage.contactPhone")}
        phoneHref="tel:+966500000000"
        whatsappText={t("allCarsPage.contactWhatsapp")}
        
        sectionBgColor="var(--brand-CTA-BG-color)"
      />
    </main>
  );
}
