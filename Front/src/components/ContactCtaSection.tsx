import { useTranslation } from "react-i18next";
import { Phone } from "lucide-react";
import type { IContactCtaSectionProps } from "../interfaces/IContactCtaSectionProps";
import { SiWhatsapp } from "react-icons/si";
import { useSettingsStore } from "../store/settings.store";

export default function ContactCtaSection({
  badgeText,
  titleWhite,
  titleOrange,
  description,
  phoneText,
  phoneHref: propPhoneHref,
  whatsappText,
  whatsappHref: propWhatsappHref,
  sectionBgColor = "transparent",
}: IContactCtaSectionProps) {
  const { i18n } = useTranslation();
  const settings = useSettingsStore((s) => s.settings);

  const phone = settings?.contact?.phone ?? "966500000000";
  const phoneHref = propPhoneHref ?? `tel:${phone}`;
  const whatsappNumber = settings?.contact?.whatsapp ?? "966500000000";
  const whatsappHref = propWhatsappHref ?? `https://wa.me/${whatsappNumber}`;

  return (
    <section
      className="w-full py-10"
      dir={i18n.dir()}
      style={{
        background: sectionBgColor,
      }}
    >
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="relative overflow-hidden rounded-[28px] border border-[#0B3F86] px-6 py-12 md:px-10 md:py-16">
          {/* Gradient overlay */}
          <div
            className="absolute inset-0"
            style={{
              background: "var(--contact-cta-bg)",
              borderColor: "var(--contact-cta-border)",
            }}
          />

          <div className="relative z-10 mx-auto flex max-w-4xl flex-col items-center text-center">
            <div className="mb-8 inline-flex items-center gap-2 rounded-full border border-[rgba(235,94,40,0.35)] bg-[rgba(235,94,40,0.08)] px-6 py-3 text-[18px] font-medium text-[var(--brand-secondary-color)]">
              <span className="h-2.5 w-2.5 rounded-full bg-[var(--brand-secondary-color)]" />
              {badgeText}
            </div>

            <h2 className="text-[38px] font-bold leading-[1.4] md:text-[60px]">
              <span className="text-white">{titleWhite} </span>
              <span className="text-[var(--brand-secondary-color)]">
                {titleOrange}
              </span>
            </h2>

            <p className="mt-5 max-w-3xl text-[18px] leading-8 text-[#A7B3C7] md:text-[24px] md:leading-10">
              {description}
            </p>

            <div className="mt-10 flex flex-col items-center gap-4 sm:flex-row">
              <a
                href={phoneHref}
                className="flex h-[56px] min-w-[155px] items-center justify-center gap-2 rounded-[10px] bg-[var(--brand-primary-color)] px-8 text-[22px] font-medium text-white! transition hover:opacity-90"
              >
                {phoneText}
                <Phone size={22} color="#fff" />
              </a>

              <a
                href={whatsappHref}
                target="_blank"
                rel="noopener noreferrer"
                className="flex h-[56px] min-w-[155px] items-center justify-center gap-2 rounded-[10px] bg-[#25D366] px-8 text-[22px] font-medium text-white! transition hover:opacity-90"
              >
                {whatsappText}
                <SiWhatsapp size={24} color="#fff" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
