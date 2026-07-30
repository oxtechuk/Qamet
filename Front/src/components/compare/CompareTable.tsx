import { useTranslation } from "react-i18next";
import type { ICompareTableProps } from "../../interfaces/ICompareTableProps";

export default function CompareTable({
    sections,
}: ICompareTableProps) {
    const { i18n, t } = useTranslation();

    if (!sections.length) return null;

    return (
        <section
            dir={i18n.dir()}
            className="mx-auto w-full max-w-[1200px] px-4 pb-20 space-y-5"
        >
            {sections.map((section, si) => (
                <div
                    key={`${section.title}-${si}`}
                    className="overflow-hidden rounded-[16px] border border-[#E5E7EB] bg-white shadow-sm"
                >
                    {/* Section header */}
                    <div className="flex min-h-[48px] items-center justify-start px-6 bg-[#021F38]">
                        <h3 className="text-[15px] font-bold text-white">
                            {section.title}
                        </h3>
                    </div>

                    {/* Rows */}
                    {section.rows.map((row, ri) => {
                        const car1Winner = row.winner === 1;
                        const car2Winner = row.winner === 2;

                        return (
                            <div
                                key={`${row.label}-${ri}`}
                                className={[
                                    "grid min-h-[70px] grid-cols-3 border-b border-[#F0F2F5] last:border-b-0",
                                    ri % 2 === 0 ? "bg-white" : "bg-[#FAFAFA]",
                                ].join(" ")}
                            >
                                {/* Car 1 value */}
                                <div className="flex flex-col items-center justify-center gap-1 border-e border-[#F0F2F5] px-4 text-center">
                                    <span
                                        className={[
                                            "text-[15px] font-extrabold",
                                            car1Winner
                                                ? "text-[var(--brand-secondary-color)]"
                                                : "text-[#021F38]",
                                        ].join(" ")}
                                    >
                                        {row.val1}
                                    </span>
                                    {car1Winner && (
                                        <span className="flex items-center gap-1 rounded-full bg-[var(--brand-secondary-color)] px-2.5 py-0.5 text-[11px] font-bold text-[var(--brand-primary-color)]">
                                            ✓ {t("comparePage.best")}
                                        </span>
                                    )}
                                </div>

                                {/* Label — center */}
                                <div className="flex items-center justify-center px-3 text-center bg-[#F0F2F5]">
                                    <span className="rounded-[8px] px-3 py-1.5 text-[13px] text-[#5B6572]">
                                        {row.label}
                                    </span>
                                </div>

                                {/* Car 2 value */}
                                <div className="flex flex-col items-center justify-center gap-1 border-s border-[#F0F2F5] px-4 text-center">
                                    <span
                                        className={[
                                            "text-[15px] font-extrabold",
                                            car2Winner
                                                ? "text-[var(--brand-secondary-color)]"
                                                : "text-[#021F38]",
                                        ].join(" ")}
                                    >
                                        {row.val2}
                                    </span>
                                    {car2Winner && (
                                        <span className="flex items-center gap-1 rounded-full bg-[var(--brand-secondary-color)] px-2.5 py-0.5 text-[11px] font-bold text-[var(--brand-primary-color)]">
                                            ✓ {t("comparePage.best")}
                                        </span>
                                    )}
                                </div>
                            </div>
                        );
                    })}
                </div>
            ))}
        </section>
    );
}
