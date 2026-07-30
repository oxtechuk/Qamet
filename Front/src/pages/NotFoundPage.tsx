import { useTranslation } from "react-i18next";
import { useSEO } from "../utils/useSEO";

export default function NotFoundPage() {
  const { t } = useTranslation();
  useSEO(t("pageTitles.notFound"));
  return <h1>404 - Page Not Found</h1>;
}
