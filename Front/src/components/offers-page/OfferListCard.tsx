import { useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import { Clock } from "lucide-react";
import { NavLink } from "react-router-dom";
import { formatPrice } from "../../utils/format";
import { getCountdownParts, padTime } from "../../utils/countdown";
import type { IOfferListCardProps } from "../../interfaces/IOfferListCardProps";
import LazyImg from "../LazyImg";

function contrastTextColor(hex?: string): string {
    if (!hex) return "#ffffff";
    const raw = hex.replace("#", "");
    const r = parseInt(raw.substring(0, 2), 16);
    const g = parseInt(raw.substring(2, 4), 16);
    const b = parseInt(raw.substring(4, 6), 16);
    return (r * 0.299 + g * 0.587 + b * 0.114) > 186 ? "#111827" : "#ffffff";
}

export default function OfferListCard({
  image,
  badge,
  badgeColor,
  title,
  description,
  carName,
  priceLabel,
  price,
  expiresAt,
  isExpired,
  buttonText,
  buttonTo,
}: IOfferListCardProps) {
  const { t, i18n } = useTranslation();
  const target = expiresAt ? new Date(expiresAt) : null;
  const [countdown, setCountdown] = useState(() =>
    target
      ? getCountdownParts(target)
      : { days: 0, hours: 0, minutes: 0, seconds: 0 },
  );

  useEffect(() => {
    if (!target) return;
    const id = setInterval(() => setCountdown(getCountdownParts(target)), 1000);
    return () => clearInterval(id);
  }, [target]);

  const showCountdown = !isExpired && target != null;

  return (
    <article
      dir={i18n.dir()}
      className="overflow-hidden rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
    >
      {/* Image */}
      <div className="relative h-[210px] w-full overflow-hidden">
        <LazyImg
          src={image}
          alt={title}
          className="h-full w-full object-cover"
        />

        {/* Badge top-start */}
        {badge && (
          <div
            className="absolute start-3 top-3 rounded-full px-4 py-1.5 text-[12px] font-semibold"
            style={{
              backgroundColor: badgeColor ?? "var(--brand-primary-color)",
              color: badgeColor ? contrastTextColor(badgeColor) : "#ffffff",
            }}
          >
            {badge}
          </div>
        )}

        {/* Countdown bottom-start */}
        {showCountdown && (
          <div className="absolute bottom-3 end-3 flex items-center gap-1.5 rounded-full bg-[var(--brand-secondary-color)]/90 px-3 py-1.5 text-[12px] font-[700] font-sans text-[var(--brand-primary-color)]">
            <Clock size={13} />
            <span dir="ltr">
              {padTime(countdown.hours)}:{padTime(countdown.minutes)}:
              {padTime(countdown.seconds)}
              {countdown.days > 0 && (
                <>
                  {"\u200E"}{" "}
                  {t("offersPage.hero.countdownDays")}
                  {"\u200E"} {countdown.days}
                </>
              )}
            </span>
          </div>
        )}
      </div>

      {/* Body */}
      <div className="px-4 pb-4 pt-4">
        <h3 className="px-2 py-1 text-[18px] font-extrabold leading-snug text-[var(--brand-primary-color)]">
          {title}
        </h3>

        {/* Description */}
        <div
          className="mt-2 text-[#6B7280] [&_p]:m-0"
          dangerouslySetInnerHTML={{ __html: description }}
        />

        {/* Car name */}
        {carName && (
          <p className="mt-1 text-[13px] font-semibold text-[#374151]">
            {carName}
          </p>
        )}

        {/* Separator */}
        <div className="my-3 border-t border-[#F0F2F5]" />

        {/* Price + Button */}
        <div className="flex items-center justify-between gap-3">
          <div className="text-start">
            <p className="text-[12px] text-[#6B7280]">{priceLabel}</p>
            <p className="text-[22px] font-extrabold text-[var(--brand-secondary-color)]">
              {formatPrice(price, "var(--brand-secondary-color)")}
            </p>
          </div>

          <NavLink
            to={buttonTo}
            className="flex h-[44px] min-w-[100px] items-center justify-center rounded-[16px] bg-[var(--brand-primary-color)] px-5 text-[14px] font-bold text-white! transition hover:opacity-90"
          >
            {buttonText}
          </NavLink>
        </div>
      </div>
    </article>
  );
}
