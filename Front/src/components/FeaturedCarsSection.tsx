import { useState, useEffect, useCallback, useMemo } from "react";
import { useTranslation } from "react-i18next";
import { ArrowLeft, ArrowRight } from "lucide-react";

import Button from "./button";
import CarCard from "./CarCard";
import type { IFeaturedCarsSectionProps } from "../interfaces/IFeaturedCarsSectionProps";

function getItemsPerPage(width: number): number {
  if (width >= 1024) return 4;
  if (width >= 640) return 2;
  return 1;
}

export default function FeaturedCarsSection({
  titleBlue,
  titleOrange,
  description,
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
  const [itemsPerPage, setItemsPerPage] = useState(() =>
    controlledItemsPerPage ?? getItemsPerPage(window.innerWidth)
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
    const result: typeof cars[] = [];
    for (let i = 0; i < cars.length; i += itemsPerPage) {
      result.push(cars.slice(i, i + itemsPerPage));
    }
    return result;
  }, [cars, itemsPerPage]);

  const totalSlides = slides.length;
  const cardWidth = `calc((100% - ${slideGap * (itemsPerPage - 1)}px) / ${itemsPerPage})`;

  const goToSlide = useCallback(
    (index: number) => {
      setCurrentSlide((index + totalSlides) % totalSlides);
    },
    [totalSlides]
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

  if (!cars.length) {
    if (emptyMessage) {
      return (
        <section dir={i18n.dir()} className={`relative w-full overflow-hidden bg-[#F0F2F5] py-14 ${className}`}>
          <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div className="flex min-h-[200px] items-center justify-center">
              <p className="text-lg text-[#6EA9F5]">{emptyMessage}</p>
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
        className={`relative w-full overflow-hidden bg-[#F0F2F5] py-14 ${className}`}
        style={backgroundImage ? {
          backgroundImage: `url(${backgroundImage})`,
          backgroundSize: "cover",
          backgroundPosition: "center",
        } : undefined}
        onMouseEnter={() => setIsPaused(true)}
        onMouseLeave={() => setIsPaused(false)}
        onFocus={() => setIsPaused(true)}
        onBlur={() => setIsPaused(false)}
      >
      {backgroundImage && <div className="absolute inset-0 bg-[#010915]/80" />}
      <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mb-10 flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
          <div className={isRTL ? "text-right" : "text-left"}>
            <h2 className="text-[26px] font-bold text-[var(--brand-primary-color)] md:text-[40px]">
              {titleBlue}
              <span className="text-[var(--brand-secondary-color)]">
                {" "}
                {titleOrange}
              </span>
            </h2>

            <p className="mt-3 max-w-xl text-[14px] leading-6 text-[#6EA9F5] md:text-[16px] md:leading-7">
              {description}
            </p>
          </div>

          <Button to={buttonTo} className="w-full px-6 py-2.5 text-[13px] md:w-auto md:px-8 md:py-3 md:text-[15px]">
            {buttonText}
          </Button>
        </div>

          <div className="relative overflow-hidden">
            <div
              className="flex transition-transform duration-300 ease-in-out"
              style={{ transform: `translateX(${isRTL ? "" : "-"}${currentSlide * 100}%)` }}
            >
              {slides.map((slide, sIdx) => (
                <div
                  key={sIdx}
                  className="flex shrink-0 w-full gap-[28px]"
                  dir={isRTL ? "rtl" : "ltr"}
                >
                  {slide.map((car, cIdx) => (
                    <div
                      key={`${car.id}-${sIdx}-${cIdx}`}
                      className="shrink-0"
                      style={{ width: cardWidth }}
                    >
                      <CarCard {...car} />
                    </div>
                  ))}
                </div>
              ))}
            </div>
          </div>

        {totalSlides > 1 && (
          <div className="mt-10 flex items-center justify-center gap-6">
            <button
              type="button"
              onClick={isRTL ? nextSlide : prevSlide}
              className="flex h-[42px] w-[42px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white transition hover:opacity-90"
            >
              {isRTL ? <ArrowRight size={21} /> : <ArrowLeft size={21} />}
            </button>

            <div className="flex items-center gap-2" dir="ltr">
              {Array.from({ length: totalSlides }).map((_, i) => (
                <button
                  key={i}
                  type="button"
                  onClick={() => goToSlide(i)}
                  className={`rounded-full transition-all duration-300 ${
                    i === currentSlide
                      ? "h-[6px] w-[28px] bg-[var(--brand-primary-color)]"
                      : "h-[6px] w-[12px] bg-[#CBD5E1] hover:bg-[#a0b4cc]"
                  }`}
                />
              ))}
            </div>

            <button
              type="button"
              onClick={isRTL ? prevSlide : nextSlide}
              className="flex h-[42px] w-[42px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white transition hover:opacity-90"
            >
              {isRTL ? <ArrowLeft size={21} /> : <ArrowRight size={21} />}
            </button>
          </div>
        )}
      </div>
    </section>
  );
}
