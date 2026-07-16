import { useState } from "react";
import { useTranslation } from "react-i18next";
import type { ICompareTableProps } from "../../interfaces/ICompareTableProps";
import WinnerValue from "./WinnerValue";

const sectionPalette = [
  { color: "#00C853", bgColor: "#ECFFF4" },
  { color: "#8B3DF4", bgColor: "#FBF5FF" },
  { color: "#FF7A2F", bgColor: "#FFF7EE" },
  { color: "#2196F3", bgColor: "#F0F7FF" },
  { color: "#FF5722", bgColor: "#FFF3F0" },
];

export default function CompareTable({
  sections,
  car1Name,
  car2Name,
}: ICompareTableProps) {
  const { t, i18n } = useTranslation();
  const isRTL = i18n.dir() === "rtl";

  if (!sections.length) return null;

  const tabs = [...new Set(sections.map((s) => s.title))];
  const [activeTab, setActiveTab] = useState("all");

  const tableSections = sections
    .filter((s) => activeTab === "all" || s.title === activeTab)
    .map((s, i) => ({
      title: s.title,
      ...sectionPalette[i % sectionPalette.length],
      rows: s.rows.map((r) => ({
        label: r.label,
        carOneValue: r.val1,
        carTwoValue: r.val2,
        winner:
          r.winner === 1
            ? ("carOne" as const)
            : r.winner === 2
              ? ("carTwo" as const)
              : undefined,
      })),
    }));

  return (
    <section
      dir={i18n.dir()}
      className="mx-auto w-full max-w-[1200px] px-4 pb-20"
    >
      <div className="overflow-hidden rounded-2xl bg-white shadow-[0_6px_18px_rgba(15,23,42,0.12)]">
        <div className="bg-[#2FA3DC] px-6 py-6 text-white">
          <div className="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
              <h2 className="text-2xl font-black">
                {t("comparePage.compareTable")}
              </h2>
              <p className="mt-2 text-sm text-white/80">
                {t("comparePage.compareDescription")}
              </p>
            </div>
            <div className="flex flex-wrap gap-3">
              <button
                key="all"
                type="button"
                onClick={() => setActiveTab("all")}
                className={`rounded-full border px-5 py-2 text-sm font-bold backdrop-blur-sm transition ${
                  activeTab === "all"
                    ? "border-white bg-white/20 text-white"
                    : "border-white/40 bg-white/10 text-white/80 hover:bg-white/20"
                }`}
              >
                {t("comparePage.all")}
              </button>
              {tabs.map((tab) => (
                <button
                  key={tab}
                  type="button"
                  onClick={() => setActiveTab(tab)}
                  className={`rounded-full border px-5 py-2 text-sm font-bold backdrop-blur-sm transition ${
                    activeTab === tab
                      ? "border-white bg-white/20 text-white"
                      : "border-white/40 bg-white/10 text-white/80 hover:bg-white/20"
                  }`}
                >
                  {tab}
                </button>
              ))}
            </div>
          </div>
        </div>

        <div className="grid grid-cols-[1fr_1.4fr_1.4fr] border-t border-[#DDE5EF] bg-white text-sm font-extrabold text-[#111827] max-md:grid-cols-[1fr_1fr_1fr]">
          <div className={`flex min-h-[56px] items-center bg-[#F4F8FC] px-5 text-[#667085] justify-start ${isRTL ? "border-r" : "border-l"} border-[#DDE5EF]`}>
            {t("comparePage.specLabel")}
          </div>
          <div className={`flex min-h-[56px] items-center justify-center gap-2 px-5 text-center ${isRTL ? "border-r" : "border-l"} border-[#DDE5EF]`}>
            <span className="h-3 w-3 shrink-0 rounded-full bg-[#2FA3DC]" />
            <span className="line-clamp-1">{car1Name}</span>
          </div>
          <div className="flex min-h-[56px] items-center justify-center gap-2 px-5 text-center">
            <span className="h-3 w-3 shrink-0 rounded-full bg-[#F05A28]" />
            <span className="line-clamp-1">{car2Name}</span>
          </div>
        </div>
      </div>

      <div className="mt-5 space-y-5">
        {tableSections.map((section, si) => (
          <div
            key={`${section.title}-${si}`}
            className="overflow-hidden rounded-2xl border border-[#DDE5EF] bg-white shadow-[0_3px_10px_rgba(15,23,42,0.08)]"
          >
            <div
              className="flex min-h-[58px] items-center justify-start border-b px-7"
              style={{
                backgroundColor: section.bgColor,
                borderColor: section.color + "33",
              }}
            >
              <div className={`flex items-center gap-4 ${isRTL ? "flex-row-reverse" : ""}`}>
                <h3 className="text-xl font-black text-[#111827]">
                  {section.title}
                </h3>
                <span
                  className="h-8 w-2 rounded-full"
                  style={{ backgroundColor: section.color }}
                />
              </div>
            </div>

            <div>
              {section.rows.map((row, ri) => (
                <div
                  key={row.label}
                  className={`grid min-h-[62px] grid-cols-[1fr_1.4fr_1.4fr] border-b border-[#EEF2F6] text-sm last:border-b-0 max-md:grid-cols-[1fr_1fr_1fr] ${
                    ri % 2 === 0 ? "bg-white" : "bg-[#FAFBFC]"
                  }`}
                >
                  <div className={`flex items-center bg-[#F2F7FD] px-6 font-extrabold text-[#111827] justify-start`}>
                    {row.label}
                  </div>
                  <div className={`px-4 ${isRTL ? "border-r" : "border-l"} border-[#EEF2F6] ${row.winner === "carOne" ? "bg-[#ECFFF4]" : ""}`}>
                    <WinnerValue
                      value={row.carOneValue}
                      isWinner={row.winner === "carOne"}
                    />
                  </div>
                  <div
                    className={`px-4 ${row.winner === "carTwo" ? "bg-[#ECFFF4]" : ""}`}
                  >
                    <WinnerValue
                      value={row.carTwoValue}
                      isWinner={row.winner === "carTwo"}
                    />
                  </div>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>
    </section>
  );
}
