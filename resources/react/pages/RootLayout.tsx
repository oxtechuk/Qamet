import { useEffect } from "react";
import { Outlet, useLocation } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { useLanguageStore } from "../store/language.store";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { getSettings } from "../services/api";
import { useSettingsStore } from "../store/settings.store";
import TopBar from "../components/top-bar";
import Header from "../components/header";
import Footer from "../components/Footer";
import MobileBottomNav from "../components/MobileBottomNav";
import ScrollToTop from "../components/ScrollToTop";
import WhatsAppWidget from "../components/WhatsAppWidget";

export default function RootLayout() {
  const { t } = useTranslation();
  const { pathname } = useLocation();
  const { language, setLanguage } = useLanguageStore();
  const { loaded, settings, setSettings, setLoading } = useSettingsStore();
  const isHome = pathname === "/";

  useEffect(() => {
    if (loaded) return;
    setLoading(true);
    getSettings().then(setSettings).catch(() => setLoading(false));
  }, []);

  useEffect(() => {
    if (!loaded || !settings?.favicon) return;
    const link = document.querySelector<HTMLLinkElement>('link[rel="icon"]');
    if (link) link.href = getImageUrl(settings.favicon);
  }, [loaded, settings]);

  const navItems = [
    { label: t("nav.home"), path: "/" },
    { label: t("nav.cars"), path: "/cars" },
    { label: t("nav.offers"), path: "/offers" },
    { label: t("nav.orders"), path: "/orders" },
    { label: t("nav.about"), path: "/about" },
    { label: t("nav.blog"), path: "/blog" },
  ];

  return (
    <div className={`min-h-screen  ${isHome ? "pt-0" : "pt-0 sm:pt-[30px]"}`}>
      <ScrollToTop />
      <ToastContainer
        position="top-center"
        rtl={language === "ar"}
        theme="colored"
      />

      {!isHome && (
        <>
          <TopBar
            phone={t("topbar.phoneValue")}
            email={t("topbar.emailValue")}
            location={t("topbar.locationValue")}
            onLanguageToggle={() => setLanguage(language === "en" ? "ar" : "en")}
          />

          <div className="hidden md:block sticky top-[35px] sm:top-[35px] z-40">
            <Header
              logoSrc={getImageUrl(settings?.logo ?? null) || APP_IMAGES.LOGO}
                logoAlt={t("rootLayout.logoAlt")}
              navItems={navItems}
              ctaText={t("nav.contact")}
              ctaPath="/contact"
            />
          </div>
        </>
      )}

      <main className="pb-[96px] md:pb-0">
        <Outlet />
      </main>

      <div className="hidden md:block">
        <Footer
        logoSrc={getImageUrl(settings?.logo ?? null) || APP_IMAGES.LOGO}
        logoAlt={t("rootLayout.logoAlt")}
        quickLinks={[
          { label: t("rootLayout.quickLinks.0.label"), to: t("rootLayout.quickLinks.0.to") },
          { label: t("rootLayout.quickLinks.1.label"), to: t("rootLayout.quickLinks.1.to") },
          { label: t("rootLayout.quickLinks.2.label"), to: t("rootLayout.quickLinks.2.to") },
          { label: t("rootLayout.quickLinks.3.label"), to: t("rootLayout.quickLinks.3.to") },
          { label: t("rootLayout.quickLinks.4.label"), to: t("rootLayout.quickLinks.4.to") },
        ]}
        socialLinks={[
          {
            name: "TikTok",
            icon: APP_IMAGES.SOCIAL_TIKTOK,
            url: "https://www.tiktok.com",
          },
          {
            name: "Facebook",
            icon: APP_IMAGES.SOCIAL_FACEBOOK,
            url: "https://www.facebook.com",
          },
          {
            name: "Instagram",
            icon: APP_IMAGES.SOCIAL_INSTAGRAM,
            url: "https://www.instagram.com",
          },
        ]}
        phone={t("rootLayout.phone")}
        email={t("rootLayout.email")}
        address={t("rootLayout.address")}
        copyright={t("rootLayout.copyright")}
      />
      </div>

      <MobileBottomNav />
      <WhatsAppWidget />
    </div>
  );
}
