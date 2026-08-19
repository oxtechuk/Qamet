import { API_ORIGIN } from "./axios.constants";

function getBase() {
  const envBase = import.meta.env.BASE_URL ?? "/";
  if (typeof window !== "undefined") {
    const currentPath = window.location.pathname;
    const cleanEnv = envBase.replace(/\/+$/, "");
    if (cleanEnv && cleanEnv !== "/" && currentPath.toLowerCase().startsWith(cleanEnv.toLowerCase())) {
      const matched = currentPath.slice(0, cleanEnv.length);
      return matched.endsWith("/") ? matched : `${matched}/`;
    }
  }
  return envBase.endsWith("/") ? envBase : `${envBase}/`;
}

const cleanBase = getBase();

const STORAGE_PREFIX = API_ORIGIN ? `${API_ORIGIN}/storage/` : `${cleanBase}storage/`;

export function getImageUrl(path: string | null): string {
  if (!path) return "";
  if (path.startsWith("http://") || path.startsWith("https://")) {
    try {
      const url = new URL(path);
      if (url.hostname === "localhost" || url.hostname === "127.0.0.1") {
        return url.pathname;
      }
    } catch {
      // Fallthrough
    }
    return path.replace(/([^:]\/)\//g, "$1");
  }
  return `${STORAGE_PREFIX}${path}`;
}

export const APP_IMAGES = {
  LOGO: `${cleanBase}images/logo_without_bg.svg`,
  LOGO_WHITE: `${cleanBase}images/logo_without_bg_white.svg`,
  HOME_HERO: `${cleanBase}images/home_hero.png`,
  EID: `${cleanBase}images/eid.png`,
  CAR1: `${cleanBase}images/car1.png`,
  CAR_PLACEHOLDER: `${cleanBase}images/car-placeholder.png`,
  BRAND_PLACEHOLDER: `${cleanBase}images/brand-placeholder.svg`,
  RIYAL: `${cleanBase}images/riyal.svg`,
  CAR_ICON: `${cleanBase}images/car icons/car.svg`,
  FUEL_ICON: `${cleanBase}images/car icons/fuel.svg`,
  GEARBOX_ICON: `${cleanBase}images/car icons/tabler_manual-gearbox.svg`,
  SEAT_ICON: `${cleanBase}images/car icons/seat.svg`,
  BG_IMAGE: `${cleanBase}images/offers-section-bg.png`,
  ALL_CARS_OFFER_IMAGE: `${cleanBase}images/all-cars-offer-page.png`,
  COMPARE_IMAGE: `${cleanBase}images/compre-image.png`,
  OFFER1: `${cleanBase}images/offer1.png`,
  OFFER_PLACEHOLDER: `${cleanBase}images/offer1.png`,
  BLOG_PLACEHOLDER: `${cleanBase}images/blog.png`,
  BLOG_AUTHOR_PLACEHOLDER: `${cleanBase}images/blogs/author.png`,
  AVATAR_PLACEHOLDER: `${cleanBase}images/avatar.png`,
  LOCATION_PLACEHOLDER: `${cleanBase}images/locations/riyadh.png`,
  SOCIAL_TIKTOK: `${cleanBase}images/social/tiktok.png`,
  SOCIAL_FACEBOOK: `${cleanBase}images/social/facebook.png`,
  SOCIAL_INSTAGRAM: `${cleanBase}images/social/instagram.png`,
  GALLERY_G1: `${cleanBase}images/g1.png`,
  GALLERY_G2: `${cleanBase}images/g2.png`,
  GALLERY_G3: `${cleanBase}images/g3.png`,
  GALLERY_G4: `${cleanBase}images/g4.png`,

} as const;
