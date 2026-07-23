import { useState, useMemo, useEffect } from "react";
import { useTranslation } from "react-i18next";
import { useSearchParams } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import AllCarsSearchBar from "../components/AllCarsSearchBar";
import CarsSidebarFilter from "../components/CarsSidebarFilter";
import CarsResultsGrid from "../components/CarsResultsGrid";
import HomeOffersSection from "../components/HomeOffersSection";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { getHomePageData, getCarsMeta } from "../services/api";
import { getCars } from "../services/api/cars.service";
import { useLanguageStore } from "../store/language.store";
import { mapCarToCardProps, unique } from "../utils/car-mappers";
import { formatPrice } from "../utils/format";
import { useSEO } from "../utils/useSEO";
import type { FilterValues, CarsQueryParams } from "../types/cars.types";
import { DEFAULT_FILTER_VALUES } from "../types/cars.types";
import type { CarCardProps } from "../components/CarCard";
import type { IHomeOfferSlide } from "../interfaces/IHomeOfferSlide";

const PAGE_SIZE = 6;

export default function AllCarsPage() {
    const { t } = useTranslation();
    useSEO(t("nav.cars"), t("allCarsHero.description"));
    const language = useLanguageStore((s) => s.language);
    const [searchParams] = useSearchParams();
    const offerId = searchParams.get("offerId");

    const initialFilters = useMemo<FilterValues>(() => {
        const brands = searchParams.get("brands[]");
        const type = searchParams.get("type");
        const categoryId = searchParams.get("category_id");
        const year = searchParams.get("year");
        const q = searchParams.get("q");

        if (!brands && !type && !categoryId && !year && !q) {
            return DEFAULT_FILTER_VALUES;
        }

        return {
            ...DEFAULT_FILTER_VALUES,
            brandId: brands ? Number(brands) : null,
            type: type ?? "all",
            categoryId: categoryId ? Number(categoryId) : null,
            year: year ?? "",
            search: q ?? "",
        };
    }, [searchParams]);

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

    const [filters, setFilters] = useState<FilterValues>(initialFilters);
    const [currentPage, setCurrentPage] = useState(1);

    useEffect(() => {
        setFilters(initialFilters);
        setCurrentPage(1);
    }, [initialFilters]);

    function buildParams(): CarsQueryParams {
        const params: CarsQueryParams = {};

        if (filters.brandId !== null) {
            params.brands = [filters.brandId];
        }
        if (filters.type !== "all") {
            params.type = Number(filters.type);
        }
        if (filters.categoryId !== null) {
            params.category_id = filters.categoryId;
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
            params.q = filters.search;
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

        const fallback = homeData?.latest_cars?.items ?? homeData?.cars_by_budget?.cars ?? [];
        return fallback
            .map((car) => ({
                id: car.id,
                image: getImageUrl(car.main_image) || APP_IMAGES.CAR_PLACEHOLDER,
                brand: car.brand?.name ?? "",
                name: car.name ?? "",
                year: String(car.year ?? ""),
                price: formatPrice(car.current_price || car.cash_price, "var(--brand-primary-color)"),
                monthlyPrice: formatPrice(car.min_installment ?? 0, "var(--brand-secondary-color)"),
                detailsTo: `/cars/${car.slug}`,
                badgeText: car.highlight ?? undefined,
            }))
            .filter(Boolean) as CarCardProps[];
    }, [carsResponse, homeData?.latest_cars?.items, homeData?.cars_by_budget?.cars]);

    const sidebarData = useMemo(() => {
        const transmissions = unique(
            allCars.map((c) => c.transmission).filter((v): v is string => Boolean(v)),
        );
        const fuelTypes = unique(
            allCars.map((c) => c.fuelType).filter((v): v is string => Boolean(v)),
        );
        return { transmissions, fuelTypes };
    }, [allCars]);

    const filteredCars = useMemo(() => {
        let result = allCars.slice();

        if (filters.transmission !== "all") {
            result = result.filter(
                (c) => c.transmission === filters.transmission,
            );
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

    const homeOffers: IHomeOfferSlide[] = useMemo(() => {
        const slides = carsMeta?.hero_slides;
        if (!Array.isArray(slides) || slides.length === 0) {
            return [];
        }

        const isArabic = language === "ar";

        return slides
            .filter((slide) => slide.is_active && slide.image)
            .map((slide, index) => ({
                id: slide.car_id ?? index,
                image: slide.image!,
                alt: isArabic ? slide.title_ar : slide.title_en,
                buttonText: isArabic ? slide.button_text_ar : slide.button_text_en,
                buttonTo: slide.link || undefined,
                button2Text: isArabic ? slide.button_2_text_ar : slide.button_2_text_en,
                button2To: slide.link_2 || undefined,
            }));
    }, [carsMeta?.hero_slides, language]);

    return (
        <main>
            <HomeOffersSection
                slides={homeOffers}
                autoPlay
                interval={5000}
                className="!py-0 !my-0 px-[15px] !py-[20px] [&>div]:max-w-none [&>div]:!px-0"
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
                    <AllCarsSearchBar
                        searchValue={filters.search ?? ""}
                        onSearchChange={(v) =>
                            handleFilterChange({ ...filters, search: v })
                        }
                        onSearchSubmit={() =>
                            handleFilterChange({ ...filters })
                        }
                        resultCount={filteredCars.length}
                    />

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
        </main>
    );
}
