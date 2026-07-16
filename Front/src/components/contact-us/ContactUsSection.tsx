import { useState } from "react";
import { useTranslation } from "react-i18next";
import { Send } from "lucide-react";
import FormField from "./FormField";
import SelectInput from "./SelectInput";
import type { IContactFormValues } from "../../interfaces/IContactFormValues";
import type { IContactUsSectionProps } from "../../interfaces/IContactUsSectionProps";

const defaultCountries = [
  { label: "السعودية", value: "saudi-arabia" },
  { label: "الإمارات", value: "uae" },
  { label: "الكويت", value: "kuwait" },
  { label: "قطر", value: "qatar" },
];

const inputClasses =
  "h-[56px] w-full rounded-[6px] border border-[#D5DBE3] bg-[#F3F6F8] px-[18px] text-[15px] font-medium text-[#07111F] outline-none transition placeholder:text-[#8A8F99] focus:border-[var(--brand-primary-color)] focus:ring-4 focus:ring-[rgba(41,155,224,0.18)]";

export default function ContactUsSection({
  eyebrow,
  title,
  description,
  countries = defaultCountries,
  isSubmitting,
  onSubmit,
}: IContactUsSectionProps) {
  const { i18n, t } = useTranslation();
  const [values, setValues] = useState<IContactFormValues>({
    fullName: "",
    email: "",
    phone: "",
    country: "",
    subject: "",
    message: "",
  });

  const maxMessageLength = 500;

  const updateField = <K extends keyof IContactFormValues>(
    key: K,
    value: IContactFormValues[K],
  ) => {
    setValues((prev) => ({
      ...prev,
      [key]: value,
    }));
  };

  const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    onSubmit?.(values);
  };

  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-16">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:items-start">
          <div className="lg:col-span-3">
            <div className="mb-8 flex items-center justify-center gap-5 lg:justify-start">
              <span className="h-px w-[72px] bg-[var(--brand-primary-color)]" />
              <span className="text-[15px] font-bold text-[var(--brand-primary-color)]">
                {eyebrow}
              </span>
              <span className="h-px w-[72px] bg-[var(--brand-primary-color)]" />
            </div>

            <h1 className="text-center text-[32px] font-extrabold leading-tight text-[#07111F] md:text-[40px] lg:text-start">
              {title}
            </h1>

            <p className="mt-8 text-center text-[18px] leading-9 text-[#5F6672] lg:text-start">
              {description}
            </p>
          </div>

          <div className="lg:col-span-9">
            <form
              onSubmit={handleSubmit}
              className="rounded-[16px] bg-white px-6 py-8 shadow-sm md:px-10 md:py-10"
            >
              <div className="grid grid-cols-1 gap-7 md:grid-cols-2">
                <FormField label={t("contactPage.contactUs.fullNameLabel")} required>
                  <input
                    type="text"
                    value={values.fullName}
                    onChange={(event) =>
                      updateField("fullName", event.target.value)
                    }
                    placeholder={t("contactPage.contactUs.fullNamePlaceholder")}
                    className={inputClasses}
                  />
                </FormField>

                <FormField label={t("contactPage.contactUs.phoneLabel")} required>
                  <input
                    type="tel"
                    value={values.phone}
                    onChange={(event) =>
                      updateField("phone", event.target.value)
                    }
                    placeholder={t("contactPage.contactUs.phonePlaceholder")}
                    className={`${inputClasses} text-start`}
                    dir="ltr"
                  />
                </FormField>

                <FormField label={t("contactPage.contactUs.emailLabel")} required>
                  <input
                    type="email"
                    value={values.email}
                    onChange={(event) =>
                      updateField("email", event.target.value)
                    }
                    placeholder={t("contactPage.contactUs.emailPlaceholder")}
                    className={`${inputClasses} text-start`}
                    dir="ltr"
                  />
                </FormField>

                <FormField label={t("contactPage.contactUs.countryLabel")} required>
                  <SelectInput
                    value={values.country}
                    options={countries}
                    onChange={(value) => updateField("country", value)}
                  />
                </FormField>
              </div>

              <div className="mt-7">
                <FormField label={t("contactPage.contactUs.subjectLabel")} required>
                  <input
                    type="text"
                    value={values.subject}
                    onChange={(event) =>
                      updateField("subject", event.target.value)
                    }
                    placeholder={t("contactPage.contactUs.subjectPlaceholder")}
                    className={inputClasses}
                  />
                </FormField>
              </div>

              <div className="mt-9">
                <FormField label={t("contactPage.contactUs.messageLabel")} required>
                  <textarea
                    value={values.message}
                    maxLength={maxMessageLength}
                    onChange={(event) =>
                      updateField("message", event.target.value)
                    }
                    placeholder={t("contactPage.contactUs.messagePlaceholder")}
                    className={`${inputClasses} min-h-[150px] resize-none py-5 leading-7`}
                  />
                </FormField>

                <div className="mt-2 text-start text-[13px] text-[#8A8F99]">
                  {values.message.length} / {maxMessageLength} {t("contactPage.contactUs.charCount")}
                </div>
              </div>

              <button
                type="submit"
                disabled={isSubmitting}
                className="mt-6 flex h-[56px] w-full items-center justify-center gap-2 rounded-[8px] bg-[var(--brand-primary-color)] text-[18px] font-bold text-white transition hover:opacity-90 disabled:opacity-50"
              >
                <Send size={20} />
                {isSubmitting
                  ? t("contactPage.contactUs.submittingText")
                  : t("contactPage.contactUs.submitText")}
              </button>

              <p className="mt-5 text-center text-[13px] text-[#B2B8C2]">
                {t("contactPage.contactUs.privacyNotice")}
              </p>
            </form>
          </div>
        </div>
      </div>
    </section>
  );
}
