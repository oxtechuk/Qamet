import { useTranslation } from "react-i18next";
import { SiWhatsapp } from "react-icons/si";
import { useSettingsStore } from "../../store/settings.store";
import type { IContactFormProps } from "../../interfaces/IContactFormProps";

const inputCls =
    "h-[52px] w-full rounded-[10px] border border-[#E5E7EB] bg-[#F9FAFB] px-4 text-[14px] text-[#111827] outline-none placeholder:text-[#9CA3AF] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.15)] transition";

export default function ContactForm({
    title,
    description,
    values,
    set,
    submitStatus,
    isSubmitting,
    onSubmit,
}: IContactFormProps) {
    const { t } = useTranslation();
    const settings = useSettingsStore((s) => s.settings);
    const whatsappNum = settings?.contact?.whatsapp?.replace(/\D/g, "") ?? "";
    const whatsappHref = `https://wa.me/${whatsappNum}`;

    const subjects = t("contactPage.contactUs.subjects", {
        returnObjects: true,
    }) as string[];

    return (
        <div className="rounded-[20px] border border-[#E5E7EB] bg-white px-6 py-8 shadow-sm">
            <h2 className="text-[24px] font-extrabold text-[#111827]">
                {title}
            </h2>
            <p className="mt-1 text-[14px] text-[#6B7280]">
                {description}
            </p>

            <form onSubmit={onSubmit} className="mt-6 space-y-5">
                <div className="grid grid-cols-2 gap-4">
                    <div>
                        <label className="mb-1.5 block text-[13px] font-medium text-[#374151]">
                            {t("contactPage.contactUs.fullNameLabel")}{" "}
                            <span className="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            value={values.fullName}
                            onChange={(e) => set("fullName", e.target.value)}
                            placeholder={t("contactPage.contactUs.fullNamePlaceholder")}
                            className={inputCls}
                            required
                        />
                    </div>
                    <div>
                        <label className="mb-1.5 block text-[13px] font-medium text-[#374151]">
                            {t("contactPage.contactUs.phoneLabel")}{" "}
                            <span className="text-red-500">*</span>
                        </label>
                        <input
                            type="tel"
                            value={values.phone}
                            onChange={(e) => set("phone", e.target.value)}
                            placeholder={t("contactPage.contactUs.phonePlaceholder")}
                            className={`${inputCls} text-end`}
                            dir="ltr"
                            required
                        />
                    </div>
                </div>

                <div>
                    <label className="mb-2 block text-[13px] font-medium text-[#374151]">
                        {t("contactPage.contactUs.subjectLabel")}{" "}
                        <span className="text-red-500">*</span>
                    </label>
                    <div className="flex flex-wrap gap-2">
                        {subjects.map((s) => (
                            <button
                                key={s}
                                type="button"
                                onClick={() => set("subject", s)}
                                className={[
                                    "h-[38px] rounded-[10px] border px-5 text-[13px] font-medium transition",
                                    values.subject === s
                                        ? "border-[var(--brand-primary-color)] bg-[var(--brand-primary-color)] text-white"
                                        : "border-[#E5E7EB] bg-white text-[#374151] hover:border-[var(--brand-primary-color)]",
                                ].join(" ")}
                            >
                                {s}
                            </button>
                        ))}
                    </div>
                </div>

                <div>
                    <label className="mb-1.5 block text-[13px] font-medium text-[#374151]">
                        {t("contactPage.contactUs.messageLabel")}{" "}
                        <span className="text-red-500">*</span>
                    </label>
                    <textarea
                        value={values.message}
                        onChange={(e) => set("message", e.target.value)}
                        placeholder={t("contactPage.contactUs.messagePlaceholder")}
                        rows={4}
                        className={`${inputCls} h-auto resize-none py-3 leading-7`}
                        required
                    />
                </div>

                <button
                    type="submit"
                    disabled={isSubmitting}
                    className="flex h-[52px] w-full items-center justify-center rounded-[12px] bg-[#9CA3AF] text-[15px] font-bold text-white transition hover:opacity-90 disabled:opacity-50"
                >
                    {isSubmitting
                        ? t("contactPage.contactUs.submittingText")
                        : t("contactPage.contactUs.submitText")}
                </button>

                {submitStatus === "success" && (
                    <p className="text-center text-[13px] text-green-600">
                        {t("contactPage.contactUs.successToast")}
                    </p>
                )}
                {submitStatus === "error" && (
                    <p className="text-center text-[13px] text-red-600">
                        {t("contactPage.contactUs.errorToast")}
                    </p>
                )}

                <div className="flex items-center gap-3 text-[13px] text-[#9CA3AF]">
                    <div className="h-px flex-1 bg-[#E5E7EB]" />
                    <span>{t("contactPage.contactUs.orDivider")}</span>
                    <div className="h-px flex-1 bg-[#E5E7EB]" />
                </div>

                <a
                    href={whatsappHref}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="flex h-[52px] w-full items-center justify-center gap-2 rounded-[12px] bg-[#25D366] text-[15px] font-bold text-white! transition hover:opacity-90"
                >
                    <SiWhatsapp size={20} color="text-white" />
                    {t("contactPage.contactUs.whatsappText")}
                </a>
            </form>
        </div>
    );
}
