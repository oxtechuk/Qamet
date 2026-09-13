/**
 * Marketing & Ad Attribution Tracker (First-Touch / Last-Touch Session Persistence)
 * Automatically captures UTM parameters and Click IDs from Google, Meta, Snapchat, and TikTok ads.
 */

export interface IAttributionData {
  ad_platform?: string;
  utm_source?: string;
  utm_medium?: string;
  utm_campaign?: string;
  utm_content?: string;
  utm_term?: string;
  click_id?: string;
  referrer_url?: string;
}

const STORAGE_KEY = "qamet_ad_attribution";

/**
 * Infer ad platform from UTM source or Click IDs
 */
export function inferAdPlatform(
  utmSource?: string | null,
  clickId?: string | null,
  referrer?: string | null
): string | undefined {
  const source = (utmSource || "").toLowerCase().trim();
  const click = (clickId || "").toLowerCase().trim();
  const ref = (referrer || "").toLowerCase().trim();

  if (
    source.includes("google") ||
    source.includes("adwords") ||
    source.includes("youtube") ||
    click.startsWith("gclid") ||
    ref.includes("google.")
  ) {
    return "google";
  }

  if (
    source.includes("instagram") ||
    source === "ig" ||
    source.includes("insta") ||
    ref.includes("instagram.com")
  ) {
    return "instagram";
  }

  if (
    source.includes("facebook") ||
    source === "fb" ||
    click.startsWith("fbclid") ||
    ref.includes("facebook.com")
  ) {
    return "facebook";
  }

  if (source.includes("meta")) {
    return "meta";
  }

  if (source.includes("snap") || click.startsWith("sccid") || ref.includes("snapchat.com")) {
    return "snapchat";
  }

  if (
    source.includes("tiktok") ||
    source.includes("tik_tok") ||
    click.startsWith("ttclid") ||
    ref.includes("tiktok.com")
  ) {
    return "tiktok";
  }

  return source || undefined;
}

/**
 * Initialize attribution by scanning the current URL search params.
 * Call this on application startup.
 */
export function initAttribution(): IAttributionData | null {
  if (typeof window === "undefined") return null;

  try {
    const params = new URLSearchParams(window.location.search);

    const utm_source = params.get("utm_source");
    const utm_medium = params.get("utm_medium");
    const utm_campaign = params.get("utm_campaign");
    const utm_content = params.get("utm_content") || params.get("ad_id");
    const utm_term = params.get("utm_term");

    // Click IDs from various platforms
    const gclid = params.get("gclid");
    const fbclid = params.get("fbclid");
    const ttclid = params.get("ttclid");
    const sccid = params.get("sccid");

    const click_id = gclid || fbclid || ttclid || sccid || params.get("click_id") || undefined;
    const referrer_url = document.referrer || undefined;

    // Only update if there are attribution params in the URL
    if (utm_source || utm_campaign || click_id) {
      const ad_platform = inferAdPlatform(utm_source, click_id, referrer_url);

      const attributionData: IAttributionData = {
        ad_platform,
        utm_source: utm_source || undefined,
        utm_medium: utm_medium || undefined,
        utm_campaign: utm_campaign || undefined,
        utm_content: utm_content || undefined,
        utm_term: utm_term || undefined,
        click_id: click_id || undefined,
        referrer_url,
      };

      // Clean empty keys
      Object.keys(attributionData).forEach((key) => {
        if (!attributionData[key as keyof IAttributionData]) {
          delete attributionData[key as keyof IAttributionData];
        }
      });

      sessionStorage.setItem(STORAGE_KEY, JSON.stringify(attributionData));
      localStorage.setItem(STORAGE_KEY, JSON.stringify(attributionData));

      return attributionData;
    }
  } catch (err) {
    console.debug("[Attribution] Init error:", err);
  }

  return getAttributionData();
}

/**
 * Retrieve saved attribution data from session or local storage
 */
export function getAttributionData(): IAttributionData {
  if (typeof window === "undefined") return {};

  try {
    const raw = sessionStorage.getItem(STORAGE_KEY) || localStorage.getItem(STORAGE_KEY);
    if (raw) {
      return JSON.parse(raw);
    }
  } catch (err) {
    console.debug("[Attribution] Read error:", err);
  }

  return {};
}
