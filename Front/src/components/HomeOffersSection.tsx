import { useCallback, useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import SlideArrow from "./SlideArrow";
import type { IHomeOfferSlide } from "../interfaces/IHomeOfferSlide";
import type { IHomeOffersSectionProps } from "../interfaces/IHomeOffersSectionProps";

export type { IHomeOfferSlide as HomeOfferSlide };

export default function HomeOffersSection({
    slides,
    autoPlay = true,
    interval = 5000,
    className = "",
}: IHomeOffersSectionProps) {
    const { i18n, t } = useTranslation();

    const isRTL = i18n.dir() === "rtl";

    const [currentSlide, setCurrentSlide] = useState(0);
    const [isPaused, setIsPaused] = useState(false);

    const totalSlides = slides.length;
    const activeSlide = slides[currentSlide];

    const goToSlide = useCallback(
        (index: number) => {
            if (!totalSlides) return;

            setCurrentSlide(
                ((index % totalSlides) + totalSlides) % totalSlides,
            );
        },
        [totalSlides],
    );

    const nextSlide = useCallback(() => {
        if (!totalSlides) return;

        setCurrentSlide((previous) => (previous + 1) % totalSlides);
    }, [totalSlides]);

    const previousSlide = useCallback(() => {
        if (!totalSlides) return;

        setCurrentSlide(
            (previous) => (previous - 1 + totalSlides) % totalSlides,
        );
    }, [totalSlides]);

    useEffect(() => {
        if (!autoPlay || isPaused || totalSlides <= 1) {
            return;
        }

        const intervalId = window.setInterval(nextSlide, interval);

        return () => {
            window.clearInterval(intervalId);
        };
    }, [autoPlay, interval, isPaused, nextSlide, totalSlides]);

    if (!activeSlide) {
        return null;
    }

    const handleOfferClick = () => {
        if (!activeSlide.buttonTo) return;

        window.location.href = activeSlide.buttonTo;
    };

    return (
        <section
            dir={i18n.dir()}
            className={`w-full py-4 sm:py-6 my-[50px] ${className}`}
        >
            <div className="mx-auto max-w-[1440px] px-3 sm:px-5 lg:px-8">
                <div
                    className={[
                        "relative overflow-hidden rounded-[18px]",
                        "shadow-[0_8px_24px_rgba(15,23,42,0.08)]",
                    ].join(" ")}
                    onMouseEnter={() => setIsPaused(true)}
                    onMouseLeave={() => setIsPaused(false)}
                >
                    {/* Slides */}
                    <div className="relative aspect-[3.15/1] min-h-[220px] w-full sm:min-h-[280px] lg:min-h-[360px]">
                        {slides.map((slide, index) => (
                            <div
                                key={slide.id}
                                className={[
                                    "absolute inset-0 transition-opacity duration-700 ease-in-out",
                                    index === currentSlide
                                        ? "opacity-100"
                                        : "pointer-events-none opacity-0",
                                ].join(" ")}
                            >
                                <picture>
                                    {slide.mobileImage && (
                                        <source
                                            media="(max-width: 639px)"
                                            srcSet={slide.mobileImage}
                                        />
                                    )}
                                    <img
                                        src={slide.image}
                                        alt={slide.alt ?? ""}
                                        loading={index === 0 ? "eager" : "lazy"}
                                        className="h-full w-full object-cover"
                                    />
                                </picture>

                                <div className="absolute inset-0 bg-black/5" />
                            </div>
                        ))}

                        {/* CTA button above image */}
                        {activeSlide.buttonText && (
                            <button
                                type="button"
                                onClick={handleOfferClick}
                                className={[
                                    "absolute bottom-[8%] z-20",
                                    isRTL ? "right-[4.5%]" : "left-[4.5%]",
                                    "flex min-h-[48px] min-w-[150px] items-center justify-center",
                                    "rounded-[14px]",
                                    "bg-[var(--brand-secondary-color)] px-7",
                                    "text-[15px] font-extrabold",
                                    "text-[var(--brand-primary-color)]",
                                    "shadow-[0_10px_24px_rgba(0,0,0,0.16)]",
                                    "transition duration-300",
                                    "hover:-translate-y-0.5 hover:brightness-105",
                                    "sm:min-h-[54px] sm:min-w-[170px] sm:text-[17px]",
                                ].join(" ")}
                            >
                                {activeSlide.buttonText}
                            </button>
                        )}

                        {/* Navigation arrows */}
                        {totalSlides > 1 && (
                            <div
                                className={[
                                    "absolute bottom-[8%] z-20 flex items-center gap-3",
                                    isRTL ? "left-[4.5%]" : "right-[4.5%]",
                                ].join(" ")}
                            >
                                <SlideArrow
                                    direction="prev"
                                    onClick={isRTL ? previousSlide : nextSlide}
                                    className="h-[46px] w-[46px] rounded-[14px] border-white/45 bg-white/20 shadow-[0_8px_20px_rgba(0,0,0,0.15)] hover:bg-white/30 sm:h-[50px] sm:w-[50px]"
                                />
                                <SlideArrow
                                    direction="next"
                                    onClick={isRTL ? nextSlide : previousSlide}
                                    className="h-[46px] w-[46px] rounded-[14px] border-white/45 bg-white/20 shadow-[0_8px_20px_rgba(0,0,0,0.15)] hover:bg-white/30 sm:h-[50px] sm:w-[50px]"
                                />
                            </div>
                        )}
                    </div>
                </div>

                {/* Pagination — outside the card */}
                {totalSlides > 1 && (
                    <div className="mt-4 flex items-center justify-center gap-[6px]">
                        {slides.map((slide, index) => (
                            <button
                                key={slide.id}
                                type="button"
                                onClick={() => goToSlide(index)}
                                aria-label={`Go to offer ${index + 1}`}
                                className={[
                                    "h-[6px] rounded-full transition-all duration-300",
                                    index === currentSlide
                                        ? "w-[82px] bg-[var(--brand-secondary-color)]"
                                        : "w-[30px] bg-[#D9DDE2] hover:bg-[#BCC3CB]",
                                ].join(" ")}
                            />
                        ))}
                    </div>
                )}
            </div>
        </section>
    );
}
