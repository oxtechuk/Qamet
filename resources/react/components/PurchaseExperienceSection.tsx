import { useTranslation } from "react-i18next";
import {
    BadgeDollarSign,
    Medal,
    SlidersHorizontal,
    ShieldCheck,
} from "lucide-react";
import type {
    IPurchaseFeature,
    IPurchaseExperienceSectionProps,
} from "../interfaces/IPurchaseExperienceSectionProps";
import { useLanguageStore } from "../store/language.store";

const FEATURE_ICONS = {
    finance: <ShieldCheck size={27} strokeWidth={1.8} />,
    ownership: <Medal size={27} strokeWidth={1.8} />,
    options: <SlidersHorizontal size={27} strokeWidth={1.8} />,
    prices: <BadgeDollarSign size={29} strokeWidth={1.8} />,
} as const;

export default function PurchaseExperienceSection({
    title,
    description,
}: IPurchaseExperienceSectionProps) {
    const { t } = useTranslation();
    const { direction } = useLanguageStore();
    const isRTL = direction === "rtl";

    const features: IPurchaseFeature[] = [
        {
            id: "finance",
            title: t("purchaseExperience.features.finance.title"),
            description: t("purchaseExperience.features.finance.description"),
            icon: FEATURE_ICONS.finance,
        },
        {
            id: "ownership",
            title: t("purchaseExperience.features.ownership.title"),
            description: t("purchaseExperience.features.ownership.description"),
            icon: FEATURE_ICONS.ownership,
        },
        {
            id: "options",
            title: t("purchaseExperience.features.options.title"),
            description: t("purchaseExperience.features.options.description"),
            icon: FEATURE_ICONS.options,
        },
        {
            id: "prices",
            title: t("purchaseExperience.features.prices.title"),
            description: t("purchaseExperience.features.prices.description"),
            icon: FEATURE_ICONS.prices,
        },
    ];

    return (
        <section
            dir={direction}
            className="w-full "
        >
            <div className="mx-auto max-w-[1440px] px-4 pb-20 sm:px-6 lg:px-8">
                {/* Heading */}
                <div
                    className="lg:max-w-[520px]"
                    style={{
                        textAlign: isRTL ? "right" : "left",
                        marginLeft: isRTL ? "auto" : undefined,
                        marginRight: isRTL ? undefined : "auto",
                    }}
                >
                    <h2 className="text-[30px] leading-tight text-[var(--brand-primary-color)] sm:text-[36px] lg:text-[40px]">
                        {title || t("purchaseExperience.title")}
                    </h2>

                    <p className="mt-3 text-[14px] leading-7 text-[#6F7175] sm:text-[15px]">
                        {description || t("purchaseExperience.description")}
                    </p>
                </div>

                {/* Features */}
                <div className="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:mt-14 lg:grid-cols-4">
                    {features.map((feature) => (
                        <article
                            key={feature.id}
                            className={[
                                "group min-h-[175px] rounded-[16px]",
                                "border border-[#D9D9D5] bg-white",
                                "px-6 pb-5 pt-4",
                                "shadow-[0_5px_16px_rgba(16,24,40,0.12)]",
                                "transition duration-300",
                                "hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(16,24,40,0.16)]",
                            ].join(" ")}
                        >
                            <div className="flex justify-start">
                                <div
                                    className={[
                                        "flex h-[52px] w-[52px] items-center justify-center",
                                        "rounded-[15px]",
                                        "bg-[var(--brand-secondary-color)]",
                                        "text-[var(--brand-primary-color)]",
                                        "transition duration-300 group-hover:scale-105",
                                    ].join(" ")}
                                >
                                    {feature.icon}
                                </div>
                            </div>

                            <h3 className="mt-4 text-[15px] font-semibold text-[var(--brand-primary-color)]">
                                {feature.title}
                            </h3>

                            <p className="mt-3 text-[14px] leading-7 text-[var(--brand-gray-color)]">
                                {feature.description}
                            </p>
                        </article>
                    ))}
                </div>
            </div>
        </section>
    );
}
