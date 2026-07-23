import { useCallback, useEffect, useRef, useState } from "react";
import { NavLink, useNavigate } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { ChevronDown, Languages, Mail, MapPin, Menu, Phone, Search, X } from "lucide-react";

import { useLanguageStore } from "../store/language.store";
import { useSettingsStore } from "../store/settings.store";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import type { IHomeHeroProps } from "../interfaces/IHomeHeroProps";
import CarFinder from "./CarFinder";
import BrandsCarousel from "./BrandsCarousel";
import SlideArrow from "./SlideArrow";
import LazyImg from "./LazyImg";

const SLIDE_INTERVAL = 5000;

const HERO_ANIMATIONS = `
  @keyframes heroContentIn {
    from {
      opacity: 0;
      transform: translateY(24px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes heroThumbnailIn {
    from {
      opacity: 0;
      transform: scale(0.94);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .hero-content-in {
    animation: heroContentIn 0.7s ease-out both;
  }

  .hero-thumbnail-in {
    animation: heroThumbnailIn 0.55s ease-out both;
  }
`;

export default function HomeHero({
    slides,
    heroVideoUrl,
    filterBrands,
    filterTypes,
    filterCategories,
    filterYears,
    onCarFinderSearch,
    onCarFinderReset,
    carouselBrands = [],
}: IHomeHeroProps) {
    const { t } = useTranslation();
    const navigate = useNavigate();

    const direction = useLanguageStore((state) => state.direction);
    const settings = useSettingsStore((state) => state.settings);

    const isRTL = direction === "rtl";

    const [currentSlide, setCurrentSlide] = useState(0);
    const [menuOpen, setMenuOpen] = useState(false);
    const [animationKey, setAnimationKey] = useState(0);
    const [logoError, setLogoError] = useState(false);
    const [carFinderOpen, setCarFinderOpen] = useState(false);

    const videoRef = useRef<HTMLVideoElement | null>(null);

    const totalSlides = slides.length;
    const current = slides[currentSlide];

    const logoSrc = !logoError
        ? getImageUrl(settings?.logo ?? null) || APP_IMAGES.LOGO
        : APP_IMAGES.LOGO;

    useEffect(() => {
        setLogoError(false);
    }, [settings?.logo]);

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
        if (totalSlides <= 1) return;

        const intervalId = window.setInterval(nextSlide, SLIDE_INTERVAL);

        return () => window.clearInterval(intervalId);
    }, [nextSlide, totalSlides]);

    useEffect(() => {
        setAnimationKey((previous) => previous + 1);
    }, [currentSlide]);

    useEffect(() => {
        document.body.style.overflow = menuOpen ? "hidden" : "";

        return () => {
            document.body.style.overflow = "";
        };
    }, [menuOpen]);

    const navLinks = [
        { label: t("nav.home"), path: "/" },
        { label: t("nav.cars"), path: "/cars" },
        { label: t("nav.offers"), path: "/offers" },
        { label: t("nav.orders"), path: "/orders" },
        { label: t("nav.about"), path: "/about" },
        { label: t("nav.blog"), path: "/blog" },
        { label: t("nav.contact"), path: "/contact" },
    ];

    if (!current || totalSlides === 0) {
        return null;
    }

    return (
        <>
            <style>{HERO_ANIMATIONS}</style>

            <section
                dir={direction}
                className="flex h-screen w-full flex-col overflow-hidden"
            >
                {/* Main framed hero — grows to fill remaining height above the brands strip */}
                <div className="relative min-h-0 flex-1 overflow-hidden rounded-t-[16px] border-[5px] border-white bg-black mx-2 mt-2">
                    {/* Background slider */}
                    <div className="absolute inset-0">
                        {slides.map((slide, index) => {
                            const isActive = index === currentSlide;

                            return (
                                <div
                                    key={slide.id}
                                    className={[
                                        "absolute inset-0 transition-opacity duration-1000 ease-in-out",
                                        isActive
                                            ? "opacity-100"
                                            : "pointer-events-none opacity-0",
                                    ].join(" ")}
                                >
                                    <LazyImg
                                        src={slide.image}
                                        alt={slide.title || ""}
                                        className="h-full w-full object-contain"
                                    />
                                </div>
                            );
                        })}

                        {/* Overlay matching reference */}
                        <div className="absolute inset-0 bg-black/25" />

                        <div className="absolute inset-0 bg-gradient-to-r from-black/15 via-transparent to-black/45 rtl:bg-gradient-to-l" />

                        <div className="absolute inset-x-0 bottom-0 h-[34%] bg-gradient-to-t from-black/45 to-transparent" />
                    </div>

                    {/* Top header */}
                    <header className="absolute inset-x-0 top-0 z-30 px-5 pt-7 sm:px-8 md:px-10 lg:px-12">
                        <div className="relative flex items-start justify-between">
                            {/* Menu button */}
                            <button
                                type="button"
                                onClick={() => setMenuOpen(true)}
                                className={[
                                    "flex h-[42px] min-w-[96px] items-center justify-center gap-2",
                                    "rounded-[12px] bg-white px-4",
                                    "text-[12px] font-bold text-[var(--brand-primary-color)]",
                                    "shadow-[0_8px_24px_rgba(0,0,0,0.14)]",
                                    "transition duration-300 hover:-translate-y-0.5 hover:bg-white/95",
                                    "order-1",
                                ].join(" ")}
                            >
                                <Menu size={18} strokeWidth={2.4} />
                                <span>{t("hero.menu")}</span>
                            </button>

                            {/* Center logo */}
                            <NavLink
                                to="/"
                                aria-label={t("nav.home")}
                                className="absolute left-1/2 top-0 -translate-x-1/2"
                            >
                                <img
                                    src={logoSrc}
                                    alt="Logo"
                                    onError={() => setLogoError(true)}
                                    className="h-[58px] w-auto max-w-[150px] object-contain sm:h-[66px]"
                                />
                            </NavLink>
                        </div>
                    </header>

                    {/* Thumbnail card — always shows the hero video */}
                    {heroVideoUrl ? (
                        <div
                            key={`thumbnail-${animationKey}`}
                            className={[
                                "hero-thumbnail-in absolute z-20 hidden overflow-hidden",
                                isRTL ? "left-[4.3%]" : "right-[4.3%]",
                                "top-[34%]",
                                "h-[168px] w-[220px]",
                                "rounded-[17px] border-[3px] border-white bg-black",
                                "shadow-[0_18px_45px_rgba(0,0,0,0.28)]",
                                "md:block lg:h-[170px] lg:w-[220px]",
                            ].join(" ")}
                        >
                            <video
                                ref={videoRef}
                                src={heroVideoUrl}
                                autoPlay
                                muted
                                loop
                                playsInline
                                preload="metadata"
                                className="h-full w-full object-cover"
                            />
                        </div>
                    ) : null}

                    {/* Hero text */}
                    <div
                        className={[
                            "absolute z-20",
                            "inset-x-5 top-1/2 -translate-y-1/2",
                            "sm:inset-x-8",
                            "md:w-[38%] md:inset-x-auto",
                            isRTL
                                ? "md:right-[5%] lg:right-[6.5%]"
                                : "md:left-[5%] lg:left-[6.5%]",
                        ].join(" ")}
                    >
                        <div
                            className={[
                                "hero-content-in",
                                "text-start flex flex-col items-start",
                                "md:text-start md:items-start",
                            ].join(" ")}
                        >
                            {current.title && (
                                <h1 className="text-[28px] font-extrabold leading-[1.35] text-white sm:text-[34px] md:text-[31px] lg:text-[36px]">
                                    {current.title}
                                </h1>
                            )}

                            {current.subtitle && (
                                <p className="mb-2 text-[13px] font-medium text-white/85 sm:text-[14px]">
                                    {current.subtitle}
                                </p>
                            )}

                            <div
                                className={[
                                    "mt-5 flex flex-col justify-center items-center gap-3",
                                    "sm:flex-row",
                                ].join(" ")}
                            >
                                {current.buttonText && (
                                    <NavLink
                                        to={current.buttonLink || "/cars"}
                                        className={[
                                            "flex min-h-[42px] min-w-[120px] items-center justify-center",
                                            "rounded-[10px] bg-[var(--brand-secondary-color)] px-6",
                                            "text-[13px] font-bold text-[var(--brand-primary-color)]",
                                            "shadow-[0_10px_25px_rgba(0,0,0,0.18)]",
                                            "transition duration-300 hover:-translate-y-0.5 hover:brightness-105",
                                        ].join(" ")}
                                    >
                                        {current.buttonText}
                                    </NavLink>
                                )}

                                {current.button2Text && (
                                    <NavLink
                                        to={current.button2Link || "/finance-calculator"}
                                        className={[
                                            "flex min-h-[42px] min-w-[120px] items-center justify-center",
                                            "rounded-[10px] bg-white px-6",
                                            "text-[13px] font-bold text-[var(--brand-primary-color)]",
                                            "shadow-[0_10px_25px_rgba(0,0,0,0.18)]",
                                            "transition duration-300 hover:-translate-y-0.5 hover:bg-white/95",
                                        ].join(" ")}
                                    >
                                        {current.button2Text}
                                    </NavLink>
                                )}
                            </div>
                        </div>
                    </div>

                    {/* Search bar */}
                    <div className="absolute inset-x-4 bottom-[18%] z-20 sm:inset-x-8 md:bottom-[19%]">
                        <div
                            onClick={() => setCarFinderOpen(true)}
                            className={[
                                "mx-auto flex h-[44px] w-full max-w-[390px] items-center cursor-pointer",
                                "rounded-[11px] border-[2px] border-white bg-[#202226]/90",
                                "p-[3px] shadow-[0_12px_35px_rgba(0,0,0,0.28)]",
                                "backdrop-blur-md",
                            ].join(" ")}
                        >
                            <button
                                type="submit"
                                aria-label={t("hero.searchPlaceholder")}
                                className={[
                                    "flex h-[34px] w-[34px] shrink-0 items-center justify-center",
                                    "rounded-[9px] bg-white",
                                    "text-[var(--brand-primary-color)]",
                                    "transition hover:bg-white/90",
                                ].join(" ")}
                            >
                                <Search size={20} strokeWidth={2.2} />
                            </button>

                            <input
                                type="text"
                                readOnly
                                placeholder={t("hero.searchPlaceholder")}
                                className={[
                                    "min-w-0 flex-1 bg-transparent px-3",
                                    "text-center text-[12px] text-white",
                                    "placeholder:text-white/85",
                                    "outline-none cursor-pointer",
                                    isRTL ? "text-right" : "text-left",
                                ].join(" ")}
                            />

                            <button
                                type="button"
                                onClick={(e) => {
                                    e.stopPropagation();
                                    navigate("/cars");
                                }}
                                aria-label={t("hero.filter")}
                                className={[
                                    "flex h-[34px] w-[34px] shrink-0 items-center justify-center",
                                    "rounded-[9px] bg-white",
                                    "text-[var(--brand-primary-color)]",
                                    "transition hover:bg-white/90",
                                ].join(" ")}
                            >
                                <ChevronDown size={21} strokeWidth={2.4} />
                            </button>
                        </div>
                    </div>

                    {/* Bottom arrows */}
                    {totalSlides > 1 && (
                        <>
                            <SlideArrow
                                direction="prev"
                                onClick={isRTL ? nextSlide : previousSlide}
                                className="absolute bottom-[6%] left-[4.4%] z-20"
                            />
                            <SlideArrow
                                direction="next"
                                onClick={isRTL ? previousSlide : nextSlide}
                                className="absolute bottom-[6%] right-[4.4%] z-20"
                            />
                        </>
                    )}

                    {/* Pagination */}
                    {totalSlides > 1 && (
                        <div className="absolute inset-x-0 bottom-[8.6%] z-20 flex justify-center">
                            <div className="flex items-center gap-[6px]">
                                {slides.map((slideItem, index) => (
                                    <button
                                        key={slideItem.id}
                                        type="button"
                                        onClick={() => goToSlide(index)}
                                        aria-label={`Go to slide ${index + 1}`}
                                        className={[
                                            "h-[5px] rounded-full transition-all duration-300",
                                            index === currentSlide
                                                ? "w-[66px] bg-[var(--brand-secondary-color)]"
                                                : "w-[24px] bg-white/90 hover:bg-white",
                                        ].join(" ")}
                                    />
                                ))}
                            </div>
                        </div>
                    )}

                    {/* CarFinder panel — overlays the hero from the bottom */}
                    {carFinderOpen && (
                        <>
                            {/* Backdrop over the slides */}
                            <button
                                type="button"
                                aria-label="Close"
                                onClick={() => setCarFinderOpen(false)}
                                className="absolute inset-0 z-30 h-full w-full bg-black/50"
                            />

                            {/* Panel anchored to bottom of hero frame */}
                            <div
                                className="absolute inset-x-0 bottom-0 z-40 overflow-hidden rounded-b-[11px]"
                                style={{
                                    background: "rgba(10, 15, 25, 0.72)",
                                    backdropFilter: "blur(20px)",
                                    WebkitBackdropFilter: "blur(20px)",
                                }}
                            >
                                <div className="relative">
                                    <button
                                        type="button"
                                        aria-label="Close"
                                        onClick={() => setCarFinderOpen(false)}
                                        className={`absolute top-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20 ${isRTL ? "left-4" : "right-4"}`}
                                    >
                                        <X size={20} />
                                    </button>

                                    <CarFinder
                                        filterTitle={t("carFinder.title")}
                                        brands={filterBrands}
                                        types={filterTypes}
                                        categories={filterCategories}
                                        years={filterYears}
                                        onSearch={(values) => {
                                            onCarFinderSearch?.(values);
                                            setCarFinderOpen(false);
                                            const params = new URLSearchParams();
                                            if (values.brandId) params.set("brands[]", values.brandId);
                                            if (values.typeId) params.set("type", values.typeId);
                                            if (values.categoryId) params.set("category_id", values.categoryId);
                                            if (values.year) params.set("year", values.year);
                                            if (values.search) params.set("q", values.search);
                                            navigate(`/cars?${params.toString()}`);
                                        }}
                                        onReset={() => {
                                            onCarFinderReset?.();
                                        }}
                                    />
                                </div>
                            </div>
                        </>
                    )}
                </div>

                {/* Brands carousel — sits at the bottom of the 100vh section */}
                <div className="w-full shrink-0">
                    <BrandsCarousel brands={carouselBrands}  />
                </div>
            </section>

            {/* Menu drawer */}
            {menuOpen && (
                <div className="fixed inset-0 z-[100]">
                    <button
                        type="button"
                        aria-label="Close menu"
                        onClick={() => setMenuOpen(false)}
                        className="absolute inset-0 h-full w-full bg-black/60"
                    />

                    <aside
                        dir={direction}
                        className={`absolute bottom-0 top-0 flex w-[84vw] max-w-[390px] flex-col bg-white text-[#111827] shadow-2xl ${isRTL ? "right-0" : "left-0"}`}
                    >
                        <div className="flex items-center justify-between px-6 py-5">
                            <img
                                src={logoSrc}
                                alt="Logo"
                                onError={() => setLogoError(true)}
                                className="h-14 w-auto object-contain"
                            />

                            <button
                                type="button"
                                onClick={() => setMenuOpen(false)}
                                className="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 transition hover:bg-gray-200"
                            >
                                <X size={20} className="text-[#111827]" />
                            </button>
                        </div>

                        <div className="mx-6 h-px bg-gray-200" />

                        <nav className="flex-1 overflow-y-auto px-5 py-5">
                            {navLinks.map((link) => (
                                <NavLink
                                    key={link.path}
                                    to={link.path}
                                    onClick={() => setMenuOpen(false)}
                                    className={({ isActive }) =>
                                        [
                                            "block rounded-xl px-4 py-3.5 text-right",
                                            "text-[16px] font-semibold transition",
                                            isActive
                                                ? "bg-[var(--brand-primary-color)]/10 text-[var(--brand-primary-color)]"
                                                : "text-gray-600 hover:bg-gray-100 hover:text-[#111827]",
                                        ].join(" ")
                                    }
                                >
                                    {link.label}
                                </NavLink>
                            ))}
                        </nav>

                        <div className="mx-6 h-px bg-gray-200" />

                        <div className="px-5 py-4 flex flex-col gap-1">
                            <span className="flex items-center gap-3 rounded-xl px-4 py-3 text-[15px] font-semibold text-gray-600">
                                <MapPin size={18} strokeWidth={2} className="text-[var(--brand-primary-color)]" />
                                {t("topbar.locationValue")}
                            </span>
                            <button
                                type="button"
                                onClick={() => {
                                    const { language, setLanguage } = useLanguageStore.getState();
                                    setLanguage(language === "en" ? "ar" : "en");
                                    setMenuOpen(false);
                                }}
                                className="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-[15px] font-semibold text-gray-600 transition hover:bg-gray-100 hover:text-[#111827]"
                            >
                                <Languages size={18} strokeWidth={2} className="text-[var(--brand-primary-color)]" />
                                {t("topbar.language")}
                            </button>
                        </div>

                        <div className="mx-6 h-px bg-gray-200" />

                        <div className="space-y-3 px-5 pb-6">
                            {settings?.contact?.phone && (
                                <a
                                    href={`tel:${settings.contact.phone}`}
                                    className="flex items-center justify-end gap-3 rounded-xl bg-gray-100 px-4 py-3 text-sm text-[#111827]"
                                >
                                    <span>{settings.contact.phone}</span>
                                    <Phone
                                        size={17}
                                        className="text-[var(--brand-primary-color)]"
                                    />
                                </a>
                            )}

                            {settings?.contact?.email && (
                                <a
                                    href={`mailto:${settings.contact.email}`}
                                    className="flex items-center justify-end gap-3 rounded-xl bg-gray-100 px-4 py-3 text-sm text-[#111827]"
                                >
                                    <span className="truncate">
                                        {settings.contact.email}
                                    </span>
                                    <Mail
                                        size={17}
                                        className="text-[var(--brand-primary-color)]"
                                    />
                                </a>
                            )}

                        </div>
                    </aside>
                </div>
            )}
        </>
    );
}
