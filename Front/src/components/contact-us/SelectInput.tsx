import { ChevronDown } from "lucide-react";
import type { ISelectInputProps } from "../../interfaces/ISelectInputProps";

const inputClasses =
  "h-[56px] w-full rounded-[6px] border border-[#D5DBE3] bg-[#F3F6F8] px-[18px] text-[15px] font-medium text-[#07111F] outline-none transition placeholder:text-[#8A8F99] focus:border-[var(--brand-primary-color)] focus:ring-4 focus:ring-[rgba(41,155,224,0.18)]";

export default function SelectInput({ value, options, onChange }: ISelectInputProps) {
  return (
    <div className="relative">
      <select
        value={value}
        onChange={(event) => onChange(event.target.value)}
        className={`${inputClasses} appearance-none ps-12`}
      >
        <option value=""></option>
        {options.map((option) => (
          <option key={option.value} value={option.value}>
            {option.label}
          </option>
        ))}
      </select>
      <ChevronDown
        size={18}
        className="pointer-events-none absolute start-4 top-1/2 -translate-y-1/2 text-[#8A8F99]"
      />
    </div>
  );
}
