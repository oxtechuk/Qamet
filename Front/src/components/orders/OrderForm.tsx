import { useTranslation } from "react-i18next";
import { Car, CreditCard } from "lucide-react";
import { getImageUrl, APP_IMAGES } from "../../constants/app-images";
import type { CarItem } from "../../types/home.types";
import type { IOrderPagePaymentOption } from "../../interfaces/IOrderPagePaymentOption";
import LazyImg from "../LazyImg";

const PAYMENT_OPTIONS: IOrderPagePaymentOption[] = [
    {
      value: "bank",
      labelKey: "ordersPage.paymentBank",
      icon: <CreditCard size={14} />,
    },
    { value: "cash", labelKey: "ordersPage.paymentCash", icon: "💵" },
];

interface IOrderFormProps {
  fullName: string;
  setFullName: (v: string) => void;
  phone: string;
  setPhone: (v: string) => void;
  carType: string;
  setCarType: (v: string) => void;
  payment: "cash" | "bank";
  setPayment: (v: "cash" | "bank") => void;
  notes: string;
  setNotes: (v: string) => void;
  selectedCar: CarItem | null;
  submitting: boolean;
  onSubmit: (e: React.FormEvent) => void;
}

export default function OrderForm({
  fullName,
  setFullName,
  phone,
  setPhone,
  carType,
  setCarType,
  payment,
  setPayment,
  notes,
  setNotes,
  selectedCar,
  submitting,
  onSubmit,
}: IOrderFormProps) {
  const { t } = useTranslation();

  const inputCls =
    "h-[48px] w-full rounded-[10px] border border-[#E5E7EB] bg-white px-4 text-[14px] text-[#111827] outline-none placeholder:text-[#9CA3AF] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.12)] transition";

  return (
    <div>
      <h2 className="mb-4 text-[20px] font-extrabold text-[#111827]">
        {t("ordersPage.yourInfoTitle")}
      </h2>

      <div
        className={[
          "mb-4 flex min-h-[90px] items-center justify-center rounded-[14px] border-2 border-dashed",
          selectedCar
            ? "border-[var(--brand-primary-color)] bg-white"
            : "border-[#D1D5DB] bg-white",
        ].join(" ")}
      >
        {selectedCar ? (
          <div className="flex w-full items-center gap-3 px-4 py-3">
            <LazyImg
              src={getImageUrl(selectedCar.main_image) || APP_IMAGES.CAR_PLACEHOLDER}
              alt={selectedCar.name}
              className="h-[52px] w-[72px] rounded-[8px] object-cover"
            />
            <div className="flex-1 text-start">
              <p className="text-[12px] text-[#9CA3AF]">
                {selectedCar.brand?.name}
              </p>
              <p className="text-[14px] font-bold text-[#111827]">
                {selectedCar.name} {selectedCar.year}
              </p>
              <p className="text-[12px] text-[var(--brand-secondary-color)]">
                {selectedCar.current_price
                  ? `${selectedCar.current_price.toLocaleString()} ${t("financeCalculator.step2.riyal")}`
                  : ""}
              </p>
            </div>
          </div>
        ) : (
          <div className="flex flex-col items-center gap-2 py-4 text-[#9CA3AF]">
            <Car size={28} strokeWidth={1.5} />
            <p className="text-[13px]">
              {t("ordersPage.selectCarEmpty")}
            </p>
          </div>
        )}
      </div>

      <form
        onSubmit={onSubmit}
        className="space-y-4 rounded-[16px] border border-[#E5E7EB] bg-white px-5 py-5"
      >
        <div className="grid grid-cols-2 gap-3">
          <div>
            <label className="mb-1 block text-[12px] font-medium text-[#374151]">
              {t("ordersPage.fullNameLabel")}{" "}
              <span className="text-red-500">*</span>
            </label>
            <input
              type="text"
              value={fullName}
              onChange={(e) => setFullName(e.target.value)}
              placeholder={t("ordersPage.fullNamePlaceholder")}
              className={inputCls}
              required
            />
          </div>
          <div>
            <label className="mb-1 block text-[12px] font-medium text-[#374151]">
              {t("ordersPage.phoneLabel")}{" "}
              <span className="text-red-500">*</span>
            </label>
            <input
              type="tel"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
              placeholder={t("ordersPage.phonePlaceholder")}
              className={`${inputCls} text-left`}
              dir="ltr"
              required
            />
          </div>
        </div>

        <div>
          <label className="mb-1 block text-[12px] font-medium text-[#374151]">
            {t("ordersPage.carTypeLabel")}
          </label>
          <input
            type="text"
            value={carType}
            onChange={(e) => setCarType(e.target.value)}
            placeholder={t("ordersPage.carTypePlaceholder")}
            className={inputCls}
          />
        </div>

        <div>
          <label className="mb-2 block text-[12px] font-medium text-[#374151]">
            {t("ordersPage.paymentLabel")}
          </label>
          <div className="grid grid-cols-2 gap-2">
            {PAYMENT_OPTIONS.map((opt) => (
              <button
                key={opt.value}
                type="button"
                onClick={() => setPayment(opt.value)}
                className={[
                  "flex h-[44px] items-center justify-center gap-2 rounded-[10px] text-[13px] font-semibold transition",
                  payment === opt.value
                    ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]"
                    : "border border-[#E5E7EB] bg-white text-[#374151] hover:border-[var(--brand-secondary-color)]",
                ].join(" ")}
              >
                <span>{opt.icon}</span>
                {t(opt.labelKey)}
              </button>
            ))}
          </div>
        </div>

        <div>
          <label className="mb-1 block text-[12px] font-medium text-[#374151]">
            {t("ordersPage.notesLabel")}
          </label>
          <textarea
            value={notes}
            onChange={(e) => setNotes(e.target.value)}
            placeholder={t("ordersPage.notesPlaceholder")}
            rows={3}
            className={`${inputCls} h-auto resize-none py-3 leading-7`}
          />
        </div>

        <button
          type="submit"
          disabled={submitting || !selectedCar || !fullName.trim() || !phone.trim()}
          className="flex h-[52px] w-full items-center justify-center rounded-[12px] bg-[#9CA3AF] text-[15px] font-bold text-white transition disabled:opacity-60 enabled:bg-[var(--brand-primary-color)] enabled:hover:opacity-90"
        >
          {submitting
            ? t("ordersPage.submitting")
            : t("ordersPage.submitIdle")}
        </button>

        <p className="text-center text-[12px] text-[#9CA3AF]">
          🔒 {t("ordersPage.privacyNotice")}
        </p>
      </form>
    </div>
  );
}
