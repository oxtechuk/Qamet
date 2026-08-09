import { useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import { getCountdownParts, padTime } from "../../utils/countdown";
import type { IOffersPageHeroProps } from "../../interfaces/IOffersPageHeroProps";
import LazyImg from "../LazyImg";

function TimeUnit({ value, label }: { value: number; label: string }) {
  return (
    <div className="flex flex-col items-center gap-1">
      <div className="flex h-[56px] w-[56px] items-center justify-center rounded-[12px] bg-[#1a2f48] text-[22px] font-semibold text-white">
        {padTime(value)}
      </div>
      <span className="text-[12px] text-white/60">{label}</span>
    </div>
  );
}

export default function OffersPageHero({
  image,
  badgeText,
  title,
  description,
  carLabel,
  endsAt,
  primaryButtonText,
  primaryButtonTo,
}: IOffersPageHeroProps) {
  const { t, i18n } = useTranslation();
  const target = endsAt ? new Date(endsAt) : null;
  const [timeLeft, setTimeLeft] = useState(() =>
    target
      ? getCountdownParts(target)
      : { days: 0, hours: 0, minutes: 0, seconds: 0 },
  );

  useEffect(() => {
    if (!target) return;
    const id = setInterval(() => setTimeLeft(getCountdownParts(target)), 1000);
    return () => clearInterval(id);
  }, [target]);

  return (
    <section className="w-full py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="relative overflow-hidden rounded-[24px] bg-[#021F38]">
          <div className="flex flex-col-reverse lg:flex-row lg:min-h-[480px]">
            {/* Content */}
            <div
              dir={i18n.dir()}
              className="flex w-full flex-col justify-center px-7 py-10 md:px-10 lg:w-1/2"
            >
              {/* Badge */}
              <div className="mb-5 self-start rounded-full bg-[var(--brand-secondary-color)] px-4 py-1.5 text-[13px] font-semibold text-[var(--brand-primary-color)]">
                {badgeText}
              </div>

              {/* Title */}
              <h1 className="text-[30px] font-bold leading-[1.35] text-white md:text-[36px]">
                {title}
              </h1>

              {/* Subtitle */}
              <p className="mt-2 text-[15px] text-white/60">{description}</p>

              {/* Car label */}
              {carLabel && (
                <p className="mt-4 text-[15px] font-bold text-[var(--brand-secondary-color)]">
                  {carLabel}
                </p>
              )}

              {/* Countdown */}
              {target && (
                <div className="mt-5">
                  <p className="mb-3 text-[13px] text-white/60">
                    {t("offersPage.hero.countdownLabel")}
                  </p>
                  <div className="flex items-end gap-2">
                    <TimeUnit
                      value={timeLeft.days}
                      label={t("offersPage.hero.countdownDays")}
                    />
                    <span className="mt-3 text-[20px] font-bold text-white/40">
                      :
                    </span>
                    <TimeUnit
                      value={timeLeft.hours}
                      label={t("offersPage.hero.countdownHours")}
                    />
                    <span className="mt-3 text-[20px] font-bold text-white/40">
                      :
                    </span>
                    <TimeUnit
                      value={timeLeft.minutes}
                      label={t("offersPage.hero.countdownMinutes")}
                    />
                    <span className="mt-3 text-[20px] font-bold text-white/40">
                      :
                    </span>
                    <TimeUnit
                      value={timeLeft.seconds}
                      label={t("offersPage.hero.countdownSeconds")}
                    />
                  </div>
                </div>
              )}

              {/* CTA */}
              <a
                href={primaryButtonTo}
                className="mt-7 flex h-[52px] w-full items-center justify-center rounded-[16px] bg-[var(--brand-secondary-color)] text-[16px]  text-[var(--brand-primary-color)] transition hover:opacity-90"
              >
                {primaryButtonText}
              </a>
            </div>

            {/* Image */}
            <div className="relative min-h-[300px] w-full lg:w-1/2">
              <LazyImg
                src={image}
                alt={title}
                className="absolute inset-0 h-full w-full object-cover"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
