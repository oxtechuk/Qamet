import { useState } from "react";
import { NavLink, useLocation } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../store/language.store";
import { useSettingsStore } from "../store/settings.store";
import { mobileNavItems } from "../constants/navigation";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { X, Info, Phone, Newspaper, Languages, MapPin, Mail } from "lucide-react";

const menuLinks = [
  { labelKey: "nav.about", to: "/about", icon: Info },
  { labelKey: "nav.contact", to: "/contact", icon: Phone },
  { labelKey: "mobileNav.blog", to: "/blog", icon: Newspaper },
];

export default function MobileBottomNav() {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);
  const location = useLocation();
  const settings = useSettingsStore((s) => s.settings);
  const [sidebarOpen, setSidebarOpen] = useState(false);

  const isRTL = direction === "rtl";

  return (
    <>
      <nav
        dir={direction}
        className="fixed bottom-0 left-0 right-0 z-50 block md:hidden"
      >
        <div className="relative mx-4 mb-4 flex h-[68px] items-center justify-around rounded-[24px] bg-white/95 backdrop-blur-md px-2 shadow-[0_10px_35px_rgba(0,0,0,0.08)] border border-slate-100/80">
          {mobileNavItems.map((item) => {
            const Icon = item.icon;

            const isActive =
              item.to === "/"
                ? location.pathname === "/"
                : item.isMenu
                  ? menuLinks.some((link) => location.pathname === link.to)
                  : location.pathname.startsWith(item.to);

            const baseItemClass =
              "relative flex h-full flex-1 flex-col items-center justify-center text-center transition-all duration-300 w-16 focus:outline-none";

            if (item.isMenu) {
              return (
                <button
                  key={item.to}
                  type="button"
                  onClick={() => setSidebarOpen(true)}
                  className={baseItemClass}
                >
                  <div
                    className={`transition-all duration-300 ${
                      isActive
                        ? "text-[var(--brand-primary-color)] scale-110 -translate-y-0.5"
                        : "text-[#9CA3AF] hover:text-slate-600"
                    }`}
                  >
                    <Icon size={22} strokeWidth={2} />
                  </div>

                  <span
                    className={`text-[10px] font-bold mt-1 transition-all duration-300 ${
                      isActive ? "text-[var(--brand-primary-color)]" : "text-[#9CA3AF]"
                    }`}
                  >
                    {t(item.labelKey)}
                  </span>

                  {isActive && (
                    <span className="absolute bottom-1.5 w-1.5 h-1.5 rounded-full bg-[var(--brand-primary-color)] shadow-[0_0_8px_var(--brand-primary-color)] animate-pulse" />
                  )}
                </button>
              );
            }

            return (
              <NavLink key={item.to} to={item.to} className={baseItemClass}>
                <div
                  className={`transition-all duration-300 ${
                    isActive
                      ? "text-[var(--brand-primary-color)] scale-110 -translate-y-0.5"
                      : "text-[#9CA3AF] hover:text-slate-600"
                  }`}
                >
                  <Icon size={22} strokeWidth={2} />
                </div>

                <span
                  className={`text-[10px] font-bold mt-1 transition-all duration-300 ${
                    isActive ? "text-[var(--brand-primary-color)]" : "text-[#9CA3AF]"
                  }`}
                >
                  {t(item.labelKey)}
                </span>

                {isActive && (
                  <span className="absolute bottom-1.5 w-1.5 h-1.5 rounded-full bg-[var(--brand-primary-color)] shadow-[0_0_8px_var(--brand-primary-color)] animate-pulse" />
                )}
              </NavLink>
            );
          })}
        </div>
      </nav>

      {sidebarOpen && (
        <div
          className="fixed inset-0 z-[60] bg-black/40 md:hidden"
          onClick={() => setSidebarOpen(false)}
        />
      )}

      <div
        className={`fixed top-0 bottom-0 z-[70] w-[75vw] max-w-[320px] bg-white shadow-2xl transition-transform duration-300 md:hidden ${
          isRTL ? "right-0" : "left-0"
        } ${
          sidebarOpen
            ? "translate-x-0"
            : isRTL
              ? "translate-x-full"
              : "-translate-x-full"
        }`}
      >
        <div className="flex h-full flex-col">
          <div className="flex items-center justify-between px-5 pt-5 pb-3">
            <img
              src={getImageUrl(settings?.logo ?? null) || APP_IMAGES.LOGO}
              alt="Knoz Cars"
              className="h-20 w-auto object-contain"
              loading="lazy"
            />
            <button
              type="button"
              onClick={() => setSidebarOpen(false)}
              className="text-[#34495E]"
            >
              <X size={22} />
            </button>
          </div>

          <div className="flex-1 overflow-y-auto px-5 pb-6">
            <div className="flex flex-col gap-1">
              {menuLinks.map((link) => {
                const LinkIcon = link.icon;
                const isActive = location.pathname === link.to;

                return (
                  <NavLink
                    key={link.to}
                    to={link.to}
                    onClick={() => setSidebarOpen(false)}
                    className={`flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold leading-none transition ${
                      isActive
                        ? "bg-[var(--brand-primary-color)]/10 text-[var(--brand-primary-color)]"
                        : "text-[#07111F] hover:bg-[var(--background)]"
                    }`}
                  >
                    <LinkIcon size={20} strokeWidth={2} />
                    {t(link.labelKey)}
                  </NavLink>
                );
              })}
            </div>

            <div className="mt-6 border-t border-[#D9DEE7] pt-4 flex flex-col gap-1">
              <span className="flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold leading-none text-[#07111F]">
                <MapPin size={20} strokeWidth={2} />
                {t("topbar.locationValue")}
              </span>
              {settings?.contact?.phone && (
                <a
                  href={`tel:${settings.contact.phone}`}
                  className="flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold leading-none text-[#07111F] transition hover:bg-[var(--background)]"
                >
                  <Phone size={20} strokeWidth={2} />
                  {settings.contact.phone}
                </a>
              )}
              {settings?.contact?.email && (
                <a
                  href={`mailto:${settings.contact.email}`}
                  className="flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold leading-none text-[#07111F] transition hover:bg-[var(--background)]"
                >
                  <Mail size={20} strokeWidth={2} />
                  {settings.contact.email}
                </a>
              )}
              <button
                type="button"
                onClick={() => {
                  const { language, setLanguage } = useLanguageStore.getState();
                  setLanguage(language === "en" ? "ar" : "en");
                  setSidebarOpen(false);
                }}
                className="flex w-full items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold leading-none text-[#07111F] transition hover:bg-[var(--background)]"
              >
                <Languages size={20} strokeWidth={2} />
                {t("topbar.language")}
              </button>
            </div>

            <div className="mt-4 px-5 pb-6">
              <NavLink
                to="/contact"
                onClick={() => setSidebarOpen(false)}
                className={[
                  "flex items-center justify-center gap-2 rounded-xl",
                  "bg-[var(--brand-secondary-color)] px-6 py-3.5",
                  "font-bold text-[var(--brand-primary-color)]",
                  "transition hover:brightness-105",
                ].join(" ")}
              >
                <Phone size={17} />
                {t("nav.contact")}
              </NavLink>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
