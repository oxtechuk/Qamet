import { useState, useCallback } from "react";
import { useTranslation } from "react-i18next";
import { ArrowLeft, ShieldCheck } from "lucide-react";
import { SiWhatsapp } from "react-icons/si";
import { getImageUrl } from "../../constants/app-images";
import { formatPrice } from "../../utils/format";
import { useSettingsStore } from "../../store/settings.store";
import type {
    ICarColor,
    ICarDetailsHeroProps,
} from "../../interfaces/ICarDetailsHeroProps";
import SlideArrow from "../SlideArrow";
import LazyImg from "../LazyImg";

export default function CarDetailsHero({
    title,
    description,
    images,
    exteriorImages,
    interiorImages,
    price,
    monthlyInstallment,
    colors,
    orderTo,
}: ICarDetailsHeroProps) {
    const { t, i18n } = useTranslation();
    const settings = useSettingsStore((s) => s.settings);
    const whatsappNumber =
        settings?.contact?.whatsapp?.replace(/\D/g, "") ?? "";
    const whatsappHref = `https://wa.me/${whatsappNumber}`;
    const [activeImage, setActiveImage] = useState(0);
    const [viewType, setViewType] = useState<"inside" | "outside">("inside");
    const [selectedColor, setSelectedColor] = useState<ICarColor | null>(null);

    const currentImages =
        viewType === "inside"
            ? interiorImages?.length
                ? interiorImages.map(getImageUrl)
                : images.map(getImageUrl)
            : exteriorImages?.length
              ? exteriorImages.map(getImageUrl)
              : images.map(getImageUrl);

    const colorImage = selectedColor?.image
        ? getImageUrl(selectedColor.image)
        : null;
    const currentImage = colorImage ?? currentImages[activeImage];
    const isShowingColorImage = !!colorImage;

    const handleViewChange = useCallback((type: "inside" | "outside") => {
        setViewType(type);
        setActiveImage(0);
        setSelectedColor(null);
    }, []);

    return (
        <section dir={i18n.dir()} className="w-full py-10">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 items-start gap-12 lg:grid-cols-2">
                    
                    {/* Gallery */}
                    <CarDetailsGallery
                        title={title}
                        images={currentImages}
                        currentImage={currentImage}
                        activeImage={activeImage}
                        onImageSelect={setActiveImage}
                        isShowingColorImage={isShowingColorImage}
                        selectedColor={selectedColor}
                        onClearColor={() => setSelectedColor(null)}
                        viewType={viewType}
                        onViewChange={handleViewChange}
                    />
                    
                    {/* Content */}
                    <div className="order-1 lg:order-2">
                        <div className="rounded-[20px] border border-[#E5E7EB] bg-white px-5 py-6 shadow-sm">
                            {/* Title */}
                            <h1
                                className="text-start text-[28px] font-extrabold leading-tight text-[#111827] md:text-[36px]"
                            >
                                {title}
                            </h1>
                            <div
                                className="mt-1 text-start text-[14px] leading-6 text-[#6B7280] [&_p]:mb-1 [&_ul]:list-disc [&_ul]:ps-5 [&_ol]:list-decimal [&_ol]:ps-5"
                                dangerouslySetInnerHTML={{ __html: description }}
                            />

                            {/* Cash price card */}
                            <div
                                className="mt-5 rounded-[16px] bg-[#EEF0F2] px-5 py-4 text-start"
                            >
                                <p className="text-[13px] text-[#6B7280]">
                                    {t("carDetails.hero.price")}
                                </p>
                                <p className="mt-1 text-[32px] font-extrabold text-[#111827]">
                                    {formatPrice(price, "#111827")}
                                </p>
                            </div>

                            {/* Monthly installment card */}
                            <div
                                className="mt-3 rounded-[16px] bg-[#F9F5E8] px-5 py-4 text-start"
                            >
                                <p className="text-[13px] text-[#6B7280]">
                                    {t("carDetails.hero.installmentFrom")}
                                </p>
                                <p className="mt-1 text-[32px] font-extrabold text-[#111827]">
                                    {formatPrice(monthlyInstallment, "#111827")}
                                </p>
                            </div>

                            {/* Colors */}
                            {colors.length > 0 && (
                                <div className="mt-4 flex items-center justify-between rounded-[16px] border border-[#E5E7EB] bg-white px-5 py-4">
                                    <div className="flex items-center gap-3">
                                        {colors.map((color) => (
                                            <button
                                                key={color.name}
                                                type="button"
                                                onClick={() =>
                                                    setSelectedColor(
                                                        selectedColor?.name ===
                                                            color.name
                                                            ? null
                                                            : color,
                                                    )
                                                }
                                                aria-label={color.name}
                                                className={`h-[44px] w-[44px] rounded-full border-2 p-[3px] transition ${
                                                    selectedColor?.name ===
                                                    color.name
                                                        ? "border-[var(--brand-primary-color)]"
                                                        : "border-transparent"
                                                }`}
                                            >
                                                <span
                                                    className="block h-full w-full rounded-full border border-black/10"
                                                    style={{
                                                        backgroundColor:
                                                            color.value,
                                                    }}
                                                />
                                            </button>
                                        ))}
                                    </div>
                                    <span
                                        className="text-end text-[14px] font-medium text-[#374151]"
                                    >
                                        {t("carDetails.hero.availableColors")}
                                    </span>
                                </div>
                            )}

                            {/* CTA buttons */}
                            <div className="mt-5 flex flex-col gap-3">
                                <a
                                    href={orderTo}
                                    className="flex h-[56px] w-full items-center justify-center rounded-[16px] bg-[var(--brand-secondary-color)] text-[17px] font-bold text-[var(--brand-primary-color)] transition hover:opacity-90"
                                >
                                    {t("carDetails.hero.orderNow")}
                                </a>

                                <a
                                    href={whatsappHref}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="flex h-[56px] w-full items-center justify-center gap-2 rounded-[16px] bg-[#25D366] text-[17px] font-bold text-white! transition hover:opacity-90"
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
    currentImage: string;
    activeImage: number;
    onImageSelect: (index: number) => void;
    isShowingColorImage: boolean;
    selectedColor: ICarColor | null;
    onClearColor: () => void;
    viewType: "inside" | "outside";
    onViewChange: (type: "inside" | "outside") => void;
}

function CarDetailsGallery({
    title,
    images,
    currentImage,
    activeImage,
    onImageSelect,
    isShowingColorImage,
    selectedColor,
    onClearColor,
    viewType,
    onViewChange,
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
        <div className="order-2 lg:order-1">
            {/* Tabs */}
            <div className="mb-4 grid h-[56px] grid-cols-2 gap-2 rounded-[14px] border border-[#E5E7EB] bg-white p-1.5">
                <button
                    type="button"
                    onClick={() => onViewChange("inside")}
                    className={`rounded-[10px] text-[16px] font-bold transition ${
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
                    className={`rounded-[10px] text-[16px] font-bold transition ${
                        viewType === "outside"
                            ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]"
                            : "text-[#5F6672] hover:bg-[#F5F5F3]"
                    }`}
                >
                    {t("carDetails.hero.outsideView")}
                </button>
            </div>

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

                {/* Color name label */}
                {selectedColor && (
                    <div className="absolute bottom-4 start-1/2 -translate-x-1/2 flex items-center gap-2 rounded-full bg-black/55 px-4 py-1.5 text-sm font-medium text-white backdrop-blur-sm">
                        <span
                            className="h-3 w-3 shrink-0 rounded-full border border-white/40"
                            style={{ backgroundColor: selectedColor.value }}
                        />
                        {selectedColor.name}
                    </div>
                )}

                {isShowingColorImage && (
                    <button
                        type="button"
                        onClick={onClearColor}
                        className="absolute end-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-black/50 text-white transition hover:bg-black/70"
                        aria-label={t("carDetails.hero.backToGallery")}
                    >
                        <ArrowLeft size={16} />
                    </button>
                )}
            </div>

            {/* Thumbnails row with prev/next arrows */}
            {!isShowingColorImage && (
                <div
                    className="mt-4 flex items-center gap-2"
                    dir="ltr"
                >
                    <SlideArrow
                        direction="prev"
                        onClick={handlePrev}
                        className="h-[48px] w-[48px] rounded-[12px]! border-[#000000]! bg-[#ffffff]/50! text-[#000000]! shadow-[0_4px_12px_rgba(0,0,0,0.06)] backdrop-blur-lg transition duration-300 hover:bg-[#E4E7EB]/60!"
                    />

                    {/* 4 thumbnails */}
                    <div className="flex flex-1 justify-center gap-2">
                        {images
                            .slice(0, 4)
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
        </div>
    );
}
