export interface ISelectOption {
  label: string;
  value: string;
}

export interface ISelectProps {
  placeholder?: string;
  value: string;
  onChange: (value: string) => void;
  options: ISelectOption[];
  icon?: React.ReactNode;
  className?: string;
  searchable?: boolean;
  chevronClassName?: string;
}
