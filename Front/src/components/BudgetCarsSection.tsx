import { useState, useEffect, useCallback, useMemo } from "react";
import { useTranslation } from "react-i18next";
import { ArrowLeft, ArrowRight } from "lucide-react";

import Button from "./button";
import CarCard from "./CarCard";
import type {
  IBudgetCarsSectionProps,
  IBudgetRange,
} from "../interfaces/IBudgetCarsSectionProps";

function getItemsPerPage(width: number): number {
  if (width >= 1024) return 4;
  if (width >= 640) return 2;
  return 1;
}

function useDefaultRanges(t: (key: string) => string): IBudgetRange[] {
  return [
    { label: t("budgetCars.ranges.0"), value: "3000-4000" },
    { label: t("budgetCars.ranges.1"), value: "4000-6000" },
    { label: t("budgetCars.ranges.2"), value: "7000-9000" },
    { label: t("budgetCars.ranges.3"), value: "9000-plus" },
  ];
}

export default function BudgetCarsSection({
  titleBlue,
  titleOrange,
  description,
  buttonText,
  buttonTo,
  cars,
  ranges,
  activeRange = "3000-4000",
  onRangeChange,
}: IBudgetCarsSectionProps) {
  const [currentSlide, setCurrentSlide] = useState(0);
  const [isPaused, setIsPaused] = useState(false);
  const [itemsPerPage, setItemsPerPage] = useState(() =>
    getItemsPerPage(window.innerWidth),
  );
  const { t, i18n } = useTranslation();
  const defaultRanges = useDefaultRanges(t);
  const resolvedRanges = ranges ?? defaultRanges;
  const isRTL = i18n.dir() === "rtl";

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
    if (!cars.length) return [];
    const remainder = cars.length % itemsPerPage;
    const padded = remainder === 0 ? cars : [...cars, ...cars.slice(0, itemsPerPage - remainder)];
    const result: typeof cars[] = [];
    for (let i = 0; i < padded.length; i += itemsPerPage) {
      result.push(padded.slice(i, i + itemsPerPage));
    }
    return result;
  }, [cars, itemsPerPage]);

  const totalSlides = slides.length;
  const cardWidth = `calc((100% - ${slideGap * (itemsPerPage - 1)}px) / ${itemsPerPage})`;

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

  if (!cars.length) return null;

  return (
    <section
      dir={i18n.dir()}
      className="w-full bg-[#F0F2F5] py-16"
      onMouseEnter={() => setIsPaused(true)}
      onMouseLeave={() => setIsPaused(false)}
    >
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-10 flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
          <div className={isRTL ? "text-right" : "text-left"}>
            <h2 className="text-[26px] font-bold leading-tight md:text-[40px]">
              <span className="text-[var(--brand-primary-color)]">
                {titleBlue}
              </span>{" "}
              <span className="text-[var(--brand-secondary-color)]">
                {titleOrange}
              </span>
            </h2>

            <p className="mt-4 max-w-2xl text-[14px] leading-6 text-[#5F8FD7] md:text-[16px] md:leading-7">
              {description}
            </p>
          </div>

          <Button
            to={buttonTo}
            bgColor="bg-[var(--brand-primary-color)]"
            className="h-[44px] w-full px-6 py-0 text-[13px] md:h-[52px] md:w-auto md:px-8 md:text-[15px]"
          >
            {buttonText}
          </Button>
        </div>

        {/* Budget Filters */}
        <div className="mb-9 flex flex-wrap items-center justify-center gap-4">
          {resolvedRanges.map((range) => {
            const isActive = range.value === activeRange;

            return (
              <button
                key={range.value}
                type="button"
                onClick={() => onRangeChange?.(range.value)}
                className={`h-[52px] rounded-full border px-8 text-[15px] font-medium transition ${
                  isActive
                    ? "border-[var(--brand-primary-color)] bg-[var(--brand-primary-color)] text-white"
                    : "border-[#C9CED6] bg-transparent text-[#5B6470] hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)]"
                }`}
              >
                {range.label}
              </button>
            );
          })}
        </div>

        {/* Carousel */}
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

        {/* Slider Controls */}
        {totalSlides > 1 && (
          <div className="mt-12 flex items-center justify-center gap-6">
            <button
              type="button"
              onClick={isRTL ? nextSlide : prevSlide}
              className="flex h-[44px] w-[44px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white transition hover:opacity-90"
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
                      : "h-[6px] w-[14px] bg-[#C5C8CC] hover:bg-[#a0b4cc]"
                  }`}
                />
              ))}
            </div>

            <button
              type="button"
              onClick={isRTL ? prevSlide : nextSlide}
              className="flex h-[44px] w-[44px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white transition hover:opacity-90"
            >
              {isRTL ? <ArrowLeft size={21} /> : <ArrowRight size={21} />}
            </button>
          </div>
        )}
      </div>
    </section>
  );
}
