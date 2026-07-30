import type { ReactNode } from "react";

export interface IFormFieldProps {
  label: string;
  required?: boolean;
  children: ReactNode;
}
