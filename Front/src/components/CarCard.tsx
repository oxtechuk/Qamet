import { useTranslation } from "react-i18next";
import { useNavigate } from "react-router-dom";
import { GitCompare } from "lucide-react";
import { APP_IMAGES } from "../constants/app-images";
import Button from "./button";
import LazyImg from "./LazyImg";
import type { ICarCardProps } from "../interfaces/ICarCardProps";

interface HighlightResult {
    text: string;
    color?: string;
}

function resolveHighlight(value: unknown, locale: string): HighlightResult | undefined {
    if (!value) return undefined;
    if (typeof value === "string") return value ? { text: value } : undefined;
    if (typeof value === "object" && value !== null) {
        const obj = value as Record<string, unknown>;
        const key = locale.startsWith("ar") ? "text_ar" : "text";
        const text = (obj[key] ?? obj.text_ar ?? obj.text ?? "") as string;
        if (!text) return undefined;
        return { text, color: typeof obj.color === "string" ? obj.color : undefined };
    }
    return { text: String(value) };
}

function contrastTextColor(hex?: string): string {
    if (!hex) return "var(--brand-primary-color)";
    const raw = hex.replace("#", "");
    const r = parseInt(raw.substring(0, 2), 16);
    const g = parseInt(raw.substring(2, 4), 16);
    const b = parseInt(raw.substring(4, 6), 16);
    return (r * 0.299 + g * 0.587 + b * 0.114) > 186 ? "#111827" : "#ffffff";
}

export type { ICarCardProps as CarCardProps };

export default function CarCard({
    image,
    brand,
    name,
    year,
    type,
    fuelType,
    transmission,
    seats,
    price,
    monthlyPrice,
    detailsTo,
    slug,
    compareText,
    reserveText,
    badgeText,
    badgeColor,
}: ICarCardProps) {
    const { t, i18n } = useTranslation();
    const navigate = useNavigate();
    const isRTL = i18n.dir() === "rtl";
    const resolvedBadge = resolveHighlight(badgeText, i18n.language);
    const finalBadge = resolvedBadge
        ? { text: resolvedBadge.text, color: badgeColor ?? resolvedBadge.color }
        : undefined;

    return (
        <article
            dir={i18n.dir()}
            onClick={() => navigate(detailsTo)}
            className="relative mx-auto flex h-full w-full max-w-[336px] cursor-pointer flex-col overflow-hidden rounded-[20px] border border-[#E5E9EF] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
        >
            {/* Image */}
            <div className="relative h-[210px] w-full overflow-hidden bg-[#F5F5F3]">
                <LazyImg
                    src={image}
                    alt={`${brand} ${name}`}
                    className="h-full w-full object-cover"
                />

                {/* Badge — top start */}
                {finalBadge && (
                    <div
                        className={[
                            "absolute top-3 z-10",
                            isRTL ? "right-3" : "left-3",
                        ].join(" ")}
                    >
                        <span
                            className="rounded-full px-4 py-1.5 text-[13px] font-semibold"
                            style={{
                                backgroundColor: finalBadge.color ?? "var(--brand-secondary-color)",
                                color: contrastTextColor(finalBadge.color),
                            }}
                        >
                            {finalBadge.text}
                        </span>
                    </div>
                )}

                {/* Compare button — bottom start */}
                <button
                    type="button"
                    onClick={(e) => {
                        e.stopPropagation();
                        navigate(`/compare?slug=${slug ?? ""}`);
                    }}
                    className={[
                        "absolute bottom-3 z-10",
                        isRTL ? "left-3" : "right-3",
                        "flex h-[42px] w-[42px] items-center justify-center",
                        "rounded-[12px] bg-white shadow-md",
                        "text-[var(--brand-primary-color)] transition hover:bg-[#f0f0f0]",
                    ].join(" ")}
                    aria-label={compareText ?? t("carCard.compare")}
                >
                    <GitCompare size={20} strokeWidth={2} />
                </button>
            </div>

            {/* Info */}
            <div className="flex flex-1 flex-col px-4 pb-4 pt-3">
                {/* Name */}
                <h3
                    className="truncate text-start text-[20px] font-semibold leading-snug text-[#111827]"
                    title={`${name}`}
                >
                    {name}
                </h3>

                {/* Year · Type */}
                <p className="mt-1 text-start text-[13px] text-[#6B7280]">
                    {year}
                    {type ? <> &nbsp;·&nbsp; {type}</> : null}
                </p>

                {/* Specs row */}
                <div className="mt-3 flex items-center justify-start gap-4 border-b border-[#EEF2F6] pb-3">
                    {fuelType && (
                        <span className="flex items-center gap-1.5 text-[13px] text-[#374151]">
                            <LazyImg
                                src={APP_IMAGES.FUEL_ICON}
                                alt="fuel"
                                className="h-4 w-4"
                            />
                            {fuelType}
                        </span>
                    )}
                    {transmission && (
                        <span className="flex items-center gap-1.5 text-[13px] text-[#374151]">
                            <LazyImg
                                src={APP_IMAGES.GEARBOX_ICON}
                                alt="transmission"
                                className="h-4 w-4"
                            />
                            {transmission}
                        </span>
                    )}
                    {seats && (
                        <span className="flex items-center gap-1.5 text-[13px] text-[#374151]">
                            <LazyImg
                                src={APP_IMAGES.SEAT_ICON}
                                alt="seats"
                                className="h-4 w-4"
                            />
                            {seats}
                        </span>
                    )}
                </div>

                {/* Price row */}
                <div className="mt-auto flex items-center justify-between pt-3">
                    <div className="text-start">
                        <p className="text-[22px] font-bold leading-none text-[#111827]">
                            {price}
                        </p>
                        <p className="mt-1 text-[12px] text-[var(--brand-secondary-color)]">
                            {t("carCard.startsFrom")} {monthlyPrice}
                        </p>
                    </div>
                    <div onClick={(e) => e.stopPropagation()}>
                        <Button
                            to={detailsTo}
                            bgColor="bg-[var(--brand-secondary-color)]"
                            className="!h-[40px] min-w-[96px] px-5 text-[14px] font-semibold"
                        >
                            {reserveText ?? t("carCard.details")}
                        </Button>
                    </div>
                </div>
            </div>
        </article>
    );
}
