import { useTranslation } from "react-i18next";
import { ShieldCheck, Clock, CheckCircle } from "lucide-react";
import type { IOrderPageTrustBadge } from "../../interfaces/IOrderPageTrustBadge";

const TRUST_BADGES: IOrderPageTrustBadge[] = [
    { icon: ShieldCheck, titleKey: "ordersPage.trustProtected.title", subKey: "ordersPage.trustProtected.sub" },
    { icon: Clock, titleKey: "ordersPage.trustResponse.title", subKey: "ordersPage.trustResponse.sub" },
    { icon: CheckCircle, titleKey: "ordersPage.trustPrice.title", subKey: "ordersPage.trustPrice.sub" },
];

export default function TrustBadges() {
    const { t } = useTranslation();

    return (
        <div className="mx-auto mt-10 grid max-w-5xl grid-cols-1 gap-4 sm:grid-cols-3">
            {TRUST_BADGES.map(({ icon: Icon, titleKey, subKey }) => (
                <div
                    key={titleKey}
                    className="flex items-center gap-3 rounded-[14px] border border-[#E5E7EB] bg-white px-5 py-4 shadow-sm"
                >
                    <Icon
                        size={20}
                        className="shrink-0 text-[var(--brand-primary-color)]"
                    />
                    <div>
                        <p className="text-[14px] font-bold text-[#111827]">
                            {t(titleKey)}
                        </p>
                        <p className="text-[12px] text-[#9CA3AF]">
                            {t(subKey)}
                        </p>
                    </div>
                </div>
            ))}
        </div>
    );
}
