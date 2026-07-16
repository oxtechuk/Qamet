import { useTranslation } from "react-i18next";
import type { HomepageStat } from "../types/home.types";
import Button from "./button";

interface AllCarsHeroProps {
  offerImage: string;
  badge?: string;
  titleLine1?: string;
  titleLine2Prefix?: string;
  titleLine2Highlight?: string;
  description?: string;
  stats?: HomepageStat[];
  primaryButtonText?: string;
  primaryButtonTo?: string;
}

export default function AllCarsHero({
  offerImage,
  badge: heroBadge,
  titleLine1,
  titleLine2Prefix,
  titleLine2Highlight,
  description: heroDescription,
  stats: heroStats,
  primaryButtonText,
  primaryButtonTo = "/cars",
}: AllCarsHeroProps) {
  const { t, i18n } = useTranslation();

  return (
    <section
      dir={i18n.dir()}
      className="relative w-full overflow-hidden bg-[#010915] text-white"
    >
      {/* Gradient Layer */}
      <div
        className="absolute inset-0"
        style={{ background: "var(--brand-overlay-gradient)" }}
      />

      {/* Content */}
      <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid min-h-[520px] grid-cols-1 items-center gap-12 py-14 lg:grid-cols-2">
          {/* Text Side */}
          <div className="order-1">
            <div className="mb-8 inline-flex items-center gap-2 rounded-full border border-[var(--brand-secondary-color)]/40 bg-[var(--brand-secondary-color)]/10 px-5 py-2 text-[14px] font-bold text-[var(--brand-secondary-color)]">
              <span className="h-2 w-2 rounded-full bg-[var(--brand-secondary-color)]" />
              {heroBadge || t("allCarsHero.badge")}
            </div>

            <h1 className="text-[38px] font-bold leading-[1.45] md:text-[52px]">
              <span className="block text-white">
                {titleLine1 || t("allCarsHero.title.line1")}
              </span>
              <span className="block text-white">
                {titleLine2Prefix || t("allCarsHero.title.line2Prefix")}{" "}
                <span className="text-[var(--brand-secondary-color)]">
                  {titleLine2Highlight || t("allCarsHero.title.line2Highlight")}
                </span>
              </span>
            </h1>

            <p className="mt-7 max-w-xl text-[18px] leading-9 text-white/85">
              {heroDescription || t("allCarsHero.description")}
            </p>

            <div className="my-9 h-px w-full max-w-xl bg-white/10" />

            <div className="grid max-w-xl grid-cols-3 gap-6 text-center">
              {(heroStats?.length
                ? heroStats
                : (t("allCarsHero.stats", { returnObjects: true }) as {
                    value: string;
                    label: string;
                  }[])
              ).map((stat) => (
                <div key={stat.label}>
                  <strong className="block text-[30px] font-bold text-[var(--brand-primary-color)]">
                    {stat.value}
                  </strong>

                  <span className="mt-1 block text-[14px] text-white/55">
                    {stat.label}
                  </span>
                </div>
              ))}
            </div>

            <div className="my-9 h-px w-full max-w-xl bg-white/10" />

            <div className="flex max-w-xl flex-col gap-4 sm:flex-row">
              <Button
                to={primaryButtonTo}
                bgColor="bg-[var(--brand-secondary-color)]"
                className="h-[52px] flex-1 px-6 py-0 text-[16px]"
              >
                {primaryButtonText || t("allCarsHero.button1")}
              </Button>

              <Button
                to="/finance"
                bgColor="bg-transparent"
                textColor="text-white"
                className="h-[52px] flex-1 border border-white px-6 py-0 text-[16px] text-white hover:bg-white hover:text-[#051023]!"
              >
                {t("allCarsHero.button2")}
              </Button>
            </div>
          </div>

          {/* Image Side */}
          <div className="order-2 flex justify-center lg:justify-start">
            <img
              src={offerImage}
              alt="All cars offer"
              className="w-full max-w-[570px] rounded-[18px] object-contain"
              loading="lazy"
            />
          </div>
        </div>
      </div>
    </section>
  );
}
