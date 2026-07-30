import { useState, useEffect, useCallback, useMemo } from "react";
import { useTranslation } from "react-i18next";

import Button from "./button";
import CarCard from "./CarCard";
import SlideArrow from "./SlideArrow";
import type { IFeaturedCarsSectionProps } from "../interfaces/IFeaturedCarsSectionProps";

function getItemsPerPage(width: number): number {
    if (width >= 1024) return 4;
    if (width >= 640) return 2;
    return 1;
}

export default function FeaturedCarsSection({
    titleBlue,
    buttonText,
    buttonTo,
    cars,
    backgroundImage,
    className = "",
    itemsPerPage: controlledItemsPerPage,
    emptyMessage,
}: IFeaturedCarsSectionProps) {
    const [currentSlide, setCurrentSlide] = useState(0);
    const [isPaused, setIsPaused] = useState(false);
    const [itemsPerPage, setItemsPerPage] = useState(
        () => controlledItemsPerPage ?? getItemsPerPage(window.innerWidth),
    );
    const { i18n } = useTranslation();
    const isRTL = i18n.dir() === "rtl";

    useEffect(() => {
        if (controlledItemsPerPage != null) {
            setItemsPerPage(controlledItemsPerPage);
            setCurrentSlide(0);
            return;
        }
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
    }, [controlledItemsPerPage]);

    const slideGap = 28;

    const slides = useMemo(() => {
        if (!cars.length) return [];
        const result: (typeof cars)[] = [];
        for (let i = 0; i < cars.length; i += itemsPerPage) {
            result.push(cars.slice(i, i + itemsPerPage));
        }
        return result;
    }, [cars, itemsPerPage]);

    const totalSlides = slides.length;
    const cardWidth = `calc((100% - ${slideGap * (itemsPerPage - 1)}px) / ${itemsPerPage})`;

    const hasPrev = currentSlide > 0;
    const hasNext = currentSlide < totalSlides - 1;

    const nextSlide = useCallback(() => {
        setCurrentSlide((prev) => Math.min(prev + 1, totalSlides - 1));
    }, [totalSlides]);

    const prevSlide = useCallback(() => {
        setCurrentSlide((prev) => Math.max(prev - 1, 0));
    }, []);

    useEffect(() => {
        if (isPaused || totalSlides <= 1 || !hasNext) return;

        const id = setInterval(() => {
            setCurrentSlide((prev) => {
                if (prev >= totalSlides - 1) return 0;
                return prev + 1;
            });
        }, 4000);

        return () => clearInterval(id);
    }, [isPaused, totalSlides, hasNext]);

    if (!cars.length) {
        if (emptyMessage) {
            return (
                <section
                    dir={i18n.dir()}
                    className={`relative w-full overflow-hidden py-14 bg-[#F5F5F3] ${className}`}
                >
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div className="flex min-h-[200px] items-center justify-center">
                            <p className="text-lg text-[#6EA9F5]">
                                {emptyMessage}
                            </p>
                        </div>
                    </div>
                </section>
            );
        }
        return null;
    }

    return (
        <section
            dir={i18n.dir()}
            className={`relative w-full overflow-hidden py-14 bg-[#F5F5F3] ${className}`}
            style={
                backgroundImage
                    ? {
                          backgroundImage: `url(${backgroundImage})`,
                          backgroundSize: "cover",
                          backgroundPosition: "center",
                      }
                    : undefined
            }
            onMouseEnter={() => setIsPaused(true)}
            onMouseLeave={() => setIsPaused(false)}
            onFocus={() => setIsPaused(true)}
            onBlur={() => setIsPaused(false)}
        >
            {backgroundImage && (
                <div className="absolute inset-0" />
            )}
            <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="mb-10 flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                    <div className={isRTL ? "text-right" : "text-left"}>
                        <p className="text-[32px] text-[var(--brand-primary-color)] md:text-[32px]">
                            {titleBlue}
                        </p>
                     
                    </div>
                    {totalSlides > 1 && (
                        <div dir="ltr" className="flex items-center justify-center gap-6">

                                <SlideArrow
                                direction="prev"
                                onClick={isRTL ? nextSlide : prevSlide}
                                className={
                                    (isRTL ? !hasNext : !hasPrev)
                                        ? "border-gray-300! bg-gray-100! text-gray-400! hover:bg-gray-100! cursor-not-allowed"
                                        : "border-[#111827]/25! bg-[#111827]/10! text-[#111827]! hover:bg-[#111827]/20!"
                                }
                            />
                            <SlideArrow
                                direction="next"
                                onClick={isRTL ? prevSlide : nextSlide}
                                className={
                                    (isRTL ? !hasPrev : !hasNext)
                                        ? "border-gray-300! bg-gray-100! text-gray-400! hover:bg-gray-100! cursor-not-allowed"
                                        : "border-[#111827]/25! bg-[#111827]/10! text-[#111827]! hover:bg-[#111827]/20!"
                                }
                            />

                        
                        </div>
                    )}
                </div>

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
                                className="flex shrink-0 items-stretch w-full gap-[28px]"
                                dir={isRTL ? "rtl" : "ltr"}
                            >
                                {slide.map((car, cIdx) => (
                                    <div
                                        key={`${car.id}-${sIdx}-${cIdx}`}
                                        className="h-full shrink-0"
                                        style={{ width: cardWidth }}
                                    >
                                        <CarCard {...car} />
                                    </div>
                                ))}
                            </div>
                        ))}
                    </div>
                </div>

                <div className="mt-10 flex justify-center">
                    <Button
                        to={buttonTo}
                        className="w-full px-6 py-2.5 text-[13px] md:w-auto md:px-8 md:py-3 md:text-[15px]"
                    >
                        {buttonText}
                    </Button>
                </div>
            </div>
        </section>
    );
}
