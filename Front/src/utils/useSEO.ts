import { useEffect } from "react";
import { useSettingsStore } from "../store/settings.store";
import { getLocalizedName } from "./localized-name";

export function useSEO(title: string, description?: string, image?: string, url?: string): void {
  const settings = useSettingsStore((s) => s.settings);
  const siteName = getLocalizedName(settings?.site_name) || "Qmet";

  useEffect(() => {
    document.title = `${siteName} | ${title}`;

    setMeta("description", description ?? "");
    setMeta("og:title", `${siteName} | ${title}`);
    setMeta("og:description", description ?? "");
    setMeta("og:image", image ?? "");
    setMeta("og:url", url ?? window.location.href);
    setCanonical(url ?? window.location.href);
    setMeta("og:type", "website");
    setMeta("twitter:card", "summary_large_image");
    setMeta("twitter:title", `${siteName} | ${title}`);
    setMeta("twitter:description", description ?? "");
    setMeta("twitter:image", image ?? "");
  }, [title, description, image, url, siteName]);
}

function setCanonical(href: string): void {
  let link = document.querySelector<HTMLLinkElement>('link[rel="canonical"]');
  if (!link) {
    link = document.createElement("link");
    link.setAttribute("rel", "canonical");
    document.head.appendChild(link);
  }
  link.setAttribute("href", href);
}

function setMeta(name: string, content: string): void {
  if (!content) return;
  let el = document.querySelector<HTMLMetaElement>(`meta[name="${name}"], meta[property="${name}"]`);
  if (!el) {
    el = document.createElement("meta");
    if (name.startsWith("og:") || name.startsWith("twitter:")) {
      el.setAttribute("property", name);
    } else {
      el.setAttribute("name", name);
    }
    document.head.appendChild(el);
  }
  el.setAttribute("content", content);
}
