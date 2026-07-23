import type { ReactNode } from "react";
import { BiLogoFacebook, BiLogoInstagram, BiLogoTiktok, BiLogoTwitter, BiLogoLinkedin, BiLogoYoutube } from "react-icons/bi";

const iconMap: Record<string, ReactNode> = {
  // API platform names
  "facebook":  <BiLogoFacebook size={22} />,
  "instagram": <BiLogoInstagram size={22} />,
  "tiktok":    <BiLogoTiktok size={22} />,
  "twitter":   <BiLogoTwitter size={22} />,
  "x":         <BiLogoTwitter size={22} />,
  "linkedin":  <BiLogoLinkedin size={22} />,
  "youtube":   <BiLogoYoutube size={22} />,
  // legacy bi- class names
  "bi-facebook":  <BiLogoFacebook size={22} />,
  "bi-instagram": <BiLogoInstagram size={22} />,
  "bi-tiktok":    <BiLogoTiktok size={22} />,
  "bi-twitter":   <BiLogoTwitter size={22} />,
  "bi-linkedin":  <BiLogoLinkedin size={22} />,
  "bi-youtube":   <BiLogoYoutube size={22} />,
};

export function getSocialIcon(iconClass: string): ReactNode | null {
  return iconMap[iconClass?.toLowerCase()] ?? null;
}
