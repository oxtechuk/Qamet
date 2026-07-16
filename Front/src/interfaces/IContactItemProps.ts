import type { ReactNode } from "react";

export interface IContactItemProps {
  label: string;
  value: string;
  icon: ReactNode;
  direction?: "ltr" | "rtl";
}
