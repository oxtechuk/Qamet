import { useState, useEffect, useCallback, useMemo } from "react";
import { useTranslation } from "react-i18next";
import {
  CarFront,
  Flame,
  Gauge,
  Percent,
  Sparkles,
} from "lucide-react";
import Button from "./button";
import CarCard from "./CarCard";
import SlideArrow from "./SlideArrow";
import type { ICarsShowcaseSectionProps } from "../interfaces/ICarsShowcaseSectionProps";
import type { IFilterItem } from "../interfaces/IFilterItem";

function getItemsPerPage(width: number): number {
  if (width >= 1024) return 4;
  if (width >= 640) return 2;
  return 1;
}

function useFilters(t: (key: string) => string): IFilterItem[] {
  return [
    {
      label: t("carsShowcase.filters.mostRequested"),
      icon: <Flame size={16} />,
      active: true,
    },
    {
      label: t("carsShowcase.filters.readyToDeliver"),
      icon: <CarFront size={16} />,
    },
    { label: t("carsShowcase.filters.noFinancing"), icon: <Gauge size={16} /> },
    { label: t("carsShowcase.filters.newCars"), icon: <Sparkles size={16} /> },
    {
      label: t("carsShowcase.filters.discountedCars"),
      icon: <Percent size={16} />,
    },
  ];
}

export default function CarsShowcaseSection({
  titleBlue,
  titleOrange,
  description,
  buttonText,
  buttonTo,
  cars,
}: ICarsShowcaseSectionProps) {
  const [currentSlide, setCurrentSlide] = useState(0);
  const [isPaused, setIsPaused] = useState(false);
  const [itemsPerPage, setItemsPerPage] = useState(() =>
    getItemsPerPage(window.innerWidth),
  );
  const { t, i18n } = useTranslation();
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
      className="w-full py-14"
      onMouseEnter={() => setIsPaused(true)}
      onMouseLeave={() => setIsPaused(false)}
    >
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-8 flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
          <div className={isRTL ? "text-right" : "text-left"}>
            <h2 className="text-[26px] font-bold leading-tight md:text-[40px]">
              <span className="text-[var(--brand-primary-color)]">
                {titleBlue}
              </span>{" "}
              <span className="text-[var(--brand-secondary-color)]">
                {titleOrange}
              </span>
            </h2>

            <p className="mt-3 max-w-2xl text-[14px] leading-6 text-[#6EA9F5] md:text-[16px] md:leading-7">
              {description}
            </p>
          </div>

          {totalSlides > 1 && (
            <div className="flex items-center justify-center gap-6">
              <SlideArrow
                direction="next"
                onClick={isRTL ? prevSlide : nextSlide}
              />

              <SlideArrow
                direction="prev"
                onClick={isRTL ? nextSlide : prevSlide}
              />
            </div>
          )}
        </div>

        {/* Carousel */}
        <div className="overflow-hidden">
          <div
            className="flex transition-transform duration-300 ease-in-out"
            style={{ transform: `translateX(${isRTL ? "" : "-"}${currentSlide * 100}%)` }}
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

        {/* Button */}
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
