import { useState, useEffect, useCallback, useMemo } from "react";
import { useTranslation } from "react-i18next";
import { useNavigate } from "react-router-dom";
import { Search } from "lucide-react";
import Button from "./button";
import BrandCard from "./BrandCard";
import SlideArrow from "./SlideArrow";
import type {
    IBrandsSectionProps,
    IBrandCategory,
} from "../interfaces/IBrandsSectionProps";

function getItemsPerPage(width: number): number {
    if (width >= 1024) return 5;
    if (width >= 640) return 3;
    return 2;
}

function useDefaultCategories(t: (key: string) => string): IBrandCategory[] {
    return [
        { label: t("brandsSection.categories.0"), value: "all" },
        { label: t("brandsSection.categories.1"), value: "luxury" },
        { label: t("brandsSection.categories.2"), value: "economic" },
        { label: t("brandsSection.categories.3"), value: "electric" },
        { label: t("brandsSection.categories.4"), value: "suv" },
        { label: t("brandsSection.categories.5"), value: "family" },
    ];
}

export default function BrandsSection({
    titleBlue,
    buttonText,
    buttonTo,
    brands,
    categories,
    activeCategory = "all",
    searchPlaceholder,
    onCategoryChange,
    onSearchChange,
}: IBrandsSectionProps) {
    const { t, i18n } = useTranslation();
    const navigate = useNavigate();
    const isRTL = i18n.dir() === "rtl";
    const defaultCategories = useDefaultCategories(t);
    const resolvedCategories = categories ?? defaultCategories;
    const resolvedPlaceholder =
        searchPlaceholder ?? t("brandsSection.searchPlaceholder");

    const [currentSlide, setCurrentSlide] = useState(0);
    const [isPaused, setIsPaused] = useState(false);
    const [itemsPerPage, setItemsPerPage] = useState(() =>
        getItemsPerPage(window.innerWidth),
    );

    useEffect(() => {
        function handleResize() {
            const newCount = getItemsPerPage(window.innerWidth);
            setItemsPerPage((prev) => {
                if (prev !== newCount) {
                    setCurrentSlide(0);
                }
                return newCount;
            });
        }
        window.addEventListener("resize", handleResize);
        return () => window.removeEventListener("resize", handleResize);
    }, []);

    const slideGap = 28;

    const slides = useMemo(() => {
        if (!brands.length) return [];
        const result: (typeof brands)[] = [];
        for (let i = 0; i < brands.length; i += itemsPerPage) {
            result.push(brands.slice(i, i + itemsPerPage));
        }
        return result;
    }, [brands, itemsPerPage]);

    const totalSlides = slides.length;

    const goToSlide = useCallback(
        (index: number) => {
            setCurrentSlide((index + totalSlides) % totalSlides);
        },
        [totalSlides],
    );

    const nextSlide = useCallback(() => {
        goToSlide(currentSlide + 1);
    }, [currentSlide, goToSlide]);

    const prevSlide = useCallback(() => {
        goToSlide(currentSlide - 1);
    }, [currentSlide, goToSlide]);

    useEffect(() => {
        if (isPaused || totalSlides <= 1) return;

        const id = setInterval(() => {
            setCurrentSlide((prev) => (prev + 1) % totalSlides);
        }, 4000);

        return () => clearInterval(id);
    }, [isPaused, totalSlides]);

    return (
        <section
            dir={i18n.dir()}
            className="w-full py-16"
            onMouseEnter={() => setIsPaused(true)}
            onMouseLeave={() => setIsPaused(false)}
        >
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {/* Header */}
                <div className="mb-10 flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                    <div className={isRTL ? "text-right" : "text-left"}>
                        <h2 className="text-[26px] font-bold leading-tight md:text-[26px]">
                            <span className="text-[var(--brand-primary-color)]">
                                {titleBlue}
                            </span>
                        </h2>
                    </div>

                    <Button
                        to={buttonTo}
                        bgColor="bg-white"
                        textColor="text-[var(--brand-primary-color)]"
                        className="
    !h-[44px]
    !w-[150px]
    !rounded-[14px]
    !border
    !border-[var(--brand-primary-color)]
    !shadow-none
    text-[15px]
    font-bold
    transition-all
    duration-300
    hover:!bg-[var(--brand-primary-color)]
    hover:!text-white
  "
                    >
                        {buttonText}
                    </Button>
                </div>

                {/* Brands Carousel */}
                <div className="overflow-hidden">
                    <div
                        className="flex transition-transform duration-300 ease-in-out"
                        style={{
                            transform: `translateX(${isRTL ? "" : "-"}${currentSlide * 100}%)`,
                        }}
                    >
                        {slides.map((slide, sIdx) => (
                            <div
                                key={sIdx}
                                className="flex shrink-0 items-start w-full gap-[28px]"
                            >
                                {slide.map((brand) => (
                                    <div
                                        key={brand.id}
                                        className="shrink-0"
                                        style={{
                                            width: `calc((100% - ${slideGap * (itemsPerPage - 1)}px) / ${itemsPerPage})`,
                                        }}
                                    >
                                        <BrandCard
                                            {...brand}
                                            onClick={() =>
                                                navigate(
                                                    `/cars?search=${encodeURIComponent(brand.name)}`,
                                                )
                                            }
                                        />
                                    </div>
                                ))}
                            </div>
                        ))}
                    </div>
                </div>

                {/* Arrows */}
                {totalSlides > 1 && (
                    <div dir="ltr" className="mt-8 flex items-center justify-start gap-6">
                        <SlideArrow
                            direction="prev"
                            onClick={isRTL ? nextSlide : prevSlide}
                            className="bg-white/80 text-gray-700 backdrop-blur-md hover:bg-white border border-gray-200"
                        />
                        <SlideArrow
                            direction="next"
                            onClick={isRTL ? prevSlide : nextSlide}
                            className="bg-white/80 text-gray-700 backdrop-blur-md hover:bg-white border border-gray-200"
                        />
                    </div>
                )}
            </div>
        </section>
    );
}
