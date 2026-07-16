import { useTranslation } from "react-i18next";
import { Trash2 } from "lucide-react";
import { formatPrice } from "../../utils/format";
import { APP_IMAGES, getImageUrl } from "../../constants/app-images";
import type { ICompareCarCardProps } from "../../interfaces/ICompareCarCardProps";

export default function CompareCarCard({
  car,
  onRemove,
}: ICompareCarCardProps) {
  const { t, i18n } = useTranslation();
  const cashPrice = car.current_price ?? car.cash_price ?? 0;
  const monthly = car.min_installment ?? 0;

  return (
    <div dir={i18n.dir()} className="overflow-hidden rounded-2xl border border-[#e5eaf1] bg-white shadow-lg">
      <div className="flex h-[190px] items-center justify-center bg-[#f6f8fb] p-6">
        <img
          src={getImageUrl(car.main_image) || APP_IMAGES.CAR_PLACEHOLDER}
          alt={car.name}
          className="h-full w-full object-contain"
          loading="lazy"
        />
      </div>

      <div className="px-[18px] pb-5 pt-[22px]">
        <div className="mb-6 flex items-center justify-between gap-4">
          <h3 className="m-0 text-base font-extrabold text-[#142b63]">
            {car.brand?.name} {car.name}
          </h3>

          {onRemove && (
            <button
              type="button"
              onClick={onRemove}
              className="inline-flex h-9 cursor-pointer items-center gap-[6px] rounded-[10px] border border-[#ffb9a5] bg-[#fff5f1] px-[14px] text-[13px] text-[#ff5b2e]"
            >
              <Trash2 size={14} />
              {t("comparePage.remove")}
            </button>
          )}
        </div>

        <div className="grid grid-cols-2 gap-[14px]">
          <div className="flex min-h-[78px] flex-col justify-center rounded-[14px] border border-[#ffb9a5] bg-[#fff7f3] p-[14px] text-[#ff5b2e]">
            <span className="mb-[6px] text-[13px]">{t("comparePage.monthlyInstallment")}</span>
            <strong className="text-[22px] font-black leading-none">
              {formatPrice(monthly, "#ff5b2e")}
            </strong>
          </div>

          <div className="flex min-h-[78px] flex-col justify-center rounded-[14px] border border-[#bdcdf1] bg-[#f7f9ff] p-[14px] text-[#0068ff]">
            <span className="mb-[6px] text-[13px]">{t("comparePage.cashPrice")}</span>
            <strong className="text-[22px] font-black leading-none">
              {formatPrice(cashPrice, "#0068ff")}
            </strong>
          </div>
        </div>
      </div>
    </div>
  );
}
