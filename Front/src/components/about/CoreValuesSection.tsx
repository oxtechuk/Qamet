import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../../store/language.store";
import { resolveHeroicon } from "../../utils/heroicon-map";
import type { ReactNode } from "react";

export interface ICoreValueItem {
  id: string;
  title: string;
  description: string;
  icon: ReactNode;
}

interface ICoreValuesSectionProps {
  eyebrow?: string;
  title?: string;
  subtitle?: string;
  items?: { icon: string; title: string; description: string | null }[];
}

function FallbackValues({ t }: { t: (key: string) => string }): ICoreValueItem[] {
  return [
    { id: "trust", title: t("aboutPage.coreValues.values.trust.title"), description: t("aboutPage.coreValues.values.trust.description"), icon: null as unknown as ReactNode },
    { id: "quality", title: t("aboutPage.coreValues.values.quality.title"), description: t("aboutPage.coreValues.values.quality.description"), icon: null as unknown as ReactNode },
    { id: "speed", title: t("aboutPage.coreValues.values.speed.title"), description: t("aboutPage.coreValues.values.speed.description"), icon: null as unknown as ReactNode },
    { id: "care", title: t("aboutPage.coreValues.values.care.title"), description: t("aboutPage.coreValues.values.care.description"), icon: null as unknown as ReactNode },
  ];
}

const FALLBACK_ICONS = ["heroicon-o-shield-check", "heroicon-o-badge-check", "heroicon-o-bolt", "heroicon-o-user-group"];

export default function CoreValuesSection({
  eyebrow,
  title,
  items,
}: ICoreValuesSectionProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);

  const fallbackItems = FallbackValues({ t });

  const values: ICoreValueItem[] =
    items && items.length
      ? items.map((item, index) => ({
          id: `value-${index}`,
          title: item.title,
          description: item.description || fallbackItems[index]?.description || "",
          icon: (() => {
            const Icon = resolveHeroicon(item.icon);
            return <Icon size={28} strokeWidth={1.9} />;
          })(),
        }))
      : fallbackItems.map((item, index) => ({
          ...item,
          icon: (() => {
            const Icon = resolveHeroicon(FALLBACK_ICONS[index]);
            return <Icon size={28} strokeWidth={1.9} />;
          })(),
        }));

  return (
    <section
      dir={direction}
      className="w-full bg-[var(--brand-primary-color)] py-16 text-white sm:py-20 lg:py-24"
    >
      <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <p className="text-[12px] font-bold text-[var(--brand-secondary-color)] sm:text-[13px]">
            {eyebrow || t("aboutPage.coreValues.eyebrow")}
          </p>

          <h2 className="mt-3 text-[34px] font-extrabold leading-tight text-white sm:text-[42px] lg:text-[46px]">
            {title || t("aboutPage.coreValues.title")}
          </h2>
        </div>

        <div className="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:mt-16 lg:grid-cols-4 lg:gap-6">
          {values.map((value) => (
            <article
              key={value.id}
              className={[
                "group min-h-[180px] rounded-[16px]",
                "border border-white/10",
                "bg-white/[0.045]",
                "px-6 py-6 text-center",
                "shadow-[0_10px_30px_rgba(0,0,0,0.08)]",
                "transition duration-300",
                "hover:-translate-y-1 hover:border-white/20 hover:bg-white/[0.07]",
              ].join(" ")}
            >
              <div className="flex justify-center">
                <div
                  className={[
                    "flex h-[54px] w-[54px] items-center justify-center",
                    "rounded-[15px]",
                    "bg-[var(--brand-secondary-color)]",
                    "text-[var(--brand-primary-color)]",
                    "transition duration-300 group-hover:scale-105",
                  ].join(" ")}
                >
                  {value.icon}
                </div>
              </div>

              <h3 className="mt-5 text-[19px] font-extrabold text-white">
                {value.title}
              </h3>

              <p className="mx-auto mt-3 max-w-[230px] text-[13px] leading-7 text-white/50">
                {value.description}
              </p>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
