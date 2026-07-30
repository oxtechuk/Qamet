import { useTranslation } from "react-i18next";
import type { ILoadingSlotProps } from "../../interfaces/ILoadingSlotProps";

export default function LoadingSlot({}: ILoadingSlotProps) {
  const { t, i18n } = useTranslation();
  return (
    <div dir={i18n.dir()} className="flex min-h-[300px] w-full animate-pulse items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50">
      <div className="text-center">
        <div className="mx-auto mb-4 flex h-[70px] w-[70px] items-center justify-center rounded-full bg-gray-200">
          <div className="h-6 w-6 animate-spin rounded-full border-2 border-gray-300 border-t-gray-500" />
        </div>
        <p className="text-sm font-semibold text-gray-400">{t("comparePage.loading")}</p>
      </div>
    </div>
  );
}
