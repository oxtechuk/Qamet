import { useEffect } from "react";
import { useLocation } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { useSEO } from "../utils/useSEO";
import { track404Page } from "../utils/analytics";

export default function NotFoundPage() {
  const { t } = useTranslation();
  const { pathname } = useLocation();
  useSEO(t("pageTitles.notFound"));

  useEffect(() => {
    track404Page(pathname);
  }, [pathname]);

  return <h1>404 - Page Not Found</h1>;
}
