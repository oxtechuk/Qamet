import { Clock3, MessageCircle, Phone } from "lucide-react";
import { useTranslation } from "react-i18next";
import { useSettingsStore } from "../../store/settings.store";
import { formatWorkingHours } from "../../utils/format-time";
import type { IContactInfoCard } from "../../interfaces/IContactInfoCard";

export default function ContactMethodsSection() {
    const { i18n, t } = useTranslation();
    const settings = useSettingsStore((s) => s.settings);
    const contact = settings?.contact;
    const hours = settings?.working_hours;

    const whatsappNum = contact?.whatsapp?.replace(/\D/g, "") ?? "";
    const phone = contact?.phone ?? "";
    const phoneClean = phone.replace(/\s+/g, "");

    const days = hours?.days?.length
        ? hours.days.map((d) => t(`contactPage.contactMethods.days.${d}`)).join(", ")
        : t("contactPage.contactMethods.hoursDescription");

    const hoursValue = hours
        ? formatWorkingHours(hours.from, hours.to, t)
        : "";

    const cards: IContactInfoCard[] = [
        {
            id: "whatsapp",
            label: t("contactPage.contactMethods.whatsappLabel"),
            value: t("contactPage.contactMethods.whatsappValue"),
            description: t("contactPage.contactMethods.whatsappDescription"),
            href: whatsappNum ? `https://wa.me/${whatsappNum}` : undefined,
            icon: <MessageCircle size={31} strokeWidth={2} />,
            iconClassName: "bg-[#25D366] text-white",
        },
        {
            id: "phone",
            label: t("contactPage.contactMethods.phoneLabel"),
            value: phone,
            description: t("contactPage.contactMethods.phoneDescription"),
            href: phoneClean ? `tel:${phoneClean}` : undefined,
            icon: <Phone size={30} strokeWidth={1.9} />,
            iconClassName: "bg-[var(--brand-primary-color)] text-white",
        },
        {
            id: "hours",
            label: t("contactPage.contactMethods.hoursLabel"),
            value: hoursValue,
            description: days,
            icon: <Clock3 size={30} strokeWidth={1.9} />,
            iconClassName: "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]",
        },
    ];

    return (
        <section dir={i18n.dir()} className="w-full bg-[#FAFAF8] py-12 sm:py-16">
            <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
                <div className="text-end">
                    <h2 className="text-[34px] font-extrabold leading-tight text-[var(--brand-secondary-color)] sm:text-[42px]">
                        {t("contactPage.contactMethods.title")}
                    </h2>
                </div>

                <div className="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3 lg:gap-7">
                    {cards.map((card) => {
                        const content = (
                            <article
                                className={[
                                    "group flex min-h-[122px] items-center gap-5",
                                    "rounded-[18px] border border-[#E2E2DE] bg-white",
                                    "px-6 py-5",
                                    "shadow-[0_3px_10px_rgba(15,23,42,0.08)]",
                                    "transition duration-300",
                                    "hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(15,23,42,0.12)]",
                                ].join(" ")}
                            >
                                <div
                                    className={[
                                        "flex h-[54px] w-[54px] shrink-0 items-center justify-center",
                                        "rounded-[16px]",
                                        "transition duration-300 group-hover:scale-105",
                                        card.iconClassName,
                                    ].join(" ")}
                                >
                                    {card.icon}
                                </div>

                                <div className="min-w-0 text-start">
                                    <p className="text-[12px] font-medium text-[#6B7280]">
                                        {card.label}
                                    </p>
                                    <h3 className="mt-1 truncate text-[18px] font-extrabold text-[var(--brand-primary-color)] sm:text-[20px]">
                                        {card.value}
                                    </h3>
                                    <p className="mt-1 text-[13px] text-[#7B828C]">
                                        {card.description}
                                    </p>
                                </div>
                            </article>
                        );

                        if (!card.href) {
                            return <div key={card.id}>{content}</div>;
                        }

                        return (
                            <a
                                key={card.id}
                                href={card.href}
                                target={card.id === "whatsapp" ? "_blank" : undefined}
                                rel={card.id === "whatsapp" ? "noopener noreferrer" : undefined}
                                className="block"
                            >
                                {content}
                            </a>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
