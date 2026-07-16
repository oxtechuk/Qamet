import { useTranslation } from "react-i18next";
import Button from ".././button";
import type { IDealerCtaSectionProps } from "../../interfaces/IDealerCtaSectionProps";

export default function DealerCtaSection({
  title,
  description,
  primaryButtonText: _primaryButtonText,
  primaryButtonTo: _primaryButtonTo,
  secondaryButtonText,
  secondaryButtonTo,
}: IDealerCtaSectionProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-8">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="rounded-[26px] bg-gradient-to-l from-[#163F8B] to-[#051023] px-6 py-10 md:px-12">
          <div className="flex flex-col items-center justify-between gap-8 md:flex-row">
            <div className="text-center md:text-start">
              <h2 className="text-[28px] font-extrabold leading-tight text-white md:text-[36px]">
                {title}
              </h2>

              <p className="mt-3 text-[15px] leading-7 text-white/65 md:text-[17px]">
                {description}
              </p>
            </div>

            <div className="flex flex-col gap-4 sm:flex-row">
              {/* <Button
                to={primaryButtonTo}
                bgColor="bg-[var(--brand-secondary-color)]"
                className="h-[56px] min-w-[150px] px-8 py-0 text-[17px]"
              >
                {primaryButtonText}
              </Button> */}

              <Button
                to={secondaryButtonTo}
                bgColor="bg-transparent"
                textColor="text-white!"
                className="h-[56px] min-w-[150px] border border-white px-8 py-0 text-[17px] "
              >
                {secondaryButtonText}
              </Button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
