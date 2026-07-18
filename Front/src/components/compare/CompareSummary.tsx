import { useNavigate } from "react-router-dom";
import { useTranslation } from "react-i18next";
import type { ICompareSummaryProps } from "../../interfaces/ICompareSummaryProps";

export default function CompareSummary({
  sections,
  car1Name,
  car2Name,
  car1Slug,
  car2Slug,
}: ICompareSummaryProps) {
  const navigate = useNavigate();
  const { t, i18n } = useTranslation();

  const car1Score = sections.reduce(
    (sum, s) => sum + s.rows.filter((r) => r.winner === 1).length,
    0,
  );
  const car2Score = sections.reduce(
    (sum, s) => sum + s.rows.filter((r) => r.winner === 2).length,
    0,
  );

  const winnerName = car1Score >= car2Score ? car1Name : car2Name;
  const winnerScore = Math.max(car1Score, car2Score);
  const loserScore = Math.min(car1Score, car2Score);
  const winnerSlug = car1Score >= car2Score ? car1Slug : car2Slug;

  return (
    <section dir={i18n.dir()} className="mx-auto w-full max-w-[1200px] px-4 pb-8">
      <div className="rounded-[20px] bg-[#021F38] px-8 py-8 text-center text-white">
        {/* Badge */}
        <p className="mb-2 text-[13px] font-semibold text-[var(--brand-secondary-color)]">
          {t("comparePage.summaryBadge")}
        </p>

        {/* Winner label */}
        <p className="text-[14px] text-white/60">{t("comparePage.winnerLabel")}</p>

        {/* Winner name */}
        <h2 className="mt-1 text-[28px] font-extrabold text-white md:text-[34px]">
          {winnerName}
        </h2>

        {/* Score */}
        <p className="mt-2 text-[15px] font-bold text-[var(--brand-secondary-color)]">
          {t("comparePage.winnerScore", { score: winnerScore })}
        </p>
        <p className="mt-0.5 text-[13px] text-white/50">
          {t("comparePage.winnerScoreDetail", { winner: winnerScore, loser: loserScore })}
        </p>

        {/* Buttons */}
        <div className="mt-6 flex items-center justify-center gap-3">
          <button
            type="button"
            onClick={() => winnerSlug && navigate(`/cars/${winnerSlug}`)}
            className="h-[56px] rounded-[16px] bg-[var(--brand-secondary-color)] px-6 text-[14px] font-bold text-[var(--brand-primary-color)] transition hover:opacity-90"
          >
            {t("comparePage.consultExpert")}
          </button>

          <button
            type="button"
            onClick={() => winnerSlug && navigate(`/cars/${winnerSlug}`)}
            className="h-[56px] rounded-[16px] border border-white/30 px-6 text-[14px] font-bold text-white transition hover:bg-white/10"
          >
            {t("comparePage.browseMore")}
          </button>
        </div>
      </div>
    </section>
  );
}
