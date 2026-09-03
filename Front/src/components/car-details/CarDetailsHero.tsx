import { useState, useCallback, useMemo } from "react";
import { Link } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { ArrowLeft, ShieldCheck, Layers, Check } from "lucide-react";
import { SiWhatsapp } from "react-icons/si";
import { getImageUrl } from "../../constants/app-images";
import { formatPrice } from "../../utils/format";
import { useSettingsStore } from "../../store/settings.store";
import type {
    ICarColor,
    ICarDetailsHeroProps,
    ICarVariantItem,
} from "../../interfaces/ICarDetailsHeroProps";
import SlideArrow from "../SlideArrow";
import LazyImg from "../LazyImg";

export default function CarDetailsHero({
    title,
    description,
    images,
    exteriorImages,
    interiorImages,
    exteriorColors,
    interiorColors,
    price,
    monthlyInstallment,
    colors,
    orderTo,
    variants,
}: ICarDetailsHeroProps) {
    const { t, i18n } = useTranslation();
    const isRtl = i18n.dir() === "rtl";
    const settings = useSettingsStore((s) => s.settings);
    const whatsappNumber =
        settings?.contact?.whatsapp?.replace(/\D/g, "") ?? "";
    const whatsappHref = `https://wa.me/${whatsappNumber}`;
    const [activeImage, setActiveImage] = useState(0);
    const [viewType, setViewType] = useState<"inside" | "outside">("outside");
    const [selectedExteriorColor, setSelectedExteriorColor] = useState<ICarColor | null>(null);
    const [selectedInteriorColor, setSelectedInteriorColor] = useState<ICarColor | null>(null);
    const [selectedVariant, setSelectedVariant] = useState<ICarVariantItem | null>(null);

    const selectedColor = viewType === "inside" ? selectedInteriorColor : selectedExteriorColor;

    const availableColors = useMemo(() => {
        if (viewType === "inside") {
            return interiorColors && interiorColors.length > 0 ? interiorColors : [];
        }
        return (exteriorColors && exteriorColors.length > 0) ? exteriorColors : colors;
    }, [viewType, exteriorColors, interiorColors, colors]);

    const currentImages = useMemo(() => {
        // If a variant with an image is active
        if (selectedVariant?.image) {
            return [getImageUrl(selectedVariant.image)];
        }

        const activeColor = viewType === "inside" ? selectedInteriorColor : selectedExteriorColor;

        if (activeColor) {
            const colorImgs = (activeColor.images && activeColor.images.length > 0)
                ? activeColor.images
                : (activeColor.image ? [activeColor.image] : []);

            const validImgs = colorImgs.filter((img) => typeof img === "string" && img.trim() !== "");
            if (validImgs.length > 0) {
                return validImgs.map(getImageUrl);
            }
        }

        if (viewType === "inside") {
            const intImgs = (interiorImages && interiorImages.length > 0)
                ? interiorImages.filter((img) => typeof img === "string" && img.trim() !== "")
                : [];
            if (intImgs.length > 0) {
                return intImgs.map(getImageUrl);
            }
            return images.filter((img) => typeof img === "string" && img.trim() !== "").map(getImageUrl);
        }

        const extImgs = (exteriorImages && exteriorImages.length > 0)
            ? exteriorImages.filter((img) => typeof img === "string" && img.trim() !== "")
            : [];
        if (extImgs.length > 0) {
            return extImgs.map(getImageUrl);
        }

        return images.filter((img) => typeof img === "string" && img.trim() !== "").map(getImageUrl);
    }, [viewType, selectedInteriorColor, selectedExteriorColor, selectedVariant, interiorImages, exteriorImages, images]);

    const activeIndex = activeImage >= currentImages.length ? 0 : activeImage;
    const currentImage = currentImages[activeIndex] || (images[0] ? getImageUrl(images[0]) : "");
    const isShowingColorImage = !!(selectedColor && (selectedColor.images?.length || selectedColor.image));

    const handleViewChange = useCallback((type: "inside" | "outside") => {
        setViewType(type);
        setActiveImage(0);
        setSelectedVariant(null);
    }, []);

    const handleColorClick = (color: ICarColor) => {
        setSelectedVariant(null);
        if (viewType === "inside") {
            if (selectedInteriorColor?.name === color.name) {
                setSelectedInteriorColor(null);
            } else {
                setSelectedInteriorColor(color);
            }
        } else {
            if (selectedExteriorColor?.name === color.name) {
                setSelectedExteriorColor(null);
            } else {
                setSelectedExteriorColor(color);
            }
        }
        setActiveImage(0);
    };

    const handleClearColor = () => {
        if (selectedVariant) {
            setSelectedVariant(null);
        }
        if (viewType === "inside") {
            setSelectedInteriorColor(null);
        } else {
            setSelectedExteriorColor(null);
        }
        setActiveImage(0);
    };

    const handleSelectVariant = (variant: ICarVariantItem) => {
        if (selectedVariant?.id === variant.id) {
            setSelectedVariant(null);
        } else {
            setSelectedVariant(variant);
            if (viewType === "inside") {
                setSelectedInteriorColor(null);
            } else {
                setSelectedExteriorColor(null);
            }
        }
        setActiveImage(0);
    };

    const displayCashPrice = selectedVariant?.cash_price ?? price;
    const displayMonthlyInstallment = selectedVariant?.min_installment ?? monthlyInstallment;

    return (
        <section dir={i18n.dir()} className="w-full py-10">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 items-start gap-12 lg:grid-cols-2">

                    {/* Gallery & Colors & Variants Column */}
                    <CarDetailsGallery
                        title={title}
                        images={currentImages}
                        currentImages={currentImages}
                        currentImage={currentImage}
                        activeImage={activeIndex}
                        onImageSelect={setActiveImage}
                        isShowingColorImage={isShowingColorImage || !!selectedVariant?.image}
                        selectedColor={selectedColor}
                        onClearColor={handleClearColor}
                        viewType={viewType}
                        onViewChange={handleViewChange}
                        availableColors={availableColors}
                        onColorClick={handleColorClick}
                        variants={variants}
                        selectedVariant={selectedVariant}
                        onSelectVariant={handleSelectVariant}
                        isRtl={isRtl}
                    />

                    {/* Content Column */}
                    <div className="order-2 lg:order-2">
                        <div className="rounded-[20px] border border-[#E5E7EB] bg-white px-5 py-6 shadow-sm">
                            {/* Title */}
                            <h1
                                className="text-start text-[28px] font-semibold leading-tight text-[#111827] md:text-[36px]"
                            >
                                {title}
                            </h1>
                            <div
                                className="mt-1 text-start text-[14px] leading-6 text-[#6B7280] [&_p]:mb-1 [&_ul]:list-disc [&_ul]:ps-5 [&_ol]:list-decimal [&_ol]:ps-5"
                                dangerouslySetInnerHTML={{ __html: description }}
                            />

                            {/* Active Variant notification */}
                            {selectedVariant && (
                                <div className="mt-4 flex items-center justify-between rounded-xl bg-amber-50/80 border border-amber-200 px-4 py-2.5 text-xs text-amber-900">
                                    <div className="flex items-center gap-2">
                                        <Layers size={15} className="text-amber-700 shrink-0" />
                                        <span>
                                            {isRtl ? "الفئة المحددة حالياً:" : "Selected variant:"}{" "}
                                            <strong>{selectedVariant.name}</strong>
                                        </span>
                                    </div>
                                    <button
                                        type="button"
                                        onClick={() => setSelectedVariant(null)}
                                        className="font-bold text-amber-700 underline hover:text-amber-900"
                                    >
                                        {isRtl ? "إلغاء التحديد" : "Reset"}
                                    </button>
                                </div>
                            )}

                            {/* Cash price card */}
                            <div
                                className="mt-5 rounded-[16px] bg-[#EEF0F2] px-5 py-4 text-start"
                            >
                                <p className="text-[13px] text-[#6B7280]">
                                    {t("carDetails.hero.price")}
                                </p>
                                <p className="mt-1 text-[32px] font-extrabold text-[#111827]">
                                    {formatPrice(displayCashPrice, "#111827")}
                                </p>
                            </div>

                            {/* Monthly installment card */}
                            <div
                                className="mt-3 flex items-center justify-between rounded-[16px] border border-[#E5E7EB] bg-white px-5 py-4"
                            >
                                <div className="text-start">
                                    <p className="text-[13px] text-[#6B7280]">
                                        {t("carDetails.hero.installment")}
                                    </p>
                                    <p className="mt-0.5 text-[22px] font-bold text-[#07111F]">
                                        {formatPrice(displayMonthlyInstallment, "#07111F")}{" "}
                                        <span className="text-[14px] font-normal text-[#6B7280]">
                                            / {t("carDetails.hero.month")}
                                        </span>
                                    </p>
                                </div>
                                <Link
                                    to="/finance-calculator"
                                    className="flex h-10 items-center justify-center rounded-xl bg-[var(--brand-primary-color)]/10 px-4 text-sm font-semibold text-[var(--brand-primary-color)] transition hover:bg-[var(--brand-primary-color)]/20"
                                >
                                    {t("carDetails.hero.calcFinance") || (isRtl ? "حاسبة التمويل" : "Finance Calculator")}
                                </Link>
                            </div>

                            {/* CTA buttons */}
                            <div className="mt-5 flex flex-col gap-3">
                                <Link
                                    to={orderTo}
                                    className="flex h-[56px] w-full items-center justify-center rounded-[16px] bg-[var(--brand-secondary-color)] text-[17px] text-[var(--brand-primary-color)] transition hover:opacity-90 font-bold"
                                >
                                    {t("carDetails.hero.orderNow")}
                                </Link>

                                <a
                                    href={whatsappHref}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="flex h-[56px] w-full items-center justify-center gap-2 rounded-[16px] bg-[#25D366] text-[17px] text-white! transition hover:opacity-90 font-bold"
                                >
                                    <SiWhatsapp size={22} />
                                    {t("carDetails.hero.whatsappContact")}
                                </a>
                            </div>

                            {/* Separator + warranty badge */}
                            <div className="mt-5 border-t border-[#E5E7EB] pt-4">
                                <div
                                    className="flex items-center justify-start gap-2 text-[13px] text-[#6B7280]"
                                >
                                    <ShieldCheck
                                        size={16}
                                        className="shrink-0 text-[var(--brand-secondary-color)]"
                                    />
                                    <span>
                                        {t("carDetails.hero.warrantyBadge")}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    );
}

/* ---------------- Gallery sub-component ---------------- */

interface ICarDetailsGalleryProps {
    title: string;
    images: string[];
    currentImages: string[];
    currentImage: string;
    activeImage: number;
    onImageSelect: (index: number) => void;
    isShowingColorImage: boolean;
    selectedColor: ICarColor | null;
    onClearColor: () => void;
    viewType: "inside" | "outside";
    onViewChange: (type: "inside" | "outside") => void;
    availableColors: ICarColor[];
    onColorClick: (color: ICarColor) => void;
    variants?: ICarVariantItem[];
    selectedVariant: ICarVariantItem | null;
    onSelectVariant: (variant: ICarVariantItem) => void;
    isRtl: boolean;
}

function CarDetailsGallery({
    title,
    images,
    currentImages,
    currentImage,
    activeImage,
    onImageSelect,
    isShowingColorImage,
    selectedColor,
    onClearColor,
    viewType,
    onViewChange,
    availableColors,
    onColorClick,
    variants,
    selectedVariant,
    onSelectVariant,
    isRtl,
}: ICarDetailsGalleryProps) {
    const { t } = useTranslation();
    const totalImages = images.length;

    const handleNext = () => {
        onImageSelect(activeImage === totalImages - 1 ? 0 : activeImage + 1);
    };

    const handlePrev = () => {
        onImageSelect(activeImage === 0 ? totalImages - 1 : activeImage - 1);
    };

    return (
        <div className="order-1 lg:order-1">
            {/* View switcher tabs (من الداخل / من الخارج) */}
            <div className="mb-4 grid h-[56px] grid-cols-2 gap-2 rounded-[14px] border border-[#E5E7EB] bg-white p-1.5">
                <button
                    type="button"
                    onClick={() => onViewChange("inside")}
                    className={`rounded-[10px] text-[16px] font-semibold transition ${
                        viewType === "inside"
                            ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]"
                            : "text-[#5F6672] hover:bg-[#F5F5F3]"
                    }`}
                >
                    {t("carDetails.hero.insideView")}
                </button>
                <button
                    type="button"
                    onClick={() => onViewChange("outside")}
                    className={`rounded-[10px] text-[16px] font-semibold transition ${
                        viewType === "outside"
                            ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]"
                            : "text-[#5F6672] hover:bg-[#F5F5F3]"
                    }`}
                >
                    {t("carDetails.hero.outsideView")}
                </button>
            </div>

            {/* =======================================================
                مكان الخط الأزرق: أزرار الألوان التي تغير صورة السيارة
            ======================================================= */}
            {availableColors.length > 0 && (
                <div className="mb-4 flex flex-col gap-2 rounded-[16px] border border-[#F3F4F6] bg-[#FAFAFA] p-4 shadow-2xs">
                    <div className="flex items-center justify-between">
                        <span className="text-[14px] font-bold text-[#111827]">
                            {viewType === "inside"
                                ? (isRtl ? "ألوان المقصورة والفرش الداخلي" : "Interior Colors")
                                : (isRtl ? "الألوان الخارجية المتاحة" : "Exterior Colors")}
                        </span>
                        {selectedColor && (
                            <span className="text-xs font-semibold text-[var(--brand-primary-color)]">
                                {selectedColor.name}
                            </span>
                        )}
                    </div>
                    <div className="flex flex-wrap items-center gap-2 pt-1">
                        {availableColors.map((color: ICarColor) => {
                            const isSelected = selectedColor?.name === color.name;
                            return (
                                <button
                                    key={color.name}
                                    type="button"
                                    onClick={() => onColorClick(color)}
                                    title={color.name}
                                    aria-label={color.name}
                                    className={`group relative flex items-center gap-2 rounded-full border px-3 py-1.5 transition-all ${
                                        isSelected
                                            ? "border-[var(--brand-primary-color)] bg-white shadow-sm ring-2 ring-[var(--brand-primary-color)]/30"
                                            : "border-gray-200 bg-white hover:border-gray-300"
                                    }`}
                                >
                                    <span
                                        className="h-5 w-5 rounded-full border border-black/15 shadow-inner"
                                        style={{
                                            backgroundColor: color.value || color.hex || "#ccc",
                                        }}
                                    />
                                    <span className={`text-xs font-medium ${isSelected ? "font-bold text-[var(--brand-primary-color)]" : "text-gray-700"}`}>
                                        {color.name}
                                    </span>
                                    {color.images && color.images.length > 0 && (
                                        <span className="rounded-full bg-gray-100 px-1.5 py-0.5 text-[10px] text-gray-500">
                                            {color.images.length}
                                        </span>
                                    )}
                                </button>
                            );
                        })}
                    </div>
                </div>
            )}

            {/* Main image */}
            <div className="relative overflow-hidden rounded-[18px]">
                <LazyImg
                    src={currentImage}
                    alt={title}
                    className="h-[360px] w-full object-cover md:h-[440px]"
                />

                {/* Color tint overlay when a color is selected but has no dedicated image */}
                {selectedColor && !isShowingColorImage && (
                    <div
                        className="pointer-events-none absolute inset-0 transition-all duration-300"
                        style={{ backgroundColor: selectedColor.value, opacity: 0.18, mixBlendMode: "multiply" }}
                    />
                )}

                {/* Color or Variant name label badge */}
                {(selectedColor || selectedVariant) && (
                    <div className="absolute bottom-4 start-1/2 -translate-x-1/2 flex items-center gap-2 rounded-full bg-black/60 px-4 py-1.5 text-sm font-medium text-white backdrop-blur-sm">
                        {selectedColor && (
                            <span
                                className="h-3 w-3 shrink-0 rounded-full border border-white/40"
                                style={{ backgroundColor: selectedColor.value }}
                            />
                        )}
                        {selectedVariant ? selectedVariant.name : selectedColor?.name}
                    </div>
                )}

                {isShowingColorImage && (
                    <button
                        type="button"
                        onClick={onClearColor}
                        className="absolute end-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-black/50 text-white transition hover:bg-black/70"
                        aria-label={t("carDetails.hero.backToGallery")}
                        title={isRtl ? "العودة للمعرض الرئيسي" : "Back to main gallery"}
                    >
                        <ArrowLeft size={16} />
                    </button>
                )}
            </div>

            {/* Thumbnails row with prev/next arrows */}
            {currentImages.length > 1 && (
                <div
                    className="mt-4 flex items-center gap-2"
                    dir="ltr"
                >
                    <SlideArrow
                        direction="prev"
                        onClick={handlePrev}
                        className="h-[48px] w-[48px] rounded-[12px]! border-[#000000]! bg-[#ffffff]/50! text-[#000000]! shadow-[0_4px_12px_rgba(0,0,0,0.06)] backdrop-blur-lg transition duration-300 hover:bg-[#E4E7EB]/60!"
                    />

                    {/* Thumbnails */}
                    <div className="flex flex-1 justify-center gap-2 overflow-x-auto py-1 scrollbar-none">
                        {currentImages
                            .map((image, index) => (
                                <button
                                    key={index}
                                    type="button"
                                    onClick={() => onImageSelect(index)}
                                    className={`w-[80px] shrink-0 overflow-hidden rounded-[12px] transition ${
                                        activeImage === index
                                            ? "ring-2 ring-[var(--brand-secondary-color)]"
                                            : "opacity-70 hover:opacity-100"
                                    }`}
                                >
                                    <LazyImg
                                        src={image}
                                        alt={`${title} ${index + 1}`}
                                        className="h-[64px] w-full object-cover"
                                    />
                                </button>
                            ))}
                    </div>

                    <SlideArrow
                        direction="next"
                        onClick={handleNext}
                        className="h-[48px] w-[48px] rounded-[12px]! border-[#000000]! bg-[#ffffff]/50! text-[#000000]! shadow-[0_4px_12px_rgba(0,0,0,0.06)] backdrop-blur-lg transition duration-300 hover:bg-[#E4E7EB]/60!"
                    />
                </div>
            )}

            {/* =======================================================
                مكان الخط الأحمر: قائمة الفئات والفروقات المضافة للسيارة
            ======================================================= */}
            {variants && variants.length > 0 && (
                <div className="mt-5 rounded-[18px] border border-[#E5E7EB] bg-white p-4 shadow-sm">
                    <div className="mb-3 flex items-center justify-between border-b border-gray-100 pb-2.5">
                        <div className="flex items-center gap-2">
                            <span className="flex h-6 w-6 items-center justify-center rounded-lg bg-[var(--brand-secondary-color)]/20 text-[var(--brand-primary-color)] font-bold text-xs">
                                {variants.length}
                            </span>
                            <h3 className="text-[15px] font-bold text-[#111827]">
                                {isRtl ? "الفئات والموديلات المتاحة لهذه السيارة" : "Available Car Variants & Trims"}
                            </h3>
                        </div>
                        {selectedVariant && (
                            <button
                                type="button"
                                onClick={() => onSelectVariant(selectedVariant)}
                                className="text-xs font-semibold text-gray-500 hover:text-gray-700"
                            >
                                {isRtl ? "إلغاء التحديد" : "Clear"}
                            </button>
                        )}
                    </div>

                    <div className="flex flex-col gap-2.5">
                        {variants.map((v) => {
                            const isSelected = selectedVariant?.id === v.id;
                            const specsList: Array<{ key: string; value?: string }> = Array.isArray(v.specs)
                                ? v.specs
                                : (v.specs && typeof v.specs === "object"
                                    ? Object.entries(v.specs).map(([key, value]) => ({ key, value: String(value) }))
                                    : []);

                            return (
                                <div
                                    key={v.id}
                                    onClick={() => onSelectVariant(v)}
                                    className={`group flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 rounded-[14px] border p-3 transition-all cursor-pointer ${
                                        isSelected
                                            ? "border-[var(--brand-primary-color)] bg-amber-50/20 shadow-sm ring-1 ring-[var(--brand-primary-color)]/40"
                                            : "border-[#F3F4F6] bg-[#FAFAFA] hover:border-gray-300 hover:bg-white"
                                    }`}
                                >
                                    <div className="flex items-center gap-3">
                                        <div className="relative shrink-0">
                                            {v.image ? (
                                                <img
                                                    src={v.image}
                                                    alt={v.name}
                                                    className="h-12 w-16 rounded-lg object-cover border border-gray-200"
                                                />
                                            ) : (
                                                <div className="flex h-12 w-16 items-center justify-center rounded-lg bg-gray-100 border border-gray-200 text-gray-400">
                                                    <Layers size={18} />
                                                </div>
                                            )}
                                            {isSelected && (
                                                <span className="absolute -top-1.5 -end-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white text-[10px]">
                                                    <Check size={10} />
                                                </span>
                                            )}
                                        </div>

                                        <div>
                                            <div className="flex items-center gap-2">
                                                <h4 className="text-[14px] font-bold text-[#111827] group-hover:text-[var(--brand-primary-color)] transition-colors">
                                                    {v.name}
                                                </h4>
                                                {isSelected && (
                                                    <span className="rounded bg-[var(--brand-primary-color)]/10 px-1.5 py-0.5 text-[10px] font-bold text-[var(--brand-primary-color)]">
                                                        {isRtl ? "محددة" : "Selected"}
                                                    </span>
                                                )}
                                            </div>

                                            {specsList.length > 0 && (
                                                <div className="mt-1 flex flex-wrap gap-1.5 text-[11px] text-gray-500">
                                                    {specsList.slice(0, 3).map((s, idx) => (
                                                        <span
                                                            key={idx}
                                                            className="rounded bg-white border border-gray-200 px-1.5 py-0.5 text-gray-600"
                                                        >
                                                            {s.key}{s.value ? `: ${s.value}` : ""}
                                                        </span>
                                                    ))}
                                                </div>
                                            )}
                                        </div>
                                    </div>

                                    <div className="flex items-center gap-3 self-end sm:self-center">
                                        {v.cash_price && (
                                            <div className="text-end">
                                                <span className="text-[11px] text-gray-400 block">
                                                    {isRtl ? "سعر الكاش" : "Cash"}
                                                </span>
                                                <span className="text-[14px] font-extrabold text-[#111827]">
                                                    {formatPrice(v.cash_price, "#111827")}
                                                </span>
                                            </div>
                                        )}
                                        {v.min_installment && (
                                            <div className="text-end border-s border-gray-200 ps-3">
                                                <span className="text-[11px] text-gray-400 block">
                                                    {isRtl ? "القسط" : "Installment"}
                                                </span>
                                                <span className="text-[13px] font-bold text-[var(--brand-primary-color)]">
                                                    {formatPrice(v.min_installment, "var(--brand-primary-color)")}
                                                </span>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>
            )}
        </div>
    );
}
