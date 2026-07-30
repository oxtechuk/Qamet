import { useTranslation } from "react-i18next";
import Button from "./button";
import type { IOffersSectionProps } from "../interfaces/IOffersSectionProps";
import OfferCard from "./OfferCard";

export default function OffersSection({
  titleWhite,
  titleOrange,
  buttonText,
  buttonTo,
  backgroundImage,
  offers,
}: IOffersSectionProps) {
  const { i18n } = useTranslation();

  return (
    <section
      dir={i18n.dir()}
      className="relative w-full overflow-hidden bg-[#010915] py-16"
      style={{
        backgroundImage: `url(${backgroundImage})`,
        backgroundSize: "cover",
        backgroundPosition: "center",
      }}
    >
      <div className="absolute inset-0 bg-[#010915]/75" />

      <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-10 flex flex-col items-start gap-4 md:flex-row md:items-center md:justify-between md:gap-6">
          <h2 className="text-[26px] font-bold text-white md:text-[38px]">
            {titleWhite}
            <span className="text-[var(--brand-secondary-color)]">
              {" "}
              {titleOrange}
            </span>
          </h2>

          <Button
            to={buttonTo}
            bgColor="bg-[var(--brand-secondary-color)]"
            className="w-full px-6 py-2.5 text-[13px] md:w-auto md:px-8 md:py-3 md:text-[15px]"
          >
            {buttonText}
          </Button>
        </div>

        {/* Cards */}
        <div className="grid grid-cols-1 gap-6 md:grid-cols-3 justify-items-center">
          {offers.map((offer, index) => (
            <OfferCard key={index} {...offer} />
          ))}
        </div>
      </div>
    </section>
  );
}
