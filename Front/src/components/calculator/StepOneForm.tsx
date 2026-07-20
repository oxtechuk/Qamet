import { useState } from "react";
import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../../store/language.store";
import { toast } from "react-toastify";
import type { IPersonalInfo } from "../../interfaces/IPersonalInfo";
import type { IStepOneFormProps } from "../../interfaces/IStepOneFormProps";

const inputCls = "h-[52px] w-full rounded-[10px] border border-[#E5E7EB] bg-[#F9FAFB] px-4 text-[14px] text-[#111827] outline-none placeholder:text-[#9CA3AF] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.12)] transition";

export default function StepOneForm({ onNext }: IStepOneFormProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);
  const [fullName, setFullName] = useState("");
  const [phone, setPhone] = useState("");
  const [consent, setConsent] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!fullName.trim() || !phone.trim()) {
      toast.error(t("financeCalculator.validation.fillRequired"));
      return;
    }
    onNext({ fullName, phone, email: "", city: "", salary: "", obligations: "", message: "" });
  };

  return (
    <div dir={direction} className="rounded-[20px] border border-[#E5E7EB] bg-white px-6 py-8 shadow-sm">
      <h2 className="mb-6 text-[20px] font-extrabold text-[#111827]">{t("financeCalculator.step1.personalInfoTitle")}</h2>

      <form onSubmit={handleSubmit} className="space-y-5">
        <div>
          <label className="mb-1.5 block text-[13px] font-bold! text-[#374151]">
            {t("financeCalculator.step1.fullName")} <span className="text-red-500">*</span>
          </label>
          <input
            type="text"
            value={fullName}
            onChange={(e) => setFullName(e.target.value)}
            placeholder={t("financeCalculator.step1.fullNamePlaceholder")}
            className={inputCls}
            required
          />
        </div>

        <div>
          <label className="mb-1.5 block text-[13px] font-bold! text-[#374151]">
            {t("financeCalculator.step1.phone")} <span className="text-red-500">*</span>
          </label>
          <input
            type="tel"
            value={phone}
            onChange={(e) => setPhone(e.target.value)}
            placeholder={t("financeCalculator.step1.phonePlaceholder")}
            className={`${inputCls} text-right`}
            dir="ltr"
            required
          />
        </div>

        <label className="flex cursor-pointer items-start gap-3 text-[13px] text-[#6B7280]">
          <input
            type="checkbox"
            checked={consent}
            onChange={(e) => setConsent(e.target.checked)}
            className="mt-0.5 h-4 w-4 shrink-0 accent-[var(--brand-primary-color)]"
          />
          <span>
            {t("financeCalculator.step1.consentPrefix")}{" "}
            <a href="/privacy" className="text-[var(--brand-primary-color)] underline">{t("financeCalculator.step1.consentLink")}</a>
            {" "}{t("financeCalculator.step1.consentSuffix")}
          </span>
        </label>

        <button
          type="submit"
          disabled={!consent}
          className="flex h-[52px] w-full items-center justify-center rounded-[12px] bg-[#9CA3AF] text-[15px] font-bold text-white transition disabled:opacity-60 enabled:bg-[var(--brand-primary-color)] enabled:hover:opacity-90"
        >
          {t("financeCalculator.step1.nextButton")}
        </button>
      </form>
    </div>
  );
}
