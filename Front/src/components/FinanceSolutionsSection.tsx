import { useTranslation } from "react-i18next";
import { CheckCircle } from "lucide-react";
import Button from "./button";
import type { IFinanceSolutionsSectionProps } from "../interfaces/IFinanceSolutionsSectionProps";

export default function FinanceSolutionsSection({
  backgroundImage,
  titleBlue,
  titleOrange,
  description,
  buttonText,
  buttonTo,
  stats,
  features,
  className = "",
}: IFinanceSolutionsSectionProps) {
  const { i18n } = useTranslation();

  return (
    <section
      dir={i18n.dir()}
      className={`relative w-full overflow-hidden bg-[#010915] py-14 ${className}`}
      style={backgroundImage ? {
        backgroundImage: `url(${backgroundImage})`,
        backgroundSize: "cover",
        backgroundPosition: "center",
      } : undefined}
    >
      <div className="absolute inset-0 bg-[#010915]/80" />

      <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 items-center gap-12 lg:grid-cols-12">
          {/* Text Content */}
          <div className="lg:col-span-5">
            <h2 className="text-[26px] font-bold leading-[1.4] md:text-[42px]">
              <span className="block text-[var(--brand-primary-color)]">
                {titleBlue}
              </span>
              <span className="block text-[var(--brand-secondary-color)]">
                {titleOrange}
              </span>
            </h2>

            <p className="mt-5 max-w-xl text-[14px] leading-7 text-white/85 md:text-[16px] md:leading-8">
              {description}
            </p>

            <Button
              to={buttonTo}
              className="mt-7 h-[48px] w-full max-w-[430px] px-6 py-0 text-[14px] md:h-[52px] md:text-[16px]"
            >
              {buttonText}
            </Button>
          </div>

          {/* Stats + Features */}
          <div className="lg:col-span-7">
            <div className="grid grid-cols-1 gap-5 sm:grid-cols-3">
              {stats.map((stat) => (
                <div
                  key={stat.label}
                  className="flex h-[110px] flex-col items-center justify-center rounded-[14px] border border-white/10 bg-white/5 px-4 text-center backdrop-blur-sm"
                >
                  <strong className="text-[24px] font-bold text-white md:text-[30px]">
                    {stat.value}
                  </strong>

                  <span className="mt-2 text-[13px] text-white/55">
                    {stat.label}
                  </span>
                </div>
              ))}
            </div>

            <ul className="mt-9 space-y-4">
              {features.map((feature) => (
                <li
                  key={feature}
                  className="flex items-center gap-3 text-[15px] text-white/80"
                >
                  <CheckCircle
                    size={18}
                    className="shrink-0 text-[var(--brand-primary-color)]"
                  />
                  <span>{feature}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>
      </div>
    </section>
  );
}
