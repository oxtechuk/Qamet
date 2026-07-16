import { useTranslation } from "react-i18next";
import { useNavigate } from "react-router-dom";
import { ArrowUpRight, GitCompare } from "lucide-react";
import { APP_IMAGES } from "../constants/app-images";
import Button from "./button";
import Badge from "./Badge";
import type { ICarCardProps } from "../interfaces/ICarCardProps";
import type { ICarSpecProps } from "../interfaces/ICarSpecProps";

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
  oldPrice,
  price,
  monthlyPrice,
  detailsTo,
  slug,
  compareText,
  reserveText,
  badgeText,
}: ICarCardProps) {
  const { t, i18n } = useTranslation();
  const navigate = useNavigate();

  return (
    <article
      dir={i18n.dir()}
      onClick={() => navigate(detailsTo)}
      className="relative mx-auto w-full max-w-[320px] cursor-pointer overflow-hidden rounded-[24px] border border-[#DCE3EB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
    >
      {badgeText && (
        <Badge size="md" className="-top-3 start-3 rotate-[-12deg]" bgColor="bg-[var(--brand-secondary-color)]">
          <span className="text-[11px] font-normal leading-tight">{t("carCard.model")}</span>
          <span className="text-[15px] font-bold leading-tight">{year}</span>
        </Badge>
      )}

      <div className="relative px-3 pt-5">
        <button
          type="button"
          onClick={(e) => { e.stopPropagation(); navigate(`/compare?slug=${slug ?? ""}`); }}
          className="absolute end-5 top-5 z-10 flex h-[34px] items-center gap-1.5 rounded-full bg-[var(--brand-primary-color)] px-4 text-[13px] font-bold text-white"
        >
          <GitCompare size={15} />
          {compareText ?? t("carCard.compare")}
        </button>

        <div className="flex h-[220px] items-center justify-center">
          <img
            src={image}
            alt={`${brand} ${name}`}
            className="max-h-full w-full object-contain"
            loading="lazy"
          />
        </div>
      </div>

      <div className="px-5 pb-5">
        <div className="pb-5">
          <div className="text-right">
            <h3 className="truncate text-[22px] font-bold leading-none text-[#111827]" title={`${brand} ${name}`}>
              {brand} {name}
            </h3>

            <p className="mt-3 truncate text-[11px] text-[#9CA3AF]">
              {t("carCard.subtitle")}
            </p>
          </div>
        </div>

        <div className="grid grid-cols-4 gap-2 border-y border-[#EEF2F6] py-5 text-center">
          <CarSpec icon={APP_IMAGES.GEARBOX_ICON} label={transmission} />
          <CarSpec icon={APP_IMAGES.CAR_ICON} label={type} />
          <CarSpec icon={APP_IMAGES.FUEL_ICON} label={fuelType} />
          <CarSpec icon={APP_IMAGES.SEAT_ICON} label={seats} />
        </div>

        <div className="mt-5 space-y-3">
          <div className="flex h-[48px] items-center justify-between rounded-[8px] border border-[#C9DAF5] bg-[#F8FBFF] px-4">
            <span className="text-[12px] text-[#6FA7DD]">{t("carCard.cashPrice")}</span>

            <span className="text-[24px] font-bold text-[var(--brand-primary-color)]">
              {price}
            </span>

            <span className={`text-[10px] text-[#9CA3AF] line-through ${!oldPrice ? "invisible" : ""}`}>
              {oldPrice || "0"}
            </span>
          </div>

          <div className="flex h-[48px] items-center justify-between rounded-[8px] border border-[#FFD5BD] bg-[#FFF8F3] px-4">
            <span className="text-[12px] text-[#F59B72]">{t("carCard.monthlyPayment")}</span>

            <span className="text-[24px] font-bold text-[var(--brand-secondary-color)]">
              {monthlyPrice}
            </span>

            <span className="text-[12px] text-[#F59B72]">{t("carCard.estimated")}</span>
          </div>
        </div>

        <div className="mt-8 flex items-center gap-2" onClick={(e) => e.stopPropagation()}>
          <Button
            to={detailsTo}
            bgColor="bg-transparent"
            textColor="text-[var(--brand-secondary-color)]"
            className="group !h-[64px] !w-[58px] !p-0 border border-[var(--brand-secondary-color)] hover:bg-[var(--brand-secondary-color)] text-[var(--brand-secondary-color)] hover:text-white!"
          >
            <ArrowUpRight size={24} className="text-[var(--brand-secondary-color)] group-hover:text-white" />
          </Button>
          <Button
            to={detailsTo}
            className="!h-[64px] flex-1 text-[18px]"
          >
            {reserveText ?? t("carCard.reserve")}
          </Button>
        </div>
      </div>
    </article>
  );
}

function CarSpec({ icon, label }: ICarSpecProps) {
  return (
    <div className="flex flex-col items-center justify-center gap-2">
      <img src={icon} alt={label} loading="lazy" className="h-[18px] w-[18px]" />
      <span className="truncate w-full text-center text-[14px] font-medium leading-none text-[#12439B]">{label}</span>
    </div>
  );
}
