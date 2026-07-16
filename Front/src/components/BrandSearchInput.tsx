import { Search } from "lucide-react";
import type { IBrandSearchInputProps } from "../interfaces/IBrandSearchInputProps";

export default function BrandSearchInput({
  value,
  onChange,
  placeholder,
  dir: direction,
}: IBrandSearchInputProps) {
  const isRTL = direction === "rtl";

  return (
    <div className="relative w-full lg:max-w-[430px]">
      <input
        type="text"
        value={value}
        onChange={(e) => onChange(e.target.value)}
        placeholder={placeholder}
        className={`h-[54px] w-full rounded-full border border-[#8DB5EE] bg-transparent px-6 text-[15px] text-[#111827] outline-none placeholder:text-[#7A97C7] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.18)] ${isRTL ? "pr-14" : "pl-14"}`}
      />
      <Search
        size={22}
        className={`absolute ${isRTL ? "right-5" : "left-5"} top-1/2 -translate-y-1/2 text-[#5F8FD7]`}
      />
    </div>
  );
}
