import { useTranslation } from "react-i18next";
import { Star } from "lucide-react";
import type { IScoreBadgeProps } from "../../interfaces/IScoreBadgeProps";

export default function ScoreBadge({ score, color }: IScoreBadgeProps) {
  const { t } = useTranslation();
  return (
    <div className="flex items-center gap-3">
      <div
        className="flex h-[54px] w-[54px] items-center justify-center rounded-full text-white"
        style={{ backgroundColor: color }}
      >
        <Star size={24} fill="white" />
      </div>
      <div className="flex items-end gap-2">
        <span className="text-5xl font-black leading-none" style={{ color }}>
          {score}
        </span>
        <span className="mb-1 text-sm text-white/55">{t("comparePage.points")}</span>
      </div>
    </div>
  );
}
