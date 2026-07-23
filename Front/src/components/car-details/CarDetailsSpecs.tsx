import { useState } from "react";
import { useTranslation } from "react-i18next";
import type { ISpecItem, ITab, ICarDetailsSpecsProps, IFeatureItem } from "../../interfaces/ICarDetailsSpecsProps";

export type { ISpecItem as SpecItem, ITab as Tab };

function SpecCard({ label, value }: { label: string; value: string | null | undefined }) {
  return (
    <div className="flex flex-col items-start justify-center gap-1.5 rounded-[12px] border border-[#F0F0EE] bg-white px-4 py-4 shadow-sm">
      <span className="text-[12px] text-[#9CA3AF]">{label}</span>
      <span className="text-[16px] font-extrabold text-[#111827]">
        {value ?? "—"}
      </span>
    </div>
  );
}

export default function CarDetailsSpecs({ tabs }: ICarDetailsSpecsProps) {
  const { i18n } = useTranslation();
  const [activeTab, setActiveTab] = useState(0);

  if (!tabs.length) return null;

  const currentTab = tabs[activeTab];

  return (
    <section
      className="mx-auto w-full max-w-7xl px-4 pb-14 sm:px-6 lg:px-8"
      dir={i18n.dir()}
    >
      {/* White card wrapping tabs + content */}
      <div className="overflow-hidden rounded-[20px] border border-[#F0F0EE] bg-white shadow-sm">

        {/* Tab bar — right-aligned text tabs with underline */}
        <div className="flex items-center justify-start gap-6 border-b border-[#F0F0EE] px-6 pt-4">
          {tabs.map((tab, i) => (
            <button
              key={i}
              type="button"
              onClick={() => setActiveTab(i)}
              className={[
                "pb-3 text-[15px] font-semibold transition",
                i === activeTab
                  ? "border-b-2 border-[var(--brand-secondary-color)] text-[#111827]"
                  : "text-[#9CA3AF] hover:text-[#374151]",
              ].join(" ")}
            >
              {tab.label}
            </button>
          ))}
        </div>

        {/* Cards grid */}
        <div className="grid grid-cols-3 gap-3 p-5 sm:grid-cols-4 lg:grid-cols-5">
          {currentTab.type === "specs" &&
            (currentTab.items as ISpecItem[]).map((item, i) => (
              <SpecCard key={i} label={item.label} value={item.value} />
            ))}

          {(currentTab.type === "safety" || currentTab.type === "other") &&
            (currentTab.items as (string | IFeatureItem)[]).map((item, i) => {
              if (typeof item === "string") {
                return <SpecCard key={i} label={item} value={null} />;
              }
              return <SpecCard key={i} label={item.name} value={item.value ?? null} />;
            })}
        </div>
      </div>
    </section>
  );
}
