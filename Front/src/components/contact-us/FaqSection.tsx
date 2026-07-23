import { useState } from "react";
import { useTranslation } from "react-i18next";
import FaqAccordion from "./FaqAccordion";
import type { IFaqSectionProps } from "../../interfaces/IFaqSectionProps";

export default function FaqSection({ faqs }: IFaqSectionProps) {
  const { t, i18n } = useTranslation();
  const [openId, setOpenId] = useState<string | number | null>(null);

  const toggle = (id: string | number) =>
    setOpenId((prev) => (prev === id ? null : id));

  return (
    <section dir={i18n.dir()} className="w-full bg-[#F9F9F7] py-14">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mb-8 text-start">
          <h2 className="text-[32px]  text-[#111827] md:text-[38px]">
            {t("contactPage.faq.titleBlack")}{" "}
            <span className="text-[var(--brand-secondary-color)]">
              {t("contactPage.faq.titleOrange")}
            </span>
          </h2>
          <p className="mt-3 text-[14px] text-[#6B7280]">
            {t("contactPage.faq.description")}
          </p>
        </div>

        <div className="space-y-3">
          {faqs.map((faq) => (
            <FaqAccordion
              key={faq.id}
              faq={faq}
              isOpen={faq.id === openId}
              onToggle={toggle}
            />
          ))}
        </div>
      </div>
    </section>
  );
}
