import { useCallback, useEffect, useRef, useState } from "react";
import { NavLink, useNavigate } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { ChevronDown, Languages, Mail, MapPin, Menu, Phone, Search, Volume2, VolumeX, X } from "lucide-react";

import { useLanguageStore } from "../store/language.store";
import { useSettingsStore } from "../store/settings.store";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import type { IHomeHeroProps } from "../interfaces/IHomeHeroProps";
import CarFinder from "./CarFinder";
import BrandsCarousel from "./BrandsCarousel";
import SlideArrow from "./SlideArrow";
import LazyImg from "./LazyImg";
import { getLocalizedName } from "../utils/localized-name";

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

function getYoutubeId(url?: string): string | null {
    if (!url || typeof url !== 'string') return null;
    const regExp = /(?:youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|shorts\/)([^#&?]*)/;
    const match = url.match(regExp);
    return (match && match[1] && match[1].length === 11) ? match[1] : null;
}

export default function HomeHero({
    slides,
    heroVideoUrl,
    heroVideoMobileUrl,
    heroVideoYoutube,
    heroVideoYoutubeMobile,
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

    const [isMobile, setIsMobile] = useState(() =>
        typeof window !== "undefined" ? window.innerWidth < 768 : false
    );

    useEffect(() => {
        const handleResize = () => {
            setIsMobile(window.innerWidth < 768);
        };
        window.addEventListener("resize", handleResize);
        return () => window.removeEventListener("resize", handleResize);
    }, []);

    const [currentSlide, setCurrentSlide] = useState(0);
    const [menuOpen, setMenuOpen] = useState(false);
    const [logoError, setLogoError] = useState(false);
    const [carFinderOpen, setCarFinderOpen] = useState(false);
    const [isMuted, setIsMuted] = useState(false);

    const iframeRef = useRef<HTMLIFrameElement>(null);
    const videoRef = useRef<HTMLVideoElement>(null);

    const unmuteAll = useCallback(() => {
        if (iframeRef.current?.contentWindow) {
            iframeRef.current.contentWindow.postMessage(
                JSON.stringify({
                    event: "command",
                    func: "unMute",
                    args: [],
                }),
                "*"
            );
            iframeRef.current.contentWindow.postMessage(
                JSON.stringify({
                    event: "command",
                    func: "setVolume",
                    args: [100],
                }),
                "*"
            );
            iframeRef.current.contentWindow.postMessage(
                JSON.stringify({
                    event: "command",
                    func: "playVideo",
                    args: [],
                }),
                "*"
            );
        }

        if (videoRef.current) {
            videoRef.current.muted = false;
            videoRef.current.volume = 1;
            videoRef.current.play().catch(() => {});
        }
        setIsMuted(false);
    }, []);

    const onIframeLoad = useCallback(() => {
        if (iframeRef.current?.contentWindow) {
            iframeRef.current.contentWindow.postMessage(
                JSON.stringify({
                    event: "command",
                    func: "setPlaybackQuality",
                    args: ["highres"],
                }),
                "*"
            );
            iframeRef.current.contentWindow.postMessage(
                JSON.stringify({
                    event: "command",
                    func: "setPlaybackQualityRange",
                    args: ["hd1080", "highres"],
                }),
                "*"
            );
            // Automatically un-mute and play audio
            unmuteAll();
        }
    }, [unmuteAll]);

    // Ensure audio un-mutes automatically on first user click or touch if browser restricted unmuted autoplay
    useEffect(() => {
        const handleInteraction = () => {
            unmuteAll();
        };

        window.addEventListener("click", handleInteraction, { once: true });
        window.addEventListener("touchstart", handleInteraction, { once: true });
        window.addEventListener("scroll", handleInteraction, { once: true, passive: true });

        return () => {
            window.removeEventListener("click", handleInteraction);
            window.removeEventListener("touchstart", handleInteraction);
            window.removeEventListener("scroll", handleInteraction);
        };
    }, [unmuteAll]);

    // Handle seamless looping without YouTube playlist UI
    useEffect(() => {
        const handleMessage = (e: MessageEvent) => {
            try {
                const data = typeof e.data === "string" ? JSON.parse(e.data) : e.data;
                if (data?.event === "onStateChange" && data?.info === 0) {
                    if (iframeRef.current?.contentWindow) {
                        iframeRef.current.contentWindow.postMessage(
                            JSON.stringify({ event: "command", func: "seekTo", args: [0, true] }),
                            "*"
                        );
                        iframeRef.current.contentWindow.postMessage(
                            JSON.stringify({ event: "command", func: "playVideo", args: [] }),
                            "*"
                        );
                    }
                }
            } catch {
                // Ignore parsing errors
            }
        };

        window.addEventListener("message", handleMessage);
        return () => window.removeEventListener("message", handleMessage);
    }, []);

    const toggleMute = useCallback(() => {
        setIsMuted((prevMuted) => {
            const nextMuted = !prevMuted;

            if (iframeRef.current?.contentWindow) {
                iframeRef.current.contentWindow.postMessage(
                    JSON.stringify({
                        event: "command",
                        func: nextMuted ? "mute" : "unMute",
                        args: [],
                    }),
                    "*"
                );
                if (!nextMuted) {
                    iframeRef.current.contentWindow.postMessage(
                        JSON.stringify({
                            event: "command",
                            func: "setVolume",
                            args: [100],
                        }),
                        "*"
                    );
                }
            }

            if (videoRef.current) {
                videoRef.current.muted = nextMuted;
                if (!nextMuted) {
                    videoRef.current.volume = 1;
                }
            }

            return nextMuted;
        });
    }, []);

    const activeYoutubeUrl = isMobile && heroVideoYoutubeMobile ? heroVideoYoutubeMobile : heroVideoYoutube;
    const activeYoutubeId = getYoutubeId(activeYoutubeUrl) || (isMobile ? getYoutubeId(heroVideoYoutube) : null);

    const activeVideoUrl = isMobile && heroVideoMobileUrl ? heroVideoMobileUrl : (heroVideoUrl || (isMobile ? heroVideoMobileUrl : undefined));

    const totalSlides = slides.length;
    const current = (slides && slides.length > 0) ? slides[currentSlide] : null;

    const logoSrc = !logoError
        ? getImageUrl(settings?.logo_color ?? null) || APP_IMAGES.LOGO
        : APP_IMAGES.LOGO;

    useEffect(() => {
        setLogoError(false);
    }, [settings?.logo_color]);

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
        { label: t("nav.corporate"), path: "/corporate" },
        { label: t("nav.about"), path: "/about" },
        { label: t("nav.blog"), path: "/blog" },
        { label: t("nav.contact"), path: "/contact" },
    ];

    const hasVideo = !!(activeYoutubeId || activeVideoUrl || getYoutubeId(heroVideoYoutube) || heroVideoUrl);

    if (totalSlides === 0 && !hasVideo) {
        return null;
    }

    return (
        <>
            <style>{HERO_ANIMATIONS}</style>

            <section
                dir={direction}
                className="flex min-h-[580px] h-[88vh] max-h-[960px] w-full flex-col overflow-hidden"
            >
                {/* Main framed hero — grows to fill remaining height above the brands strip */}
                <div className="relative min-h-0 flex-1 overflow-hidden rounded-t-[16px] border-[5px] border-white bg-black mx-2 mt-2">
                    {/* Background slider / video */}
                    <div className="absolute inset-0">
                        {activeYoutubeId ? (
                            <div className="absolute inset-0 overflow-hidden bg-black flex items-center justify-center">
                                <iframe
                                    key={activeYoutubeId}
                                    ref={iframeRef}
                                    onLoad={onIframeLoad}
                                    src={`https://www.youtube.com/embed/${activeYoutubeId}?autoplay=1&mute=0&controls=0&modestbranding=1&showinfo=0&rel=0&iv_load_policy=3&disablekb=1&fs=0&playsinline=1&enablejsapi=1&vq=hd1080&origin=${typeof window !== 'undefined' ? window.location.origin : ''}`}
                                    title="YouTube Hero Video Background"
                                    frameBorder="0"
                                    allow="autoplay; encrypted-media"
                                    className="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[100vw] min-w-[177.78vh] h-[56.25vw] min-h-full object-cover pointer-events-none border-0"
                                />
                                <div className="absolute inset-0 z-10 pointer-events-auto bg-transparent" />
                            </div>
                        ) : activeVideoUrl ? (
                            <video
                                key={activeVideoUrl}
                                ref={videoRef}
                                src={activeVideoUrl}
                                autoPlay
                                muted
                                loop
                                playsInline
                                preload="metadata"
                                className="absolute inset-0 h-full w-full object-cover"
                            />
                        ) : (
                            slides.map((slide, index) => {
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
                                            className="h-full w-full object-cover"
                                        />
                                    </div>
                                );
                            })
                        )}
                    </div>

                    {/* Top header */}
                    <header className="absolute inset-x-0 top-0 z-30 px-5 pt-7 sm:px-8 md:px-10 lg:px-12">
                        <div className="relative flex items-start justify-between">
                            {/* Audio Control Widget (Swapped to opposite side) */}
                            {hasVideo && (
                                <button
                                    type="button"
                                    onClick={toggleMute}
                                    aria-label={isMuted ? "تشغيل الصوت" : "كتم الصوت"}
                                    title={isMuted ? "تشغيل الصوت" : "كتم الصوت"}
                                    className={[
                                        "flex h-[42px] items-center justify-center gap-2",
                                        "rounded-[12px] bg-white px-3.5 sm:px-4",
                                        "text-[12px] font-bold text-[var(--brand-primary-color)]",
                                        "shadow-[0_8px_24px_rgba(0,0,0,0.14)]",
                                        "transition duration-300 hover:-translate-y-0.5 active:scale-95 cursor-pointer",
                                        "order-1",
                                    ].join(" ")}
                                >
                                    {isMuted ? (
                                        <>
                                            <VolumeX size={18} className="text-red-500" />
                                            <span className="hidden sm:inline">{t("hero.unmute", { defaultValue: "تشغيل الصوت" })}</span>
                                        </>
                                    ) : (
                                        <>
                                            <Volume2 size={18} className="text-emerald-600 animate-pulse" />
                                            <span className="hidden sm:inline">{t("hero.mute", { defaultValue: "كتم الصوت" })}</span>
                                        </>
                                    )}
                                </button>
                            )}

                            {/* Menu button — hidden on mobile */}
                            <button
                                type="button"
                                onClick={() => setMenuOpen(true)}
                                className={[
                                    "hidden sm:flex h-[42px] min-w-[96px] items-center justify-center gap-2",
                                    "rounded-[12px] bg-white px-4",
                                    "text-[12px] font-bold text-[var(--brand-primary-color)]",
                                    "shadow-[0_8px_24px_rgba(0,0,0,0.14)]",
                                    "transition duration-300 hover:-translate-y-0.5 hover:bg-white/95",
                                ].join(" ")}
                            >
                                <Menu size={18} strokeWidth={2.4} />
                                <span>{t("hero.menu")}</span>
                            </button>

                            {/* Center logo with white filter */}
                            <NavLink
                                to="/"
                                aria-label={t("nav.home")}
                                className="absolute left-1/2 top-0 -translate-x-1/2"
                            >
                                <LazyImg
                                    src={logoSrc}
                                    alt="Logo"
                                    onError={() => setLogoError(true)}
                                    className="h-[58px] w-auto max-w-[150px] object-contain sm:h-[66px] brightness-0 invert drop-shadow-[0_2px_8px_rgba(0,0,0,0.35)]"
                                />
                            </NavLink>
                        </div>
                    </header>



                    {/* Hero text */}
                    {current && (current.title || current.subtitle || current.description || current.buttonText || current.button2Text) ? (
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
                                    <p className="mb-1 text-[13px] font-medium text-white/85 sm:text-[14px]">
                                        {current.subtitle}
                                    </p>
                                )}

                                {current.description && (
                                    <p className="mb-2 text-[12px] text-white/75 sm:text-[13px] line-clamp-3 max-w-[480px]">
                                        {current.description}
                                    </p>
                                )}

                                {(current.buttonText || current.button2Text) && (
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
                                )}
                            </div>
                        </div>
                    ) : null}

                    {/* Search bar */}
                    <div className="absolute inset-x-4 bottom-[5%] z-20 sm:inset-x-8 md:bottom-[6%]">
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
                            <LazyImg
                                src={getImageUrl(settings?.logo ?? null) || APP_IMAGES.LOGO}
                                alt="Logo"
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
                                            "block rounded-xl px-4 py-3.5 text-start",
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
                                {getLocalizedName(settings?.contact?.address, isRTL ? "ar" : "en") || t("topbar.locationValue")}
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
                                    className="flex items-center justify-start gap-3 rounded-xl bg-gray-100 px-4 py-3 text-sm text-[#111827]"
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
                                    className="flex items-center justify-start gap-3 rounded-xl bg-gray-100 px-4 py-3 text-sm text-[#111827]"
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
