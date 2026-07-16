import type { ISelectOption } from "./ISelectOption";

export interface ISelectInputProps {
  value: string;
  options: ISelectOption[];
  onChange: (value: string) => void;
}
