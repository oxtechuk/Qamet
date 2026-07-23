import type { ReactNode } from "react";

export interface IOrderPagePaymentOption {
  value: "cash" | "bank";
  labelKey: string;
  icon: ReactNode;
}
