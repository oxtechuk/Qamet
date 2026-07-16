import { useTranslation } from "react-i18next";
import type { ICompareSummaryProps } from "../../interfaces/ICompareSummaryProps";
import ScoreBadge from "./ScoreBadge";

export default function CompareSummary({
  sections,
  car1Name,
  car2Name,
}: ICompareSummaryProps) {
  const { t, i18n } = useTranslation();
  const car1Score = sections.reduce(
    (sum, s) => sum + s.rows.filter((r) => r.winner === 1).length,
    0,
  );
  const car2Score = sections.reduce(
    (sum, s) => sum + s.rows.filter((r) => r.winner === 2).length,
    0,
  );
  const maxScore = Math.max(car1Score, car2Score, 1);

  const bars = [
    { value: car1Score, color: "#2FA3DC" },
    { value: car2Score, color: "#FF652F" },
  ];

  return (
    <section dir={i18n.dir()} className="mx-auto w-full max-w-[1200px] px-4 pb-20">
      <div className="rounded-2xl bg-[#071426] px-7 py-8 text-white shadow-[0_8px_24px_rgba(15,23,42,0.18)]">
        <h2 className="mb-7 text-center text-2xl font-black">{t("comparePage.summaryTitle")}</h2>

        <div className="grid items-center gap-8 lg:grid-cols-[260px_1fr_260px]">
          <div className="flex flex-col items-start gap-3 max-lg:items-center">
            <span className="text-sm text-white/45">{t("comparePage.carOne")}</span>
            <h3 className="text-lg font-extrabold">{car1Name}</h3>
            <ScoreBadge score={car1Score} color="#2FA3DC" />
          </div>

          <div className="space-y-5">
            {bars.map((bar, i) => (
              <div key={i} className="flex items-center gap-3">
                <span className="w-5 text-sm font-bold text-white/55">
                  {bar.value}
                </span>
                <div className="h-3 flex-1 overflow-hidden rounded-full bg-[#263548]">
                  <div
                    className="h-full rounded-full"
                    style={{
                      width: `${(bar.value / maxScore) * 100}%`,
                      backgroundColor: bar.color,
                    }}
                  />
                </div>
              </div>
            ))}
          </div>

          <div className="flex flex-col items-end gap-3 max-lg:items-center">
            <span className="text-sm text-white/45">{t("comparePage.carTwo")}</span>
            <h3 className="text-lg font-extrabold">{car2Name}</h3>
            <ScoreBadge score={car2Score} color="#FF652F" />
          </div>
        </div>
      </div>
    </section>
  );
}
