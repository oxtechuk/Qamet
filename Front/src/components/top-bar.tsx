import { useTranslation } from "react-i18next";
import { Phone, Mail, MapPin } from "lucide-react";
import type { ITopBarProps } from "../interfaces/ITopBar";
import { useSettingsStore } from "../store/settings.store";

export default function TopBar({
  phone: propPhone,
  email: propEmail,
  location: propLocation,
  onLanguageToggle,
}: ITopBarProps) {
  const { t, i18n } = useTranslation();
  const settings = useSettingsStore((s) => s.settings);
  const phone = settings?.contact?.phone || propPhone || t("topbar.phoneValue");
  const email = settings?.contact?.email || propEmail || t("topbar.emailValue");
  const location = settings?.contact?.address || propLocation || t("topbar.locationValue");

  return (
    <div className="hidden md:block fixed top-0 left-0 right-0 z-50 w-full bg-[#051023] text-white text-xs sm:text-sm shadow-sm">
      <div className="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div className="flex flex-col sm:flex-row items-center justify-around gap-1 sm:gap-3 pt-1 sm:pt-1.5 pb-0 sm:pb-1.5">
          {/* Left Side */}
          <div className="flex items-center gap-4 sm:gap-10 order-2 sm:order-none" dir={i18n.dir()}>
            <button
              type="button"
              onClick={onLanguageToggle}
              className="hidden md:block border border-white/70 px-1.5 sm:px-2 py-px text-[10px] sm:text-xs font-bold leading-none rounded hover:bg-white hover:text-[#051023] transition"
            >
              {t("topbar.language")}
            </button>

            {location && (
              <span className="hidden md:inline-flex items-center gap-1.5 sm:gap-2 whitespace-nowrap min-w-0 text-white/90">
                <MapPin size={14} strokeWidth={2.2} className="shrink-0 sm:size-[16px] text-[var(--brand-secondary-color)]" />
                <span className="truncate max-w-[180px] sm:max-w-none">{location}</span>
              </span>
            )}
          </div>

          {/* Right Side */}
          <div className="flex items-center gap-3 sm:gap-6 order-first sm:order-none" dir={i18n.dir()}>
            {phone && (
              <a
                href={`tel:${phone}`}
                className="flex items-center gap-1.5 sm:gap-2 whitespace-nowrap min-w-0 text-white/90 hover:text-[var(--brand-secondary-color)] transition"
              >
                <Phone size={14} strokeWidth={2.2} className="shrink-0 sm:size-[16px] text-[var(--brand-secondary-color)]" />
                <span className="truncate max-w-[120px] sm:max-w-none font-medium">{phone}</span>
              </a>
            )}

            {email && (
              <a
                href={`mailto:${email}`}
                className="flex items-center gap-1.5 sm:gap-2 whitespace-nowrap min-w-0 text-white/90 hover:text-[var(--brand-secondary-color)] transition"
              >
                <Mail size={14} strokeWidth={2.2} className="shrink-0 sm:size-[16px] text-[var(--brand-secondary-color)]" />
                <span className="truncate max-w-[180px] sm:max-w-none">{email}</span>
              </a>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
