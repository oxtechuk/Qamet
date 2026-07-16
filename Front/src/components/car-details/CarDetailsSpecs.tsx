import { useState } from "react";
import { useTranslation } from "react-i18next";
import { CircleCheck } from "lucide-react";
import type { ISpecItem, ITab, ICarDetailsSpecsProps, IFeatureItem } from "../../interfaces/ICarDetailsSpecsProps";

export type { ISpecItem as SpecItem, ITab as Tab };

export default function CarDetailsSpecs({ tabs }: ICarDetailsSpecsProps) {
  const { t, i18n } = useTranslation();
  const [activeTab, setActiveTab] = useState(0);

  if (!tabs.length) return null;

  const currentTab = tabs[activeTab];

  return (
    <section
      className="mx-auto w-full max-w-7xl px-4 pb-14 sm:px-6 lg:px-8"
      dir={i18n.dir()}
    >
      <div className="mb-10 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
        <h2 className="text-2xl font-extrabold sm:text-3xl">
          <span className="text-[var(--brand-primary-color)]">{t("carDetails.specs.titleBlue")}</span>
          <span className="text-[var(--brand-secondary-color)]">{t("carDetails.specs.titleOrange")}</span>
        </h2>

        <div className="flex gap-1 rounded-2xl border border-gray-100 bg-white p-1.5 shadow-sm">
          {tabs.map((tab, i) => (
            <button
              key={i}
              type="button"
              onClick={() => setActiveTab(i)}
              className={`rounded-xl px-5 py-2.5 text-[14px] font-bold transition ${
                i === activeTab
                  ? "bg-[#FDECEA] text-[var(--brand-secondary-color)]"
                  : "bg-transparent text-[#9ca3af]"
              }`}
            >
              {tab.label}
            </button>
          ))}
        </div>
      </div>

      <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {currentTab.type === "specs" &&
          (currentTab.items as ISpecItem[]).map((item, i) => (
            <div
              key={i}
              className="flex items-center justify-between gap-3 rounded-2xl border border-gray-100 bg-white px-5 py-4 shadow-sm"
            >
              <span className="text-right text-sm font-bold text-[var(--brand-secondary-color)]">
                {item.label}
              </span>
              <span className="text-left text-sm font-medium text-gray-600">
                {item.value}
              </span>
            </div>
          ))}

        {currentTab.type === "safety" &&
          (currentTab.items as (string | IFeatureItem)[]).map((item, i) => {
            const isFeature = typeof item !== "string";
            return (
              <div
                key={i}
                className="flex items-center justify-between gap-3 rounded-2xl border border-gray-100 bg-white px-5 py-4 shadow-sm"
              >
                <div className="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-[var(--brand-secondary-color)] text-base">
                  {isFeature ? item.icon : <CircleCheck size={18} className="text-white" />}
                </div>
                <span className="flex-1 text-right text-sm font-semibold text-[#1f2937]">
                  {isFeature ? item.name : item}
                </span>
              </div>
            );
          })}

        {currentTab.type === "other" &&
          (currentTab.items as (string | IFeatureItem)[]).map((item, i) => {
            const isFeature = typeof item !== "string";
            return (
              <div
                key={i}
                className="flex items-center justify-between gap-3 rounded-2xl border border-gray-100 bg-white px-5 py-4 shadow-sm"
                style={{ borderRight: "3px solid var(--brand-secondary-color)" }}
              >
                <div className="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-[var(--brand-secondary-color)]">
                  <CircleCheck size={18} className="text-white" />
                </div>
                <span className="flex-1 text-right text-sm font-semibold text-[#1f2937]">
                  {isFeature ? item.name : item}
                </span>
              </div>
            );
          })}
      </div>
    </section>
  );
}
