import type { ReactNode } from "react";

export interface IButtonProps {
  children: ReactNode;
  textColor?: string;
  bgColor?: string;
  to?: string;
  onClick?: () => void;
  className?: string;
}
