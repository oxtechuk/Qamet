import { useTranslation } from "react-i18next";
import type { IEmptySlotProps } from "../../interfaces/IEmptySlotProps";

export default function EmptySlot({ onClick }: IEmptySlotProps) {
  const { t, i18n } = useTranslation();
  return (
    <button
      type="button"
      onClick={onClick}
      dir={i18n.dir()}
      className="flex min-h-[300px] w-full cursor-pointer items-center justify-center rounded-2xl border-2 border-dashed border-[#cfd6df] bg-white transition-all hover:border-[#35aee8] hover:bg-blue-50/30"
    >
      <div className="text-center">
        <div className="mx-auto mb-4 flex h-[70px] w-[70px] items-center justify-center rounded-full bg-gray-100">
          <span className="text-3xl text-gray-400">+</span>
        </div>
        <p className="text-sm font-semibold text-gray-500">
          {t("comparePage.addCar")}
        </p>
      </div>
    </button>
  );
}
