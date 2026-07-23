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
import type { HomeCarItem, BrandInfo } from "../types/home.types";
import type { CarCardProps } from "../components/CarCard";
import { formatPrice } from "../utils/format";
import { useSEO } from "../utils/useSEO";
import { mapCarToCardProps as mapFullCarToCardProps } from "../utils/car-mappers";
import type { IBrandCardProps } from "../interfaces/IBrandCardProps";
import type { IBudgetRange } from "../interfaces/IBudgetRange";
import type { HeroSlide } from "../interfaces/IHomeHeroProps";
import type { IHomeOfferSlide } from "../interfaces/IHomeOfferSlide";
import type { IOfferCardProps } from "../interfaces/IOfferCardProps";
import PurchaseExperienceSection from "../components/PurchaseExperienceSection";
import HomeOffersSection from "../components/HomeOffersSection";
import OffersSection from "../components/OffersSection";

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
            badgeText: car.highlight ?? undefined,
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

function mapBannerToSlide(banner: {
    image: string | null;
    mobile_image: string | null;
    url: string | null;
    button_text: string;
}, index: number, t: (key: string) => string): IHomeOfferSlide {
    return {
        id: index,
        image: banner.image ?? "",
        mobileImage: banner.mobile_image ?? undefined,
        alt: "",
        buttonText: banner.button_text || t("campaignBanners.discoverMore"),
        buttonTo: banner.url || undefined,
    };
}

export default function Home() {
    const { t } = useTranslation();
    useSEO(t("nav.home"), t("hero.description"));
    const language = useLanguageStore((s) => s.language);
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
            ((brandSearch ? searchedBrands : data?.brands) ?? []).map(
                mapBrandToCardProps,
            ),
        [brandSearch, searchedBrands, data?.brands],
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
                subtitle: slide.car
                    ? (
                        <>
                            {t("hero.startsFrom")} {formatPrice(slide.car.min_installment, "var(--brand-secondary-color)")}
                        </>
                    )
                    : undefined,
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

    const homeOffers: IHomeOfferSlide[] = useMemo(
        () => (data?.campaign_banners ?? []).map((b, i) => mapBannerToSlide(b, i, t)),
        [data?.campaign_banners, t],
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
    const budgetSection = data?.cars_by_budget?.section;
    const offersSection = data?.offers?.section;

    const offerCards: IOfferCardProps[] = useMemo(
        () =>
            (data?.offers?.items ?? []).map((item) => ({
                image: getImageUrl(item.image) || item.car.main_image || APP_IMAGES.CAR_PLACEHOLDER,
                title: item.title,
                buttonText: offersSection?.button_text?.trim() || t("campaignBanners.discoverMore"),
                buttonTo: `/offers/${item.id}`,
            })),
        [data?.offers?.items, offersSection, t],
    );

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
                filterBrands={((data?.filter_brand_types?.length ? data.filter_brand_types : data?.filter_brands) ?? []) as BrandInfo[]}
                filterTypes={data?.filter_types}
                filterCategories={data?.filter_categories}
                filterYears={data?.filter_years}
                onCarFinderReset={() => {}}
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

            {homeOffers.length > 0 && (
                <HomeOffersSection
                    slides={homeOffers}
                    autoPlay
                    interval={5000}
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
