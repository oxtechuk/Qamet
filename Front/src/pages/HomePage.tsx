import { useState, useMemo } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import HomeHero from "../components/HomeHero";
import FeaturedCarsSection from "../components/FeaturedCarsSection";
import CarsShowcaseSection from "../components/CarsShowcaseSection";
import BudgetCarsSection from "../components/BudgetCarsSection";
import BrandsSection from "../components/BrandsSection";
import { getHomePageData, getCars, getBrands } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import type { CarItem, BrandInfo, FilterPrice } from "../types/home.types";
import type { CarCardProps } from "../components/CarCard";
import type { CarFinderValues } from "../interfaces/ICarFinderProps";
import { formatPrice } from "../utils/format";
import { useSEO } from "../utils/useSEO";
import type { IBrandCardProps } from "../interfaces/IBrandCardProps";
import type { IBudgetRange } from "../interfaces/IBudgetRange";
import type { HeroSlide } from "../interfaces/IHomeHeroProps";
import PurchaseExperienceSection from "../components/PurchaseExperienceSection";
import HomeOffersSection from "../components/HomeOffersSection";

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

const homeOffers = [
    {
        id: 1,
        image: "public/images/offer1.png",

        alt: "Ford Territory offer",
        buttonText: "اكتشف العرض",
        buttonTo: "/offers/ford-territory",
    },
    {
        id: 2,
        image: "public/images/offer1.png",

        alt: "Kia Sportage offer",
        buttonText: "اكتشف العرض",
        buttonTo: "/offers/kia-sportage",
    },
    {
        id: 3,
        image: "public/images/offer1.png",
        alt: "Toyota Camry offer",
        buttonText: "عرض التفاصيل",
        buttonTo: "/offers/toyota-camry",
    },
];
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
            fuelType:
                getSpecValue(car.specs, "Fuel Type") || car.fuel_type || "",
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
            badgeText: car.highlight,
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

function mapFilterPricesToRanges(
    prices?: FilterPrice[],
): IBudgetRange[] | undefined {
    if (!prices?.length) return undefined;
    return prices.map((p) => {
        const label =
            p.max == null
                ? `${formatPriceValue(p.min)}+`
                : `${formatPriceValue(p.min)} - ${formatPriceValue(p.max)}`;
        const value = p.max == null ? `${p.min}-plus` : `${p.min}-${p.max}`;
        return { label, value };
    });
}

export default function Home() {
    const { t } = useTranslation();
    useSEO(t("nav.home"), t("hero.description"));
    const language = useLanguageStore((s) => s.language);
    const [filters, setFilters] = useState<CarFinderValues | null>(null);
    const [activeBudgetRange, setActiveBudgetRange] = useState<string | null>(
        null,
    );
    const [brandSearch, setBrandSearch] = useState("");

    function parseRangeValue(value: string): {
        min_price?: number;
        max_price?: number;
    } {
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
                ...(filters!.categoryId && {
                    category_id: Number(filters!.categoryId),
                }),
                ...(filters!.year && { year: filters!.year }),
                ...(filters!.search && {
                    search: filters!.search,
                    q: filters!.search,
                }),
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
        () =>
            ((brandSearch ? searchedBrands : data?.brands) ?? []).map(
                mapBrandToCardProps,
            ),
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

    const heroSlides: HeroSlide[] = useMemo(() => {
        const apiSlides = data?.hero_slides;

        if (Array.isArray(apiSlides) && apiSlides.length > 0) {
            const fixedTitle =
                data?.hero?.title?.trim() ||
                `${data?.hero?.title1?.trim() || t("hero.titleBlue")} ${data?.hero?.title2?.trim() || t("hero.titleOrange")}`;
            const fixedSubtitle =
                data?.hero?.subtitle?.trim() || t("hero.slides.0.subtitle");

            const imageSlides = apiSlides.map(
                (slide: { image?: string | null }, index: number) => ({
                    id: index,
                    image: slide.image
                        ? getImageUrl(slide.image) || APP_IMAGES.LOGO
                        : APP_IMAGES.LOGO,
                    title: fixedTitle,
                    subtitle: fixedSubtitle,
                }),
            );

            return imageSlides;
        }

        return [
            {
                id: 0,
                image: data?.hero?.image
                    ? getImageUrl(data.hero.image)
                    : APP_IMAGES.HOME_HERO,
                thumbnail: data?.hero?.image
                    ? getImageUrl(data.hero.image)
                    : APP_IMAGES.HOME_HERO,
                subtitle: t("hero.slides.0.subtitle"),
                title: `${data?.hero?.title1?.trim() || t("hero.titleBlue")} ${data?.hero?.title2?.trim() || t("hero.titleOrange")}`,
                description:
                    data?.hero?.subtitle?.trim() ||
                    t("hero.slides.0.description"),
            },
            {
                id: 1,
                image: data?.featured_section?.car?.main_image
                    ? getImageUrl(data.featured_section.car.main_image)
                    : APP_IMAGES.CAR1,
                thumbnail: data?.featured_section?.car?.main_image
                    ? getImageUrl(data.featured_section.car.main_image)
                    : APP_IMAGES.CAR1,
                subtitle: t("hero.slides.1.subtitle"),
                title: t("hero.slides.1.title"),
                description: t("hero.slides.1.description"),
            },
            {
                id: 2,
                image: data?.featured_section?.offer?.image
                    ? getImageUrl(data.featured_section.offer.image)
                    : APP_IMAGES.EID,
                thumbnail: data?.featured_section?.offer?.image
                    ? getImageUrl(data.featured_section.offer.image)
                    : APP_IMAGES.EID,
                subtitle: t("hero.slides.2.subtitle"),
                title: t("hero.slides.2.title"),
                description: t("hero.slides.2.description"),
            },
        ];
    }, [data, t]);

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
                slides={heroSlides}
                heroVideoUrl={`${import.meta.env.BASE_URL}home_video.mp4`}
                primaryButtonText={t("hero.primaryButton")}
                primaryButtonTo="/cars"
                secondaryButtonText={t("hero.secondaryButton")}
                secondaryButtonTo="/finance-calculator"
                filterBrands={filterBrands}
                filterTypes={filterTypes}
                filterCategories={filterCategories}
                filterYears={filterYears}
                onCarFinderSearch={handleCarFinderSearch}
                onCarFinderReset={handleCarFinderReset}
                carouselBrands={(data?.brands ?? []).map((brand) => ({
                    id: brand.id,
                    name: brand.name,
                    logo: brand.logo
                        ? getImageUrl(brand.logo) ||
                          APP_IMAGES.BRAND_PLACEHOLDER
                        : APP_IMAGES.BRAND_PLACEHOLDER,
                    url: `/cars?brand=${brand.slug}`,
                }))}
            />
            <FeaturedCarsSection
                titleBlue={
                    data?.page_sections?.featured_cars?.badge?.trim() ||
                    t("featuredCars.titleBlue")
                }
                titleOrange={
                    data?.page_sections?.featured_cars?.title?.trim() ||
                    t("featuredCars.titleOrange")
                }
                description={
                    data?.page_sections?.featured_cars?.subtitle?.trim() ||
                    t("featuredCars.description")
                }
                buttonText={
                    data?.page_sections?.featured_cars?.button_text?.trim() ||
                    t("featuredCars.buttonText")
                }
                buttonTo="/cars"
                cars={filters ? filteredCarCards : featuredCars}
                itemsPerPage={filters ? 4 : undefined}
                emptyMessage={filters ? t("featuredCars.noCars") : undefined}
            />
            
            <PurchaseExperienceSection />

            <HomeOffersSection slides={homeOffers} autoPlay interval={5000} />

            <CarsShowcaseSection
                titleBlue={
                    data?.page_sections?.highlighted_cars?.badge?.trim() ||
                    t("carsShowcase.titleBlue")
                }
                titleOrange={
                    data?.page_sections?.highlighted_cars?.title?.trim() ||
                    t("carsShowcase.titleOrange")
                }
                description={
                    data?.page_sections?.highlighted_cars?.subtitle?.trim() ||
                    t("carsShowcase.description")
                }
                buttonText={
                    data?.page_sections?.highlighted_cars?.button_text?.trim() ||
                    t("carsShowcase.buttonText")
                }
                buttonTo="/cars"
                cars={showcaseCars}
            />

            <BudgetCarsSection
                titleBlue={
                    data?.page_sections?.budget?.badge?.trim() ||
                    t("budgetCars.titleBlue")
                }
                titleOrange={
                    data?.page_sections?.budget?.title?.trim() ||
                    t("budgetCars.titleOrange")
                }
                description={
                    data?.page_sections?.budget?.description?.trim() ||
                    t("budgetCars.description")
                }
                buttonText={
                    data?.page_sections?.budget?.button_text?.trim() ||
                    t("budgetCars.buttonText")
                }
                buttonTo="/cars"
                cars={activeBudgetRange ? budgetFilteredCars : budgetCars}
                activeRange={activeBudgetRange ?? undefined}
                onRangeChange={(value) =>
                    setActiveBudgetRange((prev) =>
                        prev === value ? null : value,
                    )
                }
                ranges={mapFilterPricesToRanges(data?.filter_prices)}
            />

            <BrandsSection
                titleBlue={
                    data?.page_sections?.brands?.badge?.trim() ||
                    t("brandsSection.titleBlue")
                }
                titleOrange={
                    data?.page_sections?.brands?.subtitle?.trim() ||
                    t("brandsSection.titleOrange")
                }
                description={
                    data?.page_sections?.brands?.description?.trim() ||
                    t("brandsSection.description")
                }
                buttonText={
                    data?.page_sections?.brands?.button_text?.trim() ||
                    t("brandsSection.buttonText")
                }
                buttonTo="/brands"
                brands={brands}
                onSearchChange={setBrandSearch}
            />
        </>
    );
}
