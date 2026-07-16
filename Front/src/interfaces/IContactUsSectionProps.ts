import type { IContactFormValues } from "./IContactFormValues";
import type { ISelectOption } from "./ISelectOption";

export interface IContactUsSectionProps {
  eyebrow: string;
  title: string;
  description: string;
  countries?: ISelectOption[];
  isSubmitting?: boolean;
  onSubmit?: (values: IContactFormValues) => void;
}
