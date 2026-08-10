import { useState, useMemo, useEffect } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import HomeHero from "../components/HomeHero";
import FeaturedCarsSection from "../components/FeaturedCarsSection";
import BudgetCarsSection from "../components/BudgetCarsSection";
import BrandsSection from "../components/BrandsSection";
import { getHomePageData, getCars, getBrands } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { useSettingsStore } from "../store/settings.store";
import type { HomeCarItem, HomeOfferItem, BrandInfo } from "../types/home.types";
import type { CarCardProps } from "../components/CarCard";
import { formatPrice } from "../utils/format";
import { getLocalizedName } from "../utils/localized-name";
import { useSEO } from "../utils/useSEO";
import { mapCarToCardProps as mapFullCarToCardProps } from "../utils/car-mappers";
import type { IBrandCardProps } from "../interfaces/IBrandCardProps";
import type { IBudgetRange } from "../interfaces/IBudgetRange";
import type { HeroSlide } from "../interfaces/IHomeHeroProps";
import PurchaseExperienceSection from "../components/PurchaseExperienceSection";
import HomePageSkeleton from "../components/skeletons/HomePageSkeleton";

function mapHomeCarToCardProps(car: HomeCarItem): CarCardProps | null {
    try {
        const slug = car.slug?.trim();
        if (!slug) return null;
        return {
            id: car.id,
            image: getImageUrl(car.main_image) || APP_IMAGES.CAR_PLACEHOLDER,
            brand: car.brand?.name ?? "",
            name: car.name ?? "",
            year: String(car.year ?? ""),
            oldPrice:
                car.savings > 0
                    ? formatPrice(car.cash_price, "var(--brand-primary-color)")
                    : undefined,
            price: formatPrice(
                car.current_price || car.cash_price,
                "var(--brand-primary-color)",
            ),
            monthlyPrice: formatPrice(
                car.min_installment ?? 0,
                "var(--brand-secondary-color)",
            ),
            detailsTo: `/cars/${slug}`,
            badgeText:
                car.highlight?.text ?? car.highlight?.text_ar ?? undefined,
            badgeColor: car.highlight?.color ?? undefined,
        };
    } catch {
        return null;
    }
}

function mapBrandToCardProps(
    brand: BrandInfo,
    language: string,
): IBrandCardProps {
    return {
        id: brand.id,
        name: getLocalizedName(brand.name, language),
        logo: getImageUrl(brand.logo) || APP_IMAGES.BRAND_PLACEHOLDER,
    };
}

function mapOfferToCardProps(offer: HomeOfferItem): CarCardProps | null {
    try {
        const slug = offer.car?.slug?.trim();
        if (!slug) return null;
        return {
            id: offer.id,
            image:
                getImageUrl(offer.image) ||
                getImageUrl(offer.car?.main_image) ||
                APP_IMAGES.CAR_PLACEHOLDER,
            brand: offer.car.brand?.name ?? "",
            name: offer.car.name ?? "",
            year: "",
            price: formatPrice(
                offer.car.cash_price ?? 0,
                "var(--brand-primary-color)",
            ),
            monthlyPrice: formatPrice(
                offer.installment_starts_from ?? 0,
                "var(--brand-secondary-color)",
            ),
            detailsTo: `/cars/${slug}`,
            badgeText: offer.title || undefined,
        };
    } catch {
        return null;
    }
}

function mapBracketsToRanges(
    brackets?: {
        label: string;
        min: number;
        max: number | null;
        count: number;
    }[],
): IBudgetRange[] | undefined {
    if (!brackets?.length) return undefined;
    return brackets.map((b) => ({
        label: b.label,
        value: b.max == null ? `${b.min}-plus` : `${b.min}-${b.max}`,
        min: b.min,
        max: b.max,
        count: b.count,
    }));
}

export default function Home() {
    const { t } = useTranslation();
    useSEO(t("nav.home"), t("hero.description"));
    const language = useLanguageStore((s) => s.language);
    const settings = useSettingsStore((s) => s.settings);
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

    const { data: budgetFilteredData } = useQuery({
        queryKey: ["budget-cars", activeBudgetRange, language],
        queryFn: () =>
            getCars({
                ...parseRangeValue(activeBudgetRange!),
                per_page: 12,
            }),
        enabled: !!activeBudgetRange,
    });

    const latestCars = useMemo(
        () =>
            (data?.latest_cars?.items ?? [])
                .map(mapHomeCarToCardProps)
                .filter(Boolean) as CarCardProps[],
        [data?.latest_cars?.items],
    );

    const budgetCars = useMemo(
        () =>
            (data?.cars_by_budget?.cars ?? [])
                .map(mapHomeCarToCardProps)
                .filter(Boolean) as CarCardProps[],
        [data?.cars_by_budget?.cars],
    );

    const budgetFilteredCars = useMemo(
        () =>
            (budgetFilteredData?.data ?? [])
                .map(mapFullCarToCardProps)
                .filter(Boolean) as CarCardProps[],
        [budgetFilteredData],
    );

    const brands = useMemo(
        () =>
            ((brandSearch ? searchedBrands : data?.brands) ?? []).map((brand) =>
                mapBrandToCardProps(brand, language),
            ),
        [brandSearch, searchedBrands, data?.brands, language],
    );

    const heroSlides: HeroSlide[] = useMemo(() => {
        const apiSlides = data?.hero_slides;

        if (Array.isArray(apiSlides) && apiSlides.length > 0) {
            return apiSlides.map((slide, index) => ({
                id: index,
                image: slide.image
                    ? getImageUrl(slide.image) || APP_IMAGES.LOGO
                    : APP_IMAGES.LOGO,
                title: slide.car ? slide.car.name : slide.title,
                subtitle: slide.car ? (
                    <>
                        {t("hero.startsFrom")}{" "}
                        {formatPrice(
                            slide.car.min_installment,
                            "var(--brand-secondary-color)",
                        )}
                    </>
                ) : undefined,
                buttonText: slide.button_text,
                buttonLink: slide.button_link,
                button2Text: slide.button_2_text,
                button2Link: slide.button_2_link,
            }));
        }

        return [
            {
                id: 0,
                image: APP_IMAGES.HOME_HERO,
                title: t("hero.titleBlue"),
                subtitle: t("hero.slides.0.subtitle"),
                buttonText: t("hero.primaryButton"),
                buttonLink: "/cars",
                button2Text: t("hero.secondaryButton"),
                button2Link: "/finance-calculator",
            },
        ];
    }, [data, t]);

    useEffect(() => {
        const firstSlide = data?.hero_slides?.[0];
        if (!firstSlide?.image) {
            return;
        }
        const heroUrl = getImageUrl(firstSlide.image);
        if (!heroUrl) {
            return;
        }
        const link = document.createElement("link");
        link.rel = "preload";
        link.as = "image";
        link.href = heroUrl;
        document.head.appendChild(link);
        return () => {
            if (document.head.contains(link)) {
                document.head.removeChild(link);
            }
        };
    }, [data?.hero_slides]);

    const offerCars = useMemo(
        () =>
            (data?.offers?.items ?? [])
                .filter((item) => !item.is_expired)
                .map(mapOfferToCardProps)
                .filter(Boolean) as CarCardProps[],
        [data?.offers?.items],
    );

    const budgetRanges = useMemo(
        () => mapBracketsToRanges(data?.cars_by_budget?.brackets),
        [data?.cars_by_budget?.brackets],
    );

    useEffect(() => {
        if (budgetRanges?.length && activeBudgetRange === null) {
            setActiveBudgetRange(budgetRanges[0].value);
        }
    }, [budgetRanges, activeBudgetRange]);

    const latestSection = data?.latest_cars?.section;
    const offersSection = data?.offers?.section;
    const budgetSection = data?.cars_by_budget?.section;

    if (isLoading) {
        return <HomePageSkeleton />;
    }

    return (
        <>
            <HomeHero
                slides={heroSlides}
                heroVideoUrl={settings?.hero_video || undefined}
                heroVideoYoutube={settings?.hero_video_youtube || undefined}
                filterBrands={
                    ((data?.filter_brand_types?.length
                        ? data.filter_brand_types
                        : data?.filter_brands) ?? []) as BrandInfo[]
                }
                filterTypes={data?.filter_types}
                filterCategories={data?.filter_categories}
                filterYears={data?.filter_years}
                onCarFinderReset={() => {}}
                carouselBrands={(data?.brands ?? []).map((brand) => ({
                    id: brand.id,
                    name: getLocalizedName(brand.name, language),
                    logo: brand.logo
                        ? getImageUrl(brand.logo) ||
                          APP_IMAGES.BRAND_PLACEHOLDER
                        : APP_IMAGES.BRAND_PLACEHOLDER,
                    url: `/cars?brand=${brand.slug}`,
                }))}
            />
            <FeaturedCarsSection
                titleBlue={
                    latestSection?.title?.trim() || t("featuredCars.titleBlue")
                }
                buttonText={
                    latestSection?.button_text?.trim() ||
                    t("featuredCars.buttonText")
                }
                buttonTo="/cars"
                cars={latestCars}
            />

            <PurchaseExperienceSection />

            {offerCars.length > 0 && (
                <FeaturedCarsSection
                    titleBlue={
                        offersSection?.title?.trim() ||
                        t("allCarsPage.homeOffers.alsoFromOurOffers")
                    }
                    buttonText={
                        offersSection?.button_text?.trim() ||
                        t("featuredCars.buttonText")
                    }
                    buttonTo="/offers"
                    cars={offerCars}
                />
            )}

            <BudgetCarsSection
                titleBlue={
                    budgetSection?.title?.trim() || t("budgetCars.titleBlue")
                }
                description={
                    budgetSection?.description?.trim() ||
                    t("budgetCars.description")
                }
                buttonText={
                    budgetSection?.button_text?.trim() ||
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
                ranges={budgetRanges}
            />

            <BrandsSection
                titleBlue={t("brandsSection.titleBlue")}
                buttonText={t("brandsSection.buttonText")}
                buttonTo="/brands"
                brands={brands}
                onSearchChange={setBrandSearch}
            />
        </>
    );
}
