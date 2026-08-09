import { useTranslation } from "react-i18next";
import type { ICarBadgeProps } from "../../interfaces/ICarBadgeProps";

export default function CarBadge({
  num,
  name,
  year,
}: ICarBadgeProps) {
  const { i18n } = useTranslation();
  return (
    <div dir={i18n.dir()} className="flex min-w-[210px] items-center gap-3 rounded-2xl border border-[#d9e1ec] bg-white p-[14px_18px] shadow-md">
      <span className="flex h-9 w-9 items-center justify-center rounded-full bg-[#2ca7e0] font-bold text-white">
        {num}
      </span>
      <div>
        <strong className="mb-1 block text-[13px] text-gray-900">{name}</strong>
        {year && <p className="m-0 text-xs text-gray-500">{year}</p>}
      </div>
    </div>
  );
}
