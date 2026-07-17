import { useTranslation } from "react-i18next";
import Button from ".././button";
import type { IOffersPageHeroProps } from "../../interfaces/IOffersPageHeroProps";

export default function OffersPageHero({
  image,
  badgeText,
  title,
  description,
  primaryButtonText,
  primaryButtonTo,
  secondaryButtonText,
  secondaryButtonTo,
}: IOffersPageHeroProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="relative overflow-hidden rounded-[24px] bg-white">
          <div className="flex flex-col-reverse lg:flex-row">
            {/* Content */}
            <div className="flex w-full flex-col justify-center px-6 py-10 text-center md:px-12 lg:w-1/2 lg:px-16 lg:text-start">
              <div className="mb-8 inline-flex w-fit items-center self-start rounded-full border border-[var(--brand-secondary-color)]/30 bg-[#FFF0EB] px-7 py-3 text-[16px] font-medium text-[var(--brand-secondary-color)]">
                {badgeText}
              </div>

              <h1 className="text-[30px] font-extrabold leading-[1.5] text-[#07111F] md:text-[40px]">
                {title}
              </h1>

              <p className="mt-5 max-w-xl text-[18px] leading-9 text-[#5F6672]">
                {description}
              </p>

              <div className="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2">
                <Button
                  to={primaryButtonTo}
                  bgColor="bg-[var(--brand-secondary-color)]"
                  className="h-[64px] px-6 py-0 text-[20px]"
                >
                  {primaryButtonText}
                </Button>

                <Button
                  to={secondaryButtonTo}
                  bgColor="bg-transparent"
                  textColor="text-[var(--brand-secondary-color)]"
                  className="h-[64px] border border-[var(--brand-secondary-color)] px-6 py-0 text-[20px] hover:bg-[var(--brand-secondary-color)] hover:text-white!"
                >
                  {secondaryButtonText}
                </Button>
              </div>
            </div>

            {/* Image */}
            <div className="relative h-[300px] w-full overflow-hidden lg:h-auto lg:w-1/2">
              <img
                src={image}
                alt={title}
                className="absolute inset-0 h-full w-full object-cover"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
