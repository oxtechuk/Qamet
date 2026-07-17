import { useState } from "react";
import { useTranslation } from "react-i18next";
import { Phone } from "lucide-react";
import FaqAccordion from "./FaqAccordion";
import type { IFaqSectionProps } from "../../interfaces/IFaqSectionProps";

export default function FaqSection({
  eyebrow,
  titleBlack,
  titleOrange,
  description,
  buttonText,
  buttonHref = "/contact",
  faqs,
}: IFaqSectionProps) {
  const { i18n } = useTranslation();
  const [openId, setOpenId] = useState<string | number | null>(
    faqs[0]?.id ?? null,
  );

  const toggleFaq = (id: string | number) => {
    setOpenId((current) => (current === id ? null : id));
  };

  return (
    <section dir={i18n.dir()} className="w-full py-16">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 gap-12 lg:grid-cols-12">
          <div className="lg:col-span-3">
            <div className="mb-8 flex items-center justify-center gap-5 lg:justify-start">
              <span className="h-px w-[62px] bg-[var(--brand-secondary-color)]" />
              <span className="text-[15px] font-bold text-[var(--brand-secondary-color)]">
                {eyebrow}
              </span>
              <span className="h-px w-[62px] bg-[var(--brand-secondary-color)]" />
            </div>

            <h2 className="text-center text-[32px] font-extrabold leading-[1.4] text-[#07111F] md:text-[40px] lg:text-start">
              <span>{titleBlack} </span>
              <span className="text-[var(--brand-secondary-color)]">
                {titleOrange}
              </span>
            </h2>

            <p className="mt-7 text-center text-[17px] leading-9 text-[#5F6672] lg:text-start">
              {description}
            </p>

            <a
              href={buttonHref}
              className="mt-10 flex h-[56px] w-full items-center justify-center gap-2 rounded-[8px] bg-[var(--brand-secondary-color)] text-[18px] font-bold text-white! transition hover:opacity-90"
            >
              {buttonText}
              <Phone size={20} color="#fff" />
            </a>
          </div>

          <div className="lg:col-span-9">
            <div className="space-y-5">
              {faqs.map((faq) => (
                <FaqAccordion
                  key={faq.id}
                  faq={faq}
                  isOpen={faq.id === openId}
                  onToggle={toggleFaq}
                />
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
