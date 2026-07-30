import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import ContactUsSection from "../components/contact-us/ContactUsSection";
import FaqSection from "../components/contact-us/FaqSection";
import { getFaqs, getContactPageData } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { useSEO } from "../utils/useSEO";
import type { IFaqItem } from "../interfaces/IFaqItem";
import ContactMethodsSection from "../components/contact-us/ContactMethodsSection";

export default function ContactPage() {
    const { t } = useTranslation();
    useSEO(t("nav.contact"), t("contactPage.contactUs.description"));
    const language = useLanguageStore((s) => s.language);

    const { data: faqs } = useQuery<IFaqItem[]>({
        queryKey: ["faqs", language],
        queryFn: getFaqs,
    });

    const { data: contactData } = useQuery({
        queryKey: ["contact-page", language],
        queryFn: getContactPageData,
    });

    const branches = contactData?.data?.branches ?? [];

    return (
        <>
            <ContactMethodsSection />
            
            <ContactUsSection
                title={t("contactPage.contactUs.title")}
                description={t("contactPage.contactUs.description")}
                branches={branches}
            />

            <FaqSection faqs={faqs ?? []} />
        </>
    );
}
