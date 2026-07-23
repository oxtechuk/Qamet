import { useTranslation } from "react-i18next";
import { Mail, MapPin, Phone } from "lucide-react";
import { NavLink } from "react-router-dom";
import type { IFooterProps } from "../interfaces/IFooterProps";
import { useSettingsStore } from "../store/settings.store";
import { useLanguageStore } from "../store/language.store";
import { getSocialIcon } from "../utils/social-icons";
import { APP_IMAGES } from "../constants/app-images";
import LazyImg from "./LazyImg";

export default function Footer({
    logoAlt = "Logo",
    quickLinks,
    socialLinks: propSocialLinks,
    phone: propPhone,
    email: propEmail,
    address: propAddress,
    copyright: propCopyright,
}: IFooterProps) {
    const { t } = useTranslation();

    const direction = useLanguageStore((state) => state.direction);
    const settings = useSettingsStore((state) => state.settings);
    const resolvedLogo =  APP_IMAGES.LOGO_WHITE;

    const phone = settings?.contact?.phone ?? propPhone;
    const email = settings?.contact?.email ?? propEmail;
    const address = settings?.contact?.address ?? propAddress;
    const copyright = settings?.footer_text ?? propCopyright;

    const socialLinks = settings?.social_media?.length
        ? settings.social_media.map((social) => ({
              name: social.platform ?? social.icon ?? "",
              icon: social.platform ?? social.icon ?? "",
              url: social.url ?? social.link ?? "",
          }))
        : propSocialLinks;

    // Department phones from API
    const salesPhone = settings?.contact?.sales_phone;
    const financePhone = settings?.contact?.finance_phone;
    const aftersalesPhone = settings?.contact?.aftersales_phone;
    return (
        <footer
            dir={direction}
            className="w-full bg-[#111318] pb-[96px] text-white lg:pb-0"
        >
            <div className="mx-auto max-w-[1440px] px-6 lg:px-[92px]">
                {/* Logo */}
                <div className="flex justify-center pb-12 pt-14 lg:pb-16 lg:pt-[72px]">
                    <LazyImg
                        src={resolvedLogo}
                        alt={logoAlt}
                        className="w-[230px] max-w-full object-contain md:w-[280px] text-white!"
                    />
                </div>

                {/* Main footer columns */}
                <div className="grid grid-cols-1 gap-12 pb-14 md:grid-cols-3 md:gap-10 lg:pb-[64px]">
                    {/* Quick links */}
                    <FooterSection title={t("footer.quickLinks")}>
                        <nav className="flex flex-col items-start gap-6">
                            {quickLinks.map((link) => (
                                <NavLink
                                    key={link.to}
                                    to={link.to}
                                    className="group flex items-center gap-3 text-[15px] text-white/70 transition-colors hover:text-white"
                                >
                                    <span className="h-[7px] w-[7px] shrink-0 rounded-full bg-[var(--brand-secondary-color)]" />

                                    <span>{link.label}</span>
                                </NavLink>
                            ))}
                        </nav>
                    </FooterSection>

                    {/* Contact */}
                    <FooterSection title={t("footer.contactUs")}>
                        <div className="flex flex-col items-start gap-5">
                            {phone && (
                                <ContactRow
                                    label={t("footer.phoneLabel")}
                                    value={phone}
                                    href={`tel:${phone.replace(/\s+/g, "")}`}
                                    icon={<Phone size={19} />}
                                />
                            )}
                            {salesPhone && (
                                <ContactRow
                                    label={t("footer.salesPhone")}
                                    value={salesPhone}
                                    href={`tel:${salesPhone.replace(/\s+/g, "")}`}
                                    icon={<Phone size={19} />}
                                />
                            )}
                            {financePhone && (
                                <ContactRow
                                    label={t("footer.financePhone")}
                                    value={financePhone}
                                    href={`tel:${financePhone.replace(/\s+/g, "")}`}
                                    icon={<Phone size={19} />}
                                />
                            )}
                            {aftersalesPhone && (
                                <ContactRow
                                    label={t("footer.aftersalesPhone")}
                                    value={aftersalesPhone}
                                    href={`tel:${aftersalesPhone.replace(/\s+/g, "")}`}
                                    icon={<Phone size={19} />}
                                />
                            )}
                            {email && (
                                <ContactRow
                                    label={t("footer.emailLabel")}
                                    value={email}
                                    href={`mailto:${email}`}
                                    icon={<Mail size={19} />}
                                />
                            )}
                            {address && (
                                <ContactRow
                                    label={t("footer.addressLabel")}
                                    value={address}
                                    icon={<MapPin size={19} />}
                                />
                            )}
                           
                        </div>
                    </FooterSection>

                    {/* Social links */}
                    <FooterSection title={t("footer.followUs")}>
                        <div className="flex flex-col items-start gap-5">
                            {(socialLinks ?? []).map((social) => (
                                <a
                                    key={`${social.name}-${social.url}`}
                                    href={social.url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label={social.name}
                                    className="flex h-[42px] w-[42px] items-center justify-center rounded-full transition duration-300 hover:scale-110"
                                >
                                    {getSocialIcon(social.icon)}
                                </a>
                            ))}
                        </div>
                    </FooterSection>
                </div>

                {/* Bottom footer */}
                <div className="border-t border-[#8DA8D4]/45 py-7">
                    <div className="flex flex-col items-center justify-between gap-5 text-center text-[13px] text-[#BFD3F4] md:flex-row md:text-start">
                        {/* Copyright on the right in RTL */}
                        <p>{copyright}</p>

                        {/* Policies on the left in RTL */}
                        <div className="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 md:justify-start">
                            <NavLink
                                to="/privacy"
                                className="transition-colors hover:text-white"
                            >
                                {t("footer.privacyPolicy")}
                            </NavLink>

                            <NavLink
                                to="/terms"
                                className="transition-colors hover:text-white"
                            >
                                {t("footer.termsAndConditions")}
                            </NavLink>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    );
}

interface FooterSectionProps {
    title: string;
    children: React.ReactNode;
}

function FooterSection({ title, children }: FooterSectionProps) {
    return (
        <section className="mx-auto flex w-full max-w-[260px] flex-col items-start md:mx-0">
            <h3 className="mb-7 w-full text-start text-[17px] font-semibold text-white">
                {title}
            </h3>

            <div className="w-full">{children}</div>
        </section>
    );
}

interface ContactRowProps {
    label: string;
    value: string;
    icon: React.ReactNode;
    href?: string;
}

function ContactRow({ label, value, icon, href }: ContactRowProps) {
    const content = (
        <div className="flex items-center gap-4">
            <div className="flex h-[38px] w-[38px] shrink-0 items-center justify-center rounded-[9px] border border-[var(--brand-secondary-color)]/30 bg-[var(--brand-secondary-color)]/10 text-[var(--brand-secondary-color)]">
                {icon}
            </div>

            <div className="min-w-0 text-start">
                <p className="mb-1 text-[12px] text-white/45">{label}</p>

                <p className="break-words text-[13px] font-medium leading-6 text-white/90">
                    {value}
                </p>
            </div>
        </div>
    );

    if (!href) {
        return content;
    }

    return (
        <a href={href} className="transition-opacity hover:opacity-80">
            {content}
        </a>
    );
}
