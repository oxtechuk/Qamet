import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import { useTranslation } from "react-i18next";

import CarCard from "./CarCard";
import SlideArrow from "./SlideArrow";
import BudgetCarsRangeFilters from "./BudgetCarsRangeFilters";
import type { IBudgetCarsSectionProps } from "../interfaces/IBudgetCarsSectionProps";
import type { IBudgetRange } from "../interfaces/IBudgetRange";
import { useLanguageStore } from "../store/language.store";

const GAP = 28;

function getVisible(width: number): number {
    if (width >= 1024) return 3;
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
    description,
    cars,
    ranges,
    activeRange = "3000-4000",
    onRangeChange,
}: IBudgetCarsSectionProps) {
    const { t } = useTranslation();
    const { direction } = useLanguageStore();
    const isRTL = direction === "rtl";

    const [mobileContainer, setMobileContainer] = useState<HTMLDivElement | null>(null);
    const [desktopContainer, setDesktopContainer] = useState<HTMLDivElement | null>(null);
    const [containerWidth, setContainerWidth] = useState(0);
    const [visible, setVisible] = useState(() => getVisible(window.innerWidth));

    useEffect(() => {
        const activeEl = mobileContainer || desktopContainer;
        if (!activeEl) return;

        const ro = new ResizeObserver((entries) => {
            const w = entries[0]?.contentRect.width ?? 0;
            if (w > 0) setContainerWidth(w);
            setVisible(getVisible(window.innerWidth));
        });
        ro.observe(activeEl);

        if (activeEl.offsetWidth > 0) setContainerWidth(activeEl.offsetWidth);

        return () => {
            ro.disconnect();
        };
    }, [mobileContainer, desktopContainer]);

    useEffect(() => {
        const onResize = () => setVisible(getVisible(window.innerWidth));
        window.addEventListener("resize", onResize);
        return () => window.removeEventListener("resize", onResize);
    }, []);

    const defaultRanges = useDefaultRanges(t);
    const resolvedRanges = ranges ?? defaultRanges;

    const n = cars.length;
    // Use a fallback so cards render immediately before ResizeObserver fires
    const effectiveWidth = containerWidth > 0 ? containerWidth : 800;
    const cardWidth = (effectiveWidth - GAP * (visible - 1)) / visible;
    const step = cardWidth + GAP;
    const canLoop = n > visible;

    const track = useMemo(() => {
        if (n === 0) return [];
        if (!canLoop) return cars;
        const prefix = cars.slice(n - visible);
        const suffix = cars.slice(0, visible);
        return [...prefix, ...cars, ...suffix];
    }, [cars, visible, n, canLoop]);

    const [idx, setIdx] = useState(0);
    const [animated, setAnimated] = useState(false);
    const [isPaused, setIsPaused] = useState(false);
    const jumping = useRef(false);

    useEffect(() => {
        jumping.current = false;
        setAnimated(false);
        setIdx(canLoop ? visible : 0);
    }, [cars, visible, canLoop]);

    const silentJump = useCallback((to: number) => {
        jumping.current = true;
        setAnimated(false);
        setIdx(to);
        requestAnimationFrame(() =>
            requestAnimationFrame(() => {
                setAnimated(true);
                jumping.current = false;
            }),
        );
    }, []);

    const next = useCallback(() => {
        if (jumping.current) return;
        setAnimated(true);
        setIdx((p) => p + 1);
    }, []);

    const prev = useCallback(() => {
        if (jumping.current) return;
        setAnimated(true);
        setIdx((p) => p - 1);
    }, []);

    const onTransitionEnd = useCallback(() => {
        if (!canLoop) return;
        if (idx >= n + visible) silentJump(idx - n);
        else if (idx < visible) silentJump(idx + n);
    }, [idx, n, visible, canLoop, silentJump]);

    useEffect(() => {
        if (isPaused || !canLoop) return;
        const id = setInterval(next, 4000);
        return () => clearInterval(id);
    }, [isPaused, canLoop, next]);

    if (!cars.length) return null;

    const translateX = isRTL ? step * idx : -(step * idx);

    return (
        <section className="w-full bg-[var(--brand-primary-color)] py-14 text-white sm:py-16 lg:overflow-hidden lg:min-h-[560px] lg:py-[68px]">
            <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
                {/* Mobile: filters above cards */}
                <div className="mb-6 lg:hidden">
                    <div className={isRTL ? "text-right" : "text-left"}>
                        <h2 className="text-[30px] font-extrabold leading-[1.35] text-white">
                            <span>{titleBlue}</span>
                        </h2>
                        <p className="mt-4 max-w-[430px] text-[13px] leading-7 text-white/70">
                            {description}
                        </p>
                        <BudgetCarsRangeFilters
                            ranges={resolvedRanges}
                            activeRange={activeRange}
                            onRangeChange={onRangeChange}
                        />
                    </div>
                </div>

                {/* Desktop: side-by-side layout */}
                <div
                    dir="ltr"
                    className="hidden lg:grid lg:grid-cols-[minmax(0,1.75fr)_minmax(330px,0.75fr)] lg:items-center lg:gap-16"
                >
                    <div
                        className="min-w-0"
                        onMouseEnter={() => setIsPaused(true)}
                        onMouseLeave={() => setIsPaused(false)}
                    >
                        <div ref={setDesktopContainer} className="overflow-hidden">
                            <div
                                className="flex"
                                style={{
                                    gap: `${GAP}px`,
                                    transform: `translateX(${translateX}px)`,
                                    transition: animated
                                        ? "transform 300ms ease-in-out"
                                        : "none",
                                }}
                                onTransitionEnd={onTransitionEnd}
                            >
                                {track.map((car, i) => (
                                    <div
                                        key={`desktop-${car.id}-${i}`}
                                        dir={isRTL ? "rtl" : "ltr"}
                                        style={{ width: `${cardWidth}px`, flexShrink: 0 }}
                                    >
                                        <CarCard {...car} />
                                    </div>
                                ))}
                            </div>
                        </div>

                        {canLoop && (
                            <div className="mt-10 flex items-center justify-center gap-6">
                                <SlideArrow
                                    direction="next"
                                    onClick={isRTL ? prev : next}
                                    className="h-[44px] w-[44px]"
                                />
                                <SlideArrow
                                    direction="prev"
                                    onClick={isRTL ? next : prev}
                                    className="h-[44px] w-[44px]"
                                />
                            </div>
                        )}
                    </div>

                    <div
                        className={[
                            "w-full",
                            isRTL ? "text-right" : "text-left",
                        ].join(" ")}
                    >
                        <h2 className="text-[30px] font-extrabold leading-[1.35] text-white sm:text-[36px] lg:text-[38px]">
                            <span>{titleBlue}</span>
                        </h2>
                        <p className="mt-4 max-w-[430px] text-[13px] leading-7 text-white/70 sm:text-[14px]">
                            {description}
                        </p>
                        <BudgetCarsRangeFilters
                            ranges={resolvedRanges}
                            activeRange={activeRange}
                            onRangeChange={onRangeChange}
                        />
                    </div>
                </div>

                {/* Mobile: cards carousel */}
                <div
                    ref={setMobileContainer}
                    className="overflow-hidden lg:hidden"
                    onMouseEnter={() => setIsPaused(true)}
                    onMouseLeave={() => setIsPaused(false)}
                >
                    <div
                        className="flex"
                        style={{
                            gap: `${GAP}px`,
                            transform: `translateX(${translateX}px)`,
                            transition: animated
                                ? "transform 300ms ease-in-out"
                                : "none",
                        }}
                        onTransitionEnd={onTransitionEnd}
                    >
                        {track.map((car, i) => (
                            <div
                                key={`mobile-${car.id}-${i}`}
                                dir={isRTL ? "rtl" : "ltr"}
                                style={{ width: `${cardWidth}px`, flexShrink: 0 }}
                            >
                                <CarCard {...car} />
                            </div>
                        ))}
                    </div>

                    {canLoop && (
                        <div className="mt-10 flex items-center justify-center gap-6">
                            <SlideArrow
                                direction="next"
                                onClick={isRTL ? prev : next}
                                className="h-[44px] w-[44px]"
                            />
                            <SlideArrow
                                direction="prev"
                                onClick={isRTL ? next : prev}
                                className="h-[44px] w-[44px]"
                            />
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
}
