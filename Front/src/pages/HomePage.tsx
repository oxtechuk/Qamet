import { useState, useMemo } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import HomeHero from "../components/HomeHero";
import CarFinder from "../components/CarFinder";
import FeaturedCarsSection from "../components/FeaturedCarsSection";
import OffersSection from "../components/OffersSection";
import CarsShowcaseSection from "../components/CarsShowcaseSection";
import FinanceSolutionsSection from "../components/FinanceSolutionsSection";
import BudgetCarsSection from "../components/BudgetCarsSection";
import BrandsSection from "../components/BrandsSection";
import { getHomePageData, getCars, getFinanceSettings, getBrands } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import type { CarItem, BrandInfo, FilterPrice } from "../types/home.types";
import type { CarCardProps } from "../components/CarCard";
import type { CarFinderValues } from "../interfaces/ICarFinderProps";
import { formatPrice } from "../utils/format";
import { useSEO } from "../utils/useSEO";
import type { IOfferCardProps } from "../interfaces/IOfferCardProps";
import type { IBrandCardProps } from "../interfaces/IBrandCardProps";
import type { IBudgetRange } from "../interfaces/IBudgetCarsSectionProps";

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
      badgeText: car.is_current_year ? String(car.year) : undefined,
    };
  } catch {
    return null;
  }
}

function mapBrandToCardProps(brand: BrandInfo): IBrandCardProps {
  return {
    id: brand.id,
    name: brand.name,
    logo: getImageUrl(brand.logo) || APP_IMAGES.BRAND_PLACEHOLDER,
  };
}

function formatPriceValue(price: number): string {
  return price.toLocaleString();
}

function mapFilterPricesToRanges(prices?: FilterPrice[]): IBudgetRange[] | undefined {
  if (!prices?.length) return undefined;
  return prices.map((p) => {
    const label = p.max == null
      ? `${formatPriceValue(p.min)}+`
      : `${formatPriceValue(p.min)} - ${formatPriceValue(p.max)}`;
    const value = p.max == null ? `${p.min}-plus` : `${p.min}-${p.max}`;
    return { label, value };
  });
}

const getFallbackOffers = (t: (key: string) => string): IOfferCardProps[] => [
  {
    image: APP_IMAGES.OFFER1,
    buttonText: t("homePage.fallbackOfferButton"),
    buttonTo: "/cars?offerId=1",
  },
  {
    image: APP_IMAGES.OFFER1,
    buttonText: t("homePage.fallbackOfferButton"),
    buttonTo: "/cars?offerId=2",
  },
  {
    image: APP_IMAGES.OFFER1,
    buttonText: t("homePage.fallbackOfferButton"),
    buttonTo: "/cars?offerId=3",
  },
];

export default function Home() {
  const { t } = useTranslation();
  useSEO(t("nav.home"), t("hero.description"));
  const language = useLanguageStore((s) => s.language);
  const [filters, setFilters] = useState<CarFinderValues | null>(null);
  const [activeBudgetRange, setActiveBudgetRange] = useState<string | null>(null);
  const [brandSearch, setBrandSearch] = useState("");

  function parseRangeValue(value: string): { min_price?: number; max_price?: number } {
    if (value.endsWith("-plus")) {
      const min = Number(value.replace("-plus", ""));
      return { min_price: min };
    }
    const parts = value.split("-");
    if (parts.length === 2) {
      return { min_price: Number(parts[0]), max_price: Number(parts[1]) };
    }
    return {};
  }

  const { data, isLoading } = useQuery({
    queryKey: ["home-data", language],
    queryFn: getHomePageData,
  });

  const { data: financeData } = useQuery({
    queryKey: ["finance-settings", language],
    queryFn: getFinanceSettings,
    staleTime: 5 * 60 * 1000,
  });

  const { data: searchedBrands } = useQuery({
    queryKey: ["brands-search", brandSearch, language],
    queryFn: () => getBrands(brandSearch || undefined),
    staleTime: 2 * 60 * 1000,
  });

  const { data: filteredData } = useQuery({
    queryKey: ["filtered-cars", filters, language],
    queryFn: () =>
      getCars({
        ...(filters!.brandId && { brands: [Number(filters!.brandId)] }),
        ...(filters!.typeId && { type: Number(filters!.typeId) }),
        ...(filters!.categoryId && { category_id: Number(filters!.categoryId) }),
        ...(filters!.year && { year: filters!.year }),
        ...(filters!.search && { search: filters!.search, q: filters!.search }),
        per_page: 12,
      }),
    enabled: !!filters,
  });

  const { data: budgetFilteredData } = useQuery({
    queryKey: ["budget-cars", activeBudgetRange, language],
    queryFn: () =>
      getCars({
        ...parseRangeValue(activeBudgetRange!),
        per_page: 12,
      }),
    enabled: !!activeBudgetRange,
  });

  const handleCarFinderSearch = (values: CarFinderValues) => {
    setFilters(values);
  };

  const handleCarFinderReset = () => {
    setFilters(null);
  };

  const featuredCars = useMemo(
    () =>
      (data?.featured_cars ?? [])
        .map(mapCarToCardProps)
        .filter(Boolean) as CarCardProps[],
    [data?.featured_cars],
  );
  const showcaseCars = useMemo(
    () =>
      (data?.highlighted_cars ?? [])
        .map(mapCarToCardProps)
        .filter(Boolean) as CarCardProps[],
    [data?.highlighted_cars],
  );
  const budgetCars = useMemo(
    () =>
      (data?.bento_cars ?? [])
        .map(mapCarToCardProps)
        .filter(Boolean) as CarCardProps[],
    [data?.bento_cars],
  );
  const budgetFilteredCars = useMemo(
    () =>
      (budgetFilteredData?.data ?? [])
        .map(mapCarToCardProps)
        .filter(Boolean) as CarCardProps[],
    [budgetFilteredData],
  );
  const brands = useMemo(
    () => ((brandSearch ? searchedBrands : data?.brands) ?? []).map(mapBrandToCardProps),
    [brandSearch, searchedBrands, data?.brands],
  );
  const filteredCarCards = useMemo(
    () =>
      (filteredData?.data ?? [])
        .map(mapCarToCardProps)
        .filter(Boolean) as CarCardProps[],
    [filteredData],
  );
  const filterBrands = data?.filter_brands ?? [];
  const filterTypes = data?.filter_types ?? [];
  const filterCategories = data?.filter_categories ?? [];
  const filterYears = data?.filter_years ?? [];

  if (isLoading) {
    return (
      <div className="flex min-h-[400px] items-center justify-center">
        <div className="h-10 w-10 animate-spin rounded-full border-4 border-[var(--brand-primary-color)] border-t-transparent" />
      </div>
    );
  }

  return (
    <>
      <HomeHero
        bannerImage={data?.hero?.image ? getImageUrl(data.hero.image) : APP_IMAGES.HOME_HERO}
        titleBlue={data?.hero?.title1?.trim() || t("hero.titleBlue")}
        titleOrange={data?.hero?.title2?.trim() || t("hero.titleOrange")}
        description={data?.hero?.subtitle?.trim() || t("hero.description")}
        primaryButtonText={t("hero.primaryButton")}
        primaryButtonTo="/cars"
        secondaryButtonText={t("hero.secondaryButton")}
        secondaryButtonTo="/finance-calculator"
        cards={[
          {
            image: data?.featured_section?.offer?.image
              ? getImageUrl(data.featured_section.offer.image)
              : APP_IMAGES.EID,
            title: data?.featured_section?.offer?.title?.trim() || t("hero.cards.0.title"),
            description: data?.featured_section?.offer?.description?.trim() || t("hero.cards.0.description"),
            buttonText: t("hero.cards.0.buttonText"),
            buttonTo: data?.featured_section?.offer
              ? `/cars?offerId=${data.featured_section.offer.id}`
              : "/cars?offerId=1",
          },
          {
            image: data?.featured_section?.car?.main_image
              ? getImageUrl(data.featured_section.car.main_image)
              : APP_IMAGES.CAR1,
            title: data?.featured_section?.car?.name?.trim() || t("hero.cards.1.title"),
            description: data?.featured_section?.car?.type?.trim() || t("hero.cards.1.description"),
            buttonText: t("hero.cards.1.buttonText"),
            buttonTo: data?.featured_section?.car?.slug
              ? `/cars/${data.featured_section.car.slug}`
              : "/cars/kia-sportage",
            badge: data?.featured_section?.car && data.featured_section.car.is_current_year
              ? String(data.featured_section.car.year)
              : t("hero.cards.1.badge"),
          },
        ]}
      />

      <CarFinder
        onSearch={handleCarFinderSearch}
        onReset={handleCarFinderReset}
        brands={filterBrands}
        types={filterTypes}
        categories={filterCategories}
        years={filterYears}
        filterTitle={data?.page_sections?.filter?.title?.trim()}
      />

      <FeaturedCarsSection
        titleBlue={data?.page_sections?.featured_cars?.badge?.trim() || t("featuredCars.titleBlue")}
        titleOrange={data?.page_sections?.featured_cars?.title?.trim() || t("featuredCars.titleOrange")}
        description={data?.page_sections?.featured_cars?.subtitle?.trim() || t("featuredCars.description")}
        buttonText={data?.page_sections?.featured_cars?.button_text?.trim() || t("featuredCars.buttonText")}
        buttonTo="/cars"
        cars={filters ? filteredCarCards : featuredCars}
        itemsPerPage={filters ? 4 : undefined}
        emptyMessage={filters ? t("featuredCars.noCars") : undefined}
      />

      <OffersSection
        backgroundImage={APP_IMAGES.BG_IMAGE}
        titleWhite={data?.page_sections?.offers?.badge?.trim() || t("offers.titleWhite")}
        titleOrange={data?.page_sections?.offers?.title?.trim() || t("offers.titleOrange")}
        buttonText={data?.page_sections?.offers?.button_text?.trim() || t("offers.buttonText")}
        buttonTo="/offers"
        offers={
          data?.active_offers?.length
            ? data.active_offers.map((o) => ({
                image: getImageUrl(o.image) || APP_IMAGES.OFFER1,
                title: o.title,
                buttonText: t("homePage.fallbackOfferButton"),
                buttonTo: `/cars?offerId=${o.id}`,
              }))
            : getFallbackOffers(t)
        }
      />

      <CarsShowcaseSection
        titleBlue={data?.page_sections?.highlighted_cars?.badge?.trim() || t("carsShowcase.titleBlue")}
        titleOrange={data?.page_sections?.highlighted_cars?.title?.trim() || t("carsShowcase.titleOrange")}
        description={data?.page_sections?.highlighted_cars?.subtitle?.trim() || t("carsShowcase.description")}
        buttonText={data?.page_sections?.highlighted_cars?.button_text?.trim() || t("carsShowcase.buttonText")}
        buttonTo="/cars"
        cars={showcaseCars}
      />

      <FinanceSolutionsSection
        className="mb-5"
        backgroundImage={APP_IMAGES.BG_IMAGE}
        titleBlue={financeData?.finance?.badge?.trim() || data?.page_sections?.finance?.badge?.trim() || t("financeSolutions.titleBlue")}
        titleOrange={financeData?.finance?.title?.trim() || data?.page_sections?.finance?.title?.trim() || t("financeSolutions.titleOrange")}
        description={financeData?.finance?.subtitle?.trim() || data?.page_sections?.finance?.subtitle?.trim() || t("financeSolutions.description")}
        buttonText={financeData?.finance?.button_text?.trim() || data?.page_sections?.finance?.button_text?.trim() || t("financeSolutions.buttonText")}
        buttonTo="/contact"
        stats={
          financeData?.stats?.length
            ? financeData.stats
            : data?.homepage_stats?.length
              ? data.homepage_stats
              : [
                  { value: "+500", label: t("financeSolutions.stats.0.label") },
                  { value: "+1000", label: t("financeSolutions.stats.1.label") },
                  { value: "+50", label: t("financeSolutions.stats.2.label") },
                ]
        }
        features={
          financeData?.finance?.features?.length
            ? financeData.finance.features
            : data?.page_sections?.finance?.features?.length
              ? data.page_sections.finance.features
              : [
                  t("financeSolutions.features.0"),
                  t("financeSolutions.features.1"),
                  t("financeSolutions.features.2"),
                  t("financeSolutions.features.3"),
                ]
        }
      />

      <BudgetCarsSection
        titleBlue={data?.page_sections?.budget?.badge?.trim() || t("budgetCars.titleBlue")}
        titleOrange={data?.page_sections?.budget?.title?.trim() || t("budgetCars.titleOrange")}
        description={data?.page_sections?.budget?.description?.trim() || t("budgetCars.description")}
        buttonText={data?.page_sections?.budget?.button_text?.trim() || t("budgetCars.buttonText")}
        buttonTo="/cars"
        cars={activeBudgetRange ? budgetFilteredCars : budgetCars}
        activeRange={activeBudgetRange ?? undefined}
        onRangeChange={(value) =>
          setActiveBudgetRange((prev) => (prev === value ? null : value))
        }
        ranges={mapFilterPricesToRanges(data?.filter_prices)}
      />

      <BrandsSection
        titleBlue={data?.page_sections?.brands?.badge?.trim() || t("brandsSection.titleBlue")}
        titleOrange={data?.page_sections?.brands?.subtitle?.trim() || t("brandsSection.titleOrange")}
        description={data?.page_sections?.brands?.description?.trim() || t("brandsSection.description")}
        buttonText={data?.page_sections?.brands?.button_text?.trim() || t("brandsSection.buttonText")}
        buttonTo="/brands"
        brands={brands}
        onSearchChange={setBrandSearch}
      />
    </>
  );
}
