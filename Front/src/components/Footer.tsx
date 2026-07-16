import { useTranslation } from "react-i18next";
import { Mail, MapPin, Phone } from "lucide-react";
import { NavLink } from "react-router-dom";
import type { IFooterProps } from "../interfaces/IFooterProps";
import { useSettingsStore } from "../store/settings.store";
import { useLanguageStore } from "../store/language.store";
import { getSocialIcon } from "../utils/social-icons";
import { FooterTitle, ContactItem } from "./footer-parts";

export default function Footer({
  logoSrc,
  logoAlt = "Logo",
  quickLinks,
  socialLinks: propSocialLinks,
  phone: propPhone,
  email: propEmail,
  address: propAddress,
  copyright: propCopyright,
}: IFooterProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);
  const settings = useSettingsStore((s) => s.settings);

  const phone = settings?.contact?.phone ?? propPhone;
  const email = settings?.contact?.email ?? propEmail;
  const address = settings?.contact?.address ?? propAddress;
  const copyright = settings?.footer_text ?? propCopyright;
  const socialLinks = settings?.social_media?.length
    ? settings.social_media.map((sm) => ({
        name: sm.icon,
        icon: sm.icon,
        url: sm.link,
      }))
    : propSocialLinks;

  return (
    <footer className="w-full bg-[#111318] text-white pb-[96px] lg:pb-0">
      <div className="mx-auto max-w-[1440px] px-6 lg:px-[92px]">
        {/* Main Footer */}
        <div
          className="grid grid-cols-1 gap-8 py-10 lg:gap-12 lg:py-[72px] lg:grid-cols-[260px_1fr_240px] lg:items-start"
          dir={direction}
        >
          {/* Social */}
          <div className="flex flex-col items-center lg:items-start">
            <FooterTitle title={t("footer.followUs")} />

            <div className="mt-8 flex items-center gap-5">
              {(socialLinks ?? []).map((social) => (
                <a
                  key={social.name}
                  href={social.url}
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label={social.name}
                  className="flex h-[42px] w-[42px] items-center justify-center rounded-full transition hover:scale-105"
                >
                  {getSocialIcon(social.icon)}
                </a>
              ))}
            </div>
          </div>

          {/* Center Content */}
          <div className="flex flex-col items-center">
            <FooterTitle title={t("footer.quickLinks")} centered />

            <nav className="mt-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-5">
              {quickLinks.map((link) => (
                <NavLink
                  key={link.to}
                  to={link.to}
                  className="flex items-center gap-2 text-[15px] text-white/85 transition hover:text-[var(--brand-secondary-color)]"
                >
                  <span className="h-[7px] w-[7px] rounded-full bg-[var(--brand-secondary-color)]" />
                  {link.label}
                </NavLink>
              ))}
            </nav>

            {/* Contact */}
            <div className="mt-10 lg:mt-[64px] w-full">
              <FooterTitle title={t("footer.contactUs")} centered />

              <div className="mt-9 grid grid-cols-1 gap-8 sm:grid-cols-3 lg:gap-8">
                <ContactItem
                  label={t("footer.addressLabel")}
                  value={address ?? ""}
                  icon={<MapPin size={21} />}
                />

                <ContactItem
                  label={t("footer.emailLabel")}
                  value={email ?? ""}
                  icon={<Mail size={21} />}
                />

                <ContactItem
                  label={t("footer.phoneLabel")}
                  value={phone ?? ""}
                  icon={<Phone size={21} />}
                />
              </div>
            </div>
          </div>

          {/* Logo */}
          <div className="flex justify-center lg:justify-start">
            <img
              src={logoSrc}
              alt={logoAlt}
              className="w-[190px] max-w-full object-contain"
              loading="lazy"
            />
          </div>
        </div>

        {/* Bottom Footer */}
        <div className="border-t border-[#8DA8D4]/45 py-8">
          <div
            className="flex flex-col items-center justify-between gap-6 text-[14px] text-[#BFD3F4] md:flex-row"
            dir={direction}
          >
            <div className="flex items-center gap-10">
              <NavLink to="/privacy" className="transition hover:text-white">
                {t("footer.privacyPolicy")}
              </NavLink>

              <NavLink to="/terms" className="transition hover:text-white">
                {t("footer.termsAndConditions")}
              </NavLink>
            </div>

            <p>{copyright}</p>
          </div>
        </div>
      </div>
    </footer>
  );
}