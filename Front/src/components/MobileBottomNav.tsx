import { useState } from "react";
import { NavLink, useLocation } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../store/language.store";
import { useSettingsStore } from "../store/settings.store";
import { mobileNavItems } from "../constants/navigation";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { X, Info, Phone, Newspaper, Languages, MapPin, Mail, ShoppingBag } from "lucide-react";
import LazyImg from "./LazyImg";

const menuLinks = [
  { labelKey: "nav.orders", to: "/orders", icon: ShoppingBag },
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
        {/* Drag handle */}
        <div className="flex justify-center bg-white pt-1.5">
          <div className="h-[3px] w-10 rounded-full bg-[#E5E7EB]" />
        </div>

        <div className="relative flex h-[64px] items-end justify-around bg-white px-3 pb-3 shadow-[0_-2px_16px_rgba(0,0,0,0.06)]">
          {mobileNavItems.map((item) => {
            const Icon = item.icon;
            const isActive =
              item.to === "/"
                ? location.pathname === "/"
                : item.isMenu
                  ? menuLinks.some((l) => location.pathname === l.to)
                  : location.pathname.startsWith(item.to);

            /* Center raised button */
            if (item.isCenter) {
              return (
                <NavLink
                  key={item.to}
                  to={item.to}
                  className="relative -top-4 flex flex-col items-center"
                >
                  <div className="flex h-[54px] w-[54px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] shadow-[0_6px_20px_rgba(0,0,0,0.28)]">
                    <Icon size={24} strokeWidth={2} className="text-white" />
                  </div>
                  <span className="mt-1 text-[10px] font-semibold text-[#6B7280]">
                    {t(item.labelKey)}
                  </span>
                </NavLink>
              );
            }

            /* More / menu trigger */
            if (item.isMenu) {
              return (
                <button
                  key={item.to}
                  type="button"
                  onClick={() => setSidebarOpen(true)}
                  className="flex flex-col items-center gap-0.5"
                >
                  <Icon
                    size={22}
                    strokeWidth={1.8}
                    className={isActive ? "text-[var(--brand-primary-color)]" : "text-[#9CA3AF]"}
                  />
                  <span className={`text-[10px] font-semibold ${isActive ? "text-[var(--brand-primary-color)]" : "text-[#9CA3AF]"}`}>
                    {t(item.labelKey)}
                  </span>
                  {isActive && <span className="h-[2px] w-5 rounded-full bg-[var(--brand-primary-color)]" />}
                </button>
              );
            }

            /* Regular nav item */
            return (
              <NavLink
                key={item.to}
                to={item.to}
                className="flex flex-col items-center gap-0.5"
              >
                <Icon
                  size={22}
                  strokeWidth={1.8}
                  className={isActive ? "text-[var(--brand-primary-color)]" : "text-[#9CA3AF]"}
                />
                <span className={`text-[10px] font-semibold ${isActive ? "text-[var(--brand-primary-color)]" : "text-[#9CA3AF]"}`}>
                  {t(item.labelKey)}
                </span>
                {isActive && <span className="h-[2px] w-5 rounded-full bg-[var(--brand-primary-color)]" />}
              </NavLink>
            );
          })}
        </div>
      </nav>

      {/* Sidebar overlay */}
      {sidebarOpen && (
        <div
          className="fixed inset-0 z-[60] bg-black/40 md:hidden"
          onClick={() => setSidebarOpen(false)}
        />
      )}

      {/* Sidebar drawer */}
      <div
        className={`fixed top-0 bottom-0 z-[70] w-[75vw] max-w-[320px] bg-white shadow-2xl transition-transform duration-300 md:hidden ${
          isRTL ? "right-0" : "left-0"
        } ${
          sidebarOpen ? "translate-x-0" : isRTL ? "translate-x-full" : "-translate-x-full"
        }`}
      >
        <div className="flex h-full flex-col">
          <div className="flex items-center justify-between px-5 pt-5 pb-3">
            <LazyImg
              src={getImageUrl(settings?.logo ?? null) || APP_IMAGES.LOGO}
              alt="Logo"
              className="h-20 w-auto object-contain"
            />
            <button type="button" onClick={() => setSidebarOpen(false)} className="text-[#34495E]">
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
                    className={`flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold transition ${
                      isActive ? "bg-[var(--brand-primary-color)]/10 text-[var(--brand-primary-color)]" : "text-[#07111F] hover:bg-gray-50"
                    }`}
                  >
                    <LinkIcon size={20} strokeWidth={2} />
                    {t(link.labelKey)}
                  </NavLink>
                );
              })}
            </div>

            <div className="mt-6 border-t border-[#E5E7EB] pt-4 flex flex-col gap-1">
              <span className="flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold text-[#07111F]">
                <MapPin size={20} strokeWidth={2} />
                {t("topbar.locationValue")}
              </span>
              {settings?.contact?.phone && (
                <a href={`tel:${settings.contact.phone}`} className="flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold text-[#07111F] hover:bg-gray-50">
                  <Phone size={20} strokeWidth={2} />
                  {settings.contact.phone}
                </a>
              )}
              {settings?.contact?.email && (
                <a href={`mailto:${settings.contact.email}`} className="flex items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold text-[#07111F] hover:bg-gray-50">
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
                className="flex w-full items-center gap-3 rounded-xl px-4 py-3.5 text-[15px] font-bold text-[#07111F] hover:bg-gray-50"
              >
                <Languages size={20} strokeWidth={2} />
                {t("topbar.language")}
              </button>
            </div>

            <div className="mt-4 px-5 pb-6">
              <NavLink
                to="/contact"
                onClick={() => setSidebarOpen(false)}
                className="flex items-center justify-center gap-2 rounded-xl bg-[var(--brand-secondary-color)] px-6 py-3.5 font-bold text-[var(--brand-primary-color)] transition hover:brightness-105"
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
