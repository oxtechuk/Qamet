import { useTranslation } from "react-i18next";
import AboutInfoCard from "./AboutInfoCard";
import type { IAboutStorySectionProps } from "../../interfaces/IAboutStorySectionProps";

export default function AboutStorySection({
  title,
  paragraphs,
  cards,
}: IAboutStorySectionProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full py-16">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-4xl text-center">
          <h2 className="text-[26px] font-extrabold leading-[1.6] text-[#07111F] md:text-[32px]">
            {title}
          </h2>

          {paragraphs.length > 0 && (
            <div className="mt-7 space-y-6">
              {paragraphs.map((paragraph, index) => (
                <p
                  key={index}
                  className="text-[17px] leading-9 text-[#4B5563] md:text-[19px]"
                >
                  {paragraph}
                </p>
              ))}
            </div>
          )}
        </div>

        {cards.length > 0 && (
          <div className="mx-auto mt-20 grid max-w-5xl grid-cols-1 gap-12 md:grid-cols-2">
            {cards.map((card) => (
              <AboutInfoCard key={card.title} {...card} />
            ))}
          </div>
        )}
      </div>
    </section>
  );
}
