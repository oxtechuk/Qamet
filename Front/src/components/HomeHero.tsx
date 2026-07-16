import { Calculator } from "lucide-react";
import { useLanguageStore } from "../store/language.store";
import Button from "./button";
import HeroCard from "./HeroCard";
import type { IHomeHeroProps } from "../interfaces/IHomeHeroProps";

export default function HomeHero({
  bannerImage,
  titleBlue,
  titleOrange,
  description,
  primaryButtonText,
  primaryButtonTo,
  secondaryButtonText,
  secondaryButtonTo,
  cards,
}: IHomeHeroProps) {
  const direction = useLanguageStore((s) => s.direction);

  return (
    <section
      className="w-full bg-[#F0F2F5] pt-1 md:pt-2 pb-6 md:pb-10"
      dir={direction}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Main Banner */}
        <div className="overflow-hidden rounded-[18px]">
          <img
            src={bannerImage}
            alt="Car offers banner"
            className="w-full h-[190px] md:h-[360px] object-cover"
            loading="lazy"
          />
        </div>

        {/* Bottom Section */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-5 items-center">
          {/* Text Content */}
          <div
            className={`lg:col-span-5 text-center order-1 lg:order-1 ${direction === "rtl" ? "lg:text-right" : "lg:text-left"}`}
          >
            <h1 className="text-[34px] md:text-[46px] leading-tight font-bold">
              <span className="block text-[var(--brand-primary-color)]">
                {titleBlue}
              </span>
              <span className="block text-[var(--brand-secondary-color)] mt-2">
                {titleOrange}
              </span>
            </h1>

            <p className="mt-5 text-[#4B8FEA] text-base md:text-lg leading-8 max-w-xl mx-auto lg:mx-0">
              {description}
            </p>

            <div className="mt-8 flex flex-col sm:flex-row gap-5 justify-center lg:justify-start">
              <Button to={primaryButtonTo}>{primaryButtonText}</Button>

              <Button
                to={secondaryButtonTo}
                bgColor="bg-transparent"
                textColor="text-[var(--brand-secondary-color)]!"
                className="border border-[var(--brand-secondary-color)] hover:bg-[var(--brand-secondary-color)] hover:text-white!"
              >
                <span className="flex items-center justify-center gap-2">
                  {secondaryButtonText}
                  <Calculator size={15} />
                </span>
              </Button>
            </div>
          </div>

          {/* Cards */}
          <div className="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5 order-2 lg:order-2">
            {cards.map((card) => (
              <HeroCard
                key={card.title}
                image={card.image}
                title={card.title}
                description={card.description}
                buttonText={card.buttonText}
                buttonTo={card.buttonTo}
                badge={card.badge}
              />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
