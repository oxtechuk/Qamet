import { useTranslation } from "react-i18next";
import { ArrowLeft, ArrowRight } from "lucide-react";
import { NavLink } from "react-router-dom";
import { formatPrice } from "../../utils/format";
import type { IOfferListCardProps } from "../../interfaces/IOfferListCardProps";

export default function OfferListCard({
  image,
  title,
  description,
  priceLabel,
  price,
  priceUnit,
  buttonText,
  buttonTo,
}: IOfferListCardProps) {
  const { i18n, t } = useTranslation();
  const isRtl = i18n.dir() === "rtl";
  const ArrowIcon = !isRtl ? ArrowRight : ArrowLeft;
  const unit = priceUnit || t("offersPage.grid.card.priceUnit");

  return (
    <article dir={i18n.dir()} className="w-full">
      <div className="overflow-hidden rounded-t-[14px]">
        <img
          src={image}
          alt={title}
          className="h-[190px] w-full object-cover"
          loading="lazy"
        />
      </div>

      <div className="pt-5">
        <h3 className="text-[22px] font-extrabold leading-[1.5] text-[#07111F]">
          {title}
        </h3>

        <p className="mt-3 text-[15px] leading-7 text-[#6B7280]">
          {description}
        </p>

        <div className="mt-5 flex items-center justify-between gap-4">
          <div className={isRtl ? "text-left" : "text-right"}>
            <p className="text-[13px] text-[#8A8F99]">{priceLabel}</p>

            <div className="mt-1 flex items-center gap-1 text-[13px] text-[#8A8F99]">
              <strong className="text-[20px] font-extrabold text-[var(--brand-secondary-color)]">
                {formatPrice(price, "var(--brand-secondary-color)")}
              </strong>
              <span>{unit}</span>
            </div>
          </div>

          <NavLink
            to={buttonTo}
            className="inline-flex h-[38px] items-center justify-center gap-2 rounded-full bg-white px-5 text-[14px] font-bold text-[#07111F] transition hover:bg-[var(--brand-primary-color)] hover:text-white!"
          >
            {buttonText}
            <ArrowIcon size={16} />
          </NavLink>
        </div>
      </div>
    </article>
  );
}
