import { useTranslation } from "react-i18next";
import { X } from "lucide-react";
import { formatPrice } from "../../utils/format";
import { APP_IMAGES, getImageUrl } from "../../constants/app-images";
import type { ICompareCarCardProps } from "../../interfaces/ICompareCarCardProps";
import LazyImg from "../LazyImg";

export default function CompareCarCard({
    car,
    label,
    onRemove,
}: ICompareCarCardProps) {
    const { t, i18n } = useTranslation();
    const cashPrice = car.current_price ?? car.cash_price ?? 0;

    return (
        <div
            dir={i18n.dir()}
            className="overflow-hidden rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm"
        >
            {/* Image */}
            <div className="relative h-[220px] w-full overflow-hidden bg-[#F5F5F3]">
                <LazyImg
                    src={
                        getImageUrl(car.main_image) ||
                        APP_IMAGES.CAR_PLACEHOLDER
                    }
                    alt={car.name}
                    className="h-full w-full object-cover"
                />

                {/* Label badge — top start */}
                {label && (
                    <div className="absolute start-3 top-3 rounded-full bg-[var(--brand-secondary-color)] px-4 py-1.5 text-[13px] font-semibold text-[var(--brand-primary-color)]">
                        {label}
                    </div>
                )}

                {/* Remove button — bottom start */}
                {onRemove && (
                    <button
                        type="button"
                        onClick={onRemove}
                        className="absolute bottom-3 end-3 flex h-[36px] w-[36px] items-center justify-center rounded-full bg-white shadow-md text-[#374151] transition hover:bg-[#F5F5F3]"
                        aria-label={t("comparePage.remove")}
                    >
                        <X size={16} strokeWidth={2.5} />
                    </button>
                )}
            </div>

            {/* Info */}
            <div className="flex items-end justify-between px-4 pb-4 pt-3" dir={i18n.dir()}>
                <div>
                    <p className="text-[13px] text-[#6B7280]">
                        {car.brand?.name}
                    </p>
                    <h3 className="mt-0.5 text-[18px] font-extrabold text-[#021F38]">
                        {car.name}
                    </h3>
                </div>
                <p className="text-[18px] font-extrabold text-[#021F38]">
                    {formatPrice(cashPrice, "#021F38")}
                </p>
            </div>
        </div>
    );
}
