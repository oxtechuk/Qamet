import { useTranslation } from "react-i18next";
import PartnerCard from "./PartnerCard";
import type { IPartnersSectionProps } from "../../interfaces/IPartnersSectionProps";

export default function PartnersSection({
  eyebrow,
  titleBlack,
  titleBlue,
  description,
  partners,
}: IPartnersSectionProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-16">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-3xl text-center">
          <div className="mb-8 flex items-center justify-center gap-7">
            <span className="h-px w-[70px] bg-[var(--brand-secondary-color)]" />

            <span className="text-[15px] font-bold text-[var(--brand-secondary-color)]">
              {eyebrow}
            </span>

            <span className="h-px w-[70px] bg-[var(--brand-secondary-color)]" />
          </div>

          <h2 className="text-[34px] font-extrabold leading-tight md:text-[46px]">
            <span className="text-[#07111F]">{titleBlack}</span>{" "}
            <span className="text-[var(--brand-primary-color)]">
              {titleBlue}
            </span>
          </h2>

          <p className="mt-5 text-[17px] leading-8 text-[#6B7280]">
            {description}
          </p>
        </div>

        {partners.length > 0 && (
          <div className="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
            {partners.map((partner) => (
              <PartnerCard key={partner.id} {...partner} />
            ))}
          </div>
        )}
      </div>
    </section>
  );
}
