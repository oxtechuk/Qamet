import { useTranslation } from "react-i18next";
import type { IAboutHeroProps } from "../../interfaces/IAboutHeroProps";

export default function AboutHero({
  badgeText,
  titleWhite,
  titleBlue,
  subtitle,
  description,
  stats,
}: IAboutHeroProps) {
  const { i18n } = useTranslation();
  return (
    <section
      dir={i18n.dir()}
      className="relative w-full overflow-hidden bg-[#010915] py-20 text-white"
    >
      <div className="absolute inset-0 bg-[radial-gradient(circle_at_20%_50%,rgba(0,98,241,0.28),transparent_32%),radial-gradient(circle_at_80%_50%,rgba(0,98,241,0.28),transparent_32%)]" />

      <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto flex max-w-4xl flex-col items-center text-center">
          <div className="mb-10 inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-5 py-2 text-[13px] text-white/80 backdrop-blur-sm">
            <span className="h-2 w-2 rounded-full bg-[var(--brand-secondary-color)]" />
            {badgeText}
          </div>

          <h1 className="text-[38px] font-extrabold leading-[1.4] md:text-[56px]">
            <span>{titleWhite} </span>
            <span className="text-[var(--brand-primary-color)]">
              {titleBlue}
            </span>
          </h1>

          <h2 className="mt-3 text-[24px] font-bold leading-[1.6] text-white md:text-[32px]">
            {subtitle}
          </h2>

          <p className="mt-6 max-w-3xl text-[16px] leading-8 text-white/60 md:text-[18px]">
            {description}
          </p>

          {stats.length > 0 && (
            <div className="mt-14 grid w-full grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
              {stats.map((stat) => (
                <div
                  key={stat.label}
                  className="flex h-[74px] items-center justify-center gap-4 rounded-[14px] border border-white/20 bg-white/10 px-5 backdrop-blur-sm"
                >
                  <div className="text-start">
                    <p className="text-[14px] font-bold text-white">
                      {stat.label}
                    </p>
                    <p className="mt-1 text-[12px] text-white/55">
                      {stat.description}
                    </p>
                  </div>

                  <strong className="text-[26px] font-extrabold text-[var(--brand-primary-color)]">
                    {stat.value}
                  </strong>
                </div>
              ))}
            </div>
          )}
        </div>
      </div>
    </section>
  );
}
