import { useState, useCallback } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { toast } from "react-toastify";
import ContactUsSection from "../components/contact-us/ContactUsSection";
import FaqSection from "../components/contact-us/FaqSection";
import ContactCtaSection from "../components/ContactCtaSection";
import { submitContactForm, getFaqs } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { useSEO } from "../utils/useSEO";
import type { IFaqItem } from "../interfaces/IFaqItem";

export default function ContactPage() {
  const { t } = useTranslation();
  useSEO(t("nav.contact"), t("contactPage.contactUs.description"));
  const language = useLanguageStore((s) => s.language);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [formKey, setFormKey] = useState(0);

  const { data: faqs } = useQuery<IFaqItem[]>({
    queryKey: ["faqs", language],
    queryFn: getFaqs,
  });

  const handleSubmit = useCallback(
    async (values: { fullName: string; phone: string; email: string; subject: string; country: string; message: string }) => {
      setIsSubmitting(true);
      try {
        await submitContactForm({
          name: values.fullName,
          phone: values.phone,
          email: values.email,
          subject: values.subject,
          country: values.country,
          message: values.message,
        });
        toast.success(t("contactPage.contactUs.successToast"));
        setFormKey((k) => k + 1);
      } catch {
        toast.error(t("contactPage.contactUs.errorToast"));
      } finally {
        setIsSubmitting(false);
      }
    },
    [t],
  );

  return (
    <>
      <ContactUsSection
        key={formKey}
        eyebrow={t("contactPage.contactUs.eyebrow")}
        title={t("contactPage.contactUs.title")}
        description={t("contactPage.contactUs.description")}
        isSubmitting={isSubmitting}
        onSubmit={handleSubmit}
      />

      <FaqSection
        eyebrow={t("contactPage.faq.eyebrow")}
        titleBlack={t("contactPage.faq.titleBlack")}
        titleOrange={t("contactPage.faq.titleOrange")}
        description={t("contactPage.faq.description")}
        buttonText={t("contactPage.faq.buttonText")}
        buttonHref="/contact"
        faqs={faqs ?? []}
      />

      <ContactCtaSection
        badgeText={t("allCarsPage.contactBadge")}
        titleWhite={t("allCarsPage.contactTitleWhite")}
        titleOrange={t("allCarsPage.contactTitleOrange")}
        description={t("allCarsPage.contactDescription")}
        phoneText={t("allCarsPage.contactPhone")}
        phoneHref="tel:+966500000000"
        whatsappText={t("allCarsPage.contactWhatsapp")}
        
        sectionBgColor="var(--brand-CTA-BG-color)"
      />
    </>
  );
}
