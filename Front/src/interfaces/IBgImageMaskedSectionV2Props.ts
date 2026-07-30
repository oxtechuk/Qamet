import type { ReactNode } from "react";
export interface IBgImageMaskedSectionV2Props {
  backgroundSrc: string;
  imageSrc: string;
  children?: ReactNode;
  dir?: "rtl" | "ltr";
  className?: string;
  contentClassName?: string;
}
