import type { ReactNode } from "react";
export interface IBgImageMaskedSectionProps {
  imageSrc: string;
  children?: ReactNode;
  dir?: "rtl" | "ltr";
  className?: string;
  contentClassName?: string;
}
