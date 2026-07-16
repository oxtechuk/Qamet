import type { ReactNode } from "react";
import { BiLogoFacebook, BiLogoInstagram, BiLogoTiktok, BiLogoTwitter, BiLogoLinkedin, BiLogoYoutube } from "react-icons/bi";

const iconMap: Record<string, ReactNode> = {
  "bi-facebook": <BiLogoFacebook size={22} />,
  "bi-instagram": <BiLogoInstagram size={22} />,
  "bi-tiktok": <BiLogoTiktok size={22} />,
  "bi-twitter": <BiLogoTwitter size={22} />,
  "bi-linkedin": <BiLogoLinkedin size={22} />,
  "bi-youtube": <BiLogoYoutube size={22} />,
};

export function getSocialIcon(iconClass: string): ReactNode | null {
  return iconMap[iconClass] ?? null;
}
