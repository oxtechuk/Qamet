import { useTranslation } from "react-i18next";
import { Car, CreditCard, Banknote, Clock, User, Briefcase, HelpCircle, CheckCircle2 } from "lucide-react";
import { getImageUrl, APP_IMAGES } from "../../constants/app-images";
import type { CarItem } from "../../types/home.types";
import LazyImg from "../LazyImg";

interface IOrderFormProps {
  fullName: string;
  setFullName: (v: string) => void;
  phone: string;
  setPhone: (v: string) => void;
  carType: string;
  setCarType: (v: string) => void;
  payment: "cash" | "bank";
  setPayment: (v: "cash" | "bank") => void;
  purchaseUrgency: string;
  setPurchaseUrgency: (v: string) => void;
  notes: string;
  setNotes: (v: string) => void;
  age: string;
  setAge: (v: string) => void;
  workSector: string;
  setWorkSector: (v: string) => void;
  salary: string;
  setSalary: (v: string) => void;
  serviceDuration: string;
  setServiceDuration: (v: string) => void;
  hasDownpayment: boolean;
  setHasDownpayment: (v: boolean) => void;
  downPayment: string;
  setDownPayment: (v: string) => void;
  hasObligations: boolean;
  setHasObligations: (v: boolean) => void;
  monthlyObligations: string;
  setMonthlyObligations: (v: string) => void;
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
  purchaseUrgency,
  setPurchaseUrgency,
  notes,
  setNotes,
  age,
  setAge,
  workSector,
  setWorkSector,
  salary,
  setSalary,
  serviceDuration,
  setServiceDuration,
  hasDownpayment,
  setHasDownpayment,
  downPayment,
  setDownPayment,
  hasObligations,
  setHasObligations,
  monthlyObligations,
  setMonthlyObligations,
  selectedCar,
  submitting,
  onSubmit,
}: IOrderFormProps) {
  const { t, i18n } = useTranslation();
  const isRtl = i18n.dir() === "rtl";

  const inputCls =
    "h-[48px] w-full rounded-[10px] border border-[#E5E7EB] bg-white px-4 text-[14px] text-[#111827] outline-none placeholder:text-[#9CA3AF] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.12)] transition";

  // Urgency options for Cash vs Finance
  const cashUrgencyOptions = [
    { value: "today", label: isRtl ? "اليوم" : "Today" },
    { value: "week", label: isRtl ? "خلال أسبوع" : "Within a week" },
    { value: "month", label: isRtl ? "خلال شهر" : "Within a month" },
    { value: "later", label: isRtl ? "لاحقاً" : "Later" },
  ];

  const financeUrgencyOptions = [
    { value: "3_days", label: isRtl ? "خلال 3 أيام" : "Within 3 days" },
    { value: "week", label: isRtl ? "خلال أسبوع" : "Within a week" },
    { value: "month", label: isRtl ? "خلال شهر" : "Within a month" },
    { value: "inquiry", label: isRtl ? "مجرد استفسار" : "Just inquiring" },
  ];

  const currentUrgencyOptions = payment === "cash" ? cashUrgencyOptions : financeUrgencyOptions;

  return (
    <div>
      {/* Top Switcher: Cash vs Finance */}
      <div className="mb-6 rounded-[16px] bg-[#E5E7EB]/50 p-1.5 backdrop-blur">
        <div className="grid grid-cols-2 gap-2">
          <button
            type="button"
            onClick={() => {
              setPayment("cash");
              if (!["today", "week", "month", "later"].includes(purchaseUrgency)) {
                setPurchaseUrgency("today");
              }
            }}
            className={[
              "flex h-[52px] items-center justify-center gap-2.5 rounded-[12px] text-[15px] font-extrabold transition-all duration-200 shadow-sm",
              payment === "cash"
                ? "bg-[var(--brand-primary-color)] text-white shadow-md scale-[1.01]"
                : "bg-white/80 text-[#4B5563] hover:bg-white hover:text-[#111827]",
            ].join(" ")}
          >
            <Banknote size={20} className={payment === "cash" ? "text-[var(--brand-secondary-color)]" : ""} />
            <span>{isRtl ? "شراء نقدي (كاش)" : "Cash Purchase"}</span>
          </button>

          <button
            type="button"
            onClick={() => {
              setPayment("bank");
              if (!["3_days", "week", "month", "inquiry"].includes(purchaseUrgency)) {
                setPurchaseUrgency("3_days");
              }
            }}
            className={[
              "flex h-[52px] items-center justify-center gap-2.5 rounded-[12px] text-[15px] font-extrabold transition-all duration-200 shadow-sm",
              payment === "bank"
                ? "bg-[var(--brand-primary-color)] text-white shadow-md scale-[1.01]"
                : "bg-white/80 text-[#4B5563] hover:bg-white hover:text-[#111827]",
            ].join(" ")}
          >
            <CreditCard size={20} className={payment === "bank" ? "text-[var(--brand-secondary-color)]" : ""} />
            <span>{isRtl ? "تمويل بنكي / تقسيط" : "Bank Financing / Installment"}</span>
          </button>
        </div>
      </div>

      {/* Selected Car Preview Card */}
      <div
        className={[
          "mb-5 flex min-h-[84px] items-center justify-center rounded-[14px] border-2 border-dashed transition",
          selectedCar
            ? "border-[var(--brand-primary-color)] bg-white shadow-sm"
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
              <p className="text-[12px] font-medium text-[#9CA3AF]">
                {selectedCar.brand?.name}
              </p>
              <p className="text-[14px] font-bold text-[#111827]">
                {selectedCar.name} {selectedCar.year}
              </p>
              <p className="text-[12px] font-semibold text-[var(--brand-secondary-color)]">
                {selectedCar.current_price
                  ? `${selectedCar.current_price.toLocaleString()} ${t("financeCalculator.step2.riyal")}`
                  : ""}
              </p>
            </div>
          </div>
        ) : (
          <div className="flex flex-col items-center gap-1.5 py-4 text-[#9CA3AF]">
            <Car size={26} strokeWidth={1.5} />
            <p className="text-[13px] font-medium">
              {t("ordersPage.selectCarEmpty")}
            </p>
          </div>
        )}
      </div>

      {/* Main Order Form */}
      <form
        onSubmit={onSubmit}
        className="space-y-5 rounded-[16px] border border-[#E5E7EB] bg-white p-5 shadow-sm sm:p-6"
      >
        {/* Section: Personal Info */}
        <div>
          <div className="mb-3 flex items-center gap-2 text-[14px] font-bold text-[#111827]">
            <User size={16} className="text-[var(--brand-primary-color)]" />
            <span>{isRtl ? "1. البيانات الشخصية" : "1. Personal Information"}</span>
          </div>

          <div className="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div>
              <label className="mb-1 block text-[12px] font-medium text-[#374151]">
                {isRtl ? "اسم العميل" : "Full Name"} <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                value={fullName}
                onChange={(e) => setFullName(e.target.value)}
                placeholder={isRtl ? "أدخل اسمك الكريم" : "Enter your full name"}
                className={inputCls}
                required
              />
            </div>
            <div>
              <label className="mb-1 block text-[12px] font-medium text-[#374151]">
                {isRtl ? "رقم الجوال" : "Phone Number"} <span className="text-red-500">*</span>
              </label>
              <input
                type="tel"
                value={phone}
                onChange={(e) => setPhone(e.target.value)}
                placeholder="05xxxxxxxx"
                className={`${inputCls} text-left`}
                dir="ltr"
                required
              />
            </div>
          </div>

          {/* Age field only for Finance */}
          {payment === "bank" && (
            <div className="mt-3">
              <label className="mb-1 block text-[12px] font-medium text-[#374151]">
                {isRtl ? "العمر" : "Age"}
              </label>
              <input
                type="number"
                min="18"
                max="90"
                value={age}
                onChange={(e) => setAge(e.target.value)}
                placeholder={isRtl ? "مثال: 32" : "e.g. 32"}
                className={inputCls}
              />
            </div>
          )}
        </div>

        {/* Section: Work & Income (Finance only) */}
        {payment === "bank" && (
          <div className="border-t border-[#F3F4F6] pt-4">
            <div className="mb-3 flex items-center gap-2 text-[14px] font-bold text-[#111827]">
              <Briefcase size={16} className="text-[var(--brand-primary-color)]" />
              <span>{isRtl ? "2. بيانات العمل والدخل" : "2. Employment & Income"}</span>
            </div>

            <div className="grid grid-cols-1 gap-3 sm:grid-cols-3">
              <div>
                <label className="mb-1 block text-[12px] font-medium text-[#374151]">
                  {isRtl ? "جهة العمل" : "Work Sector"}
                </label>
                <select
                  value={workSector}
                  onChange={(e) => setWorkSector(e.target.value)}
                  className={inputCls}
                >
                  <option value="government">{isRtl ? "حكومي" : "Government"}</option>
                  <option value="private">{isRtl ? "قطاع خاص" : "Private Sector"}</option>
                  <option value="military">{isRtl ? "عسكري" : "Military"}</option>
                  <option value="retired">{isRtl ? "متقاعد" : "Retired"}</option>
                  <option value="other">{isRtl ? "أخرى" : "Other"}</option>
                </select>
              </div>

              <div>
                <label className="mb-1 block text-[12px] font-medium text-[#374151]">
                  {isRtl ? "الراتب الشهري (ريال)" : "Monthly Salary (SAR)"}
                </label>
                <input
                  type="number"
                  min="0"
                  value={salary}
                  onChange={(e) => setSalary(e.target.value)}
                  placeholder={isRtl ? "مثال: 12000" : "e.g. 12000"}
                  className={inputCls}
                />
              </div>

              <div>
                <label className="mb-1 block text-[12px] font-medium text-[#374151]">
                  {isRtl ? "مدة الخدمة" : "Service Duration"}
                </label>
                <input
                  type="text"
                  value={serviceDuration}
                  onChange={(e) => setServiceDuration(e.target.value)}
                  placeholder={isRtl ? "مثال: سنتين" : "e.g. 2 years"}
                  className={inputCls}
                />
              </div>
            </div>
          </div>
        )}

        {/* Section: Car Details / Category */}
        <div className="border-t border-[#F3F4F6] pt-4">
          <div className="mb-3 flex items-center gap-2 text-[14px] font-bold text-[#111827]">
            <Car size={16} className="text-[var(--brand-primary-color)]" />
            <span>{payment === "cash" ? (isRtl ? "2. بيانات السيارة" : "2. Car Details") : (isRtl ? "3. بيانات السيارة والتمويل" : "3. Car & Financing Details")}</span>
          </div>

          <div className="space-y-3">
            <div>
              <label className="mb-1 block text-[12px] font-medium text-[#374151]">
                {isRtl ? "الموديل / الفئة المطلوبة" : "Desired Model / Category"}
              </label>
              <input
                type="text"
                value={carType}
                onChange={(e) => setCarType(e.target.value)}
                placeholder={isRtl ? "مثال: تويوتا كامري 2025 نص فل" : "e.g. Toyota Camry 2025 Mid Option"}
                className={inputCls}
              />
            </div>

            {/* Down Payment & Commitments (Finance only) */}
            {payment === "bank" && (
              <div className="grid grid-cols-1 gap-4 pt-1 sm:grid-cols-2">
                {/* Has Downpayment */}
                <div className="rounded-[12px] border border-[#E5E7EB] bg-[#F9FAFB] p-3.5">
                  <div className="flex items-center justify-between">
                    <span className="text-[13px] font-semibold text-[#111827]">
                      {isRtl ? "هل لديك دفعة أولى؟" : "Do you have a down payment?"}
                    </span>
                    <div className="flex gap-1.5">
                      <button
                        type="button"
                        onClick={() => setHasDownpayment(true)}
                        className={[
                          "h-[30px] rounded-[6px] px-3 text-[12px] font-bold transition",
                          hasDownpayment
                            ? "bg-[var(--brand-primary-color)] text-white"
                            : "bg-white text-[#4B5563] border border-[#D1D5DB]",
                        ].join(" ")}
                      >
                        {isRtl ? "نعم" : "Yes"}
                      </button>
                      <button
                        type="button"
                        onClick={() => {
                          setHasDownpayment(false);
                          setDownPayment("");
                        }}
                        className={[
                          "h-[30px] rounded-[6px] px-3 text-[12px] font-bold transition",
                          !hasDownpayment
                            ? "bg-[#6B7280] text-white"
                            : "bg-white text-[#4B5563] border border-[#D1D5DB]",
                        ].join(" ")}
                      >
                        {isRtl ? "لا" : "No"}
                      </button>
                    </div>
                  </div>
                  {hasDownpayment && (
                    <div className="mt-2.5">
                      <input
                        type="number"
                        min="0"
                        value={downPayment}
                        onChange={(e) => setDownPayment(e.target.value)}
                        placeholder={isRtl ? "قيمة الدفعة الأولى التقريبية" : "Approx. down payment"}
                        className={`${inputCls} h-[40px] text-[13px]`}
                      />
                    </div>
                  )}
                </div>

                {/* Has Obligations */}
                <div className="rounded-[12px] border border-[#E5E7EB] bg-[#F9FAFB] p-3.5">
                  <div className="flex items-center justify-between">
                    <span className="text-[13px] font-semibold text-[#111827]">
                      {isRtl ? "هل لديك التزامات أو أقساط؟" : "Any existing obligations?"}
                    </span>
                    <div className="flex gap-1.5">
                      <button
                        type="button"
                        onClick={() => setHasObligations(true)}
                        className={[
                          "h-[30px] rounded-[6px] px-3 text-[12px] font-bold transition",
                          hasObligations
                            ? "bg-[var(--brand-primary-color)] text-white"
                            : "bg-white text-[#4B5563] border border-[#D1D5DB]",
                        ].join(" ")}
                      >
                        {isRtl ? "نعم" : "Yes"}
                      </button>
                      <button
                        type="button"
                        onClick={() => {
                          setHasObligations(false);
                          setMonthlyObligations("");
                        }}
                        className={[
                          "h-[30px] rounded-[6px] px-3 text-[12px] font-bold transition",
                          !hasObligations
                            ? "bg-[#6B7280] text-white"
                            : "bg-white text-[#4B5563] border border-[#D1D5DB]",
                        ].join(" ")}
                      >
                        {isRtl ? "لا" : "No"}
                      </button>
                    </div>
                  </div>
                  {hasObligations && (
                    <div className="mt-2.5">
                      <input
                        type="number"
                        min="0"
                        value={monthlyObligations}
                        onChange={(e) => setMonthlyObligations(e.target.value)}
                        placeholder={isRtl ? "إجمالي الأقساط الشهرية الحالية" : "Total monthly obligations"}
                        className={`${inputCls} h-[40px] text-[13px]`}
                      />
                    </div>
                  )}
                </div>
              </div>
            )}
          </div>
        </div>

        {/* Section: Purchase Timing (أهم سؤال) */}
        <div className="border-t border-[#F3F4F6] pt-4">
          <div className="mb-2.5 flex items-center gap-2 text-[14px] font-bold text-[#111827]">
            <Clock size={16} className="text-[var(--brand-secondary-color)]" />
            <span>{isRtl ? "متى ترغب بشراء السيارة؟" : "When do you plan to purchase?"}</span>
          </div>

          <div className="grid grid-cols-2 gap-2.5 sm:grid-cols-4">
            {currentUrgencyOptions.map((opt) => {
              const selected = purchaseUrgency === opt.value;
              return (
                <button
                  key={opt.value}
                  type="button"
                  onClick={() => setPurchaseUrgency(opt.value)}
                  className={[
                    "relative flex h-[46px] items-center justify-center gap-2 rounded-[10px] px-3 text-[13px] font-bold transition-all",
                    selected
                      ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)] shadow-sm ring-2 ring-[var(--brand-secondary-color)]"
                      : "border border-[#E5E7EB] bg-[#F9FAFB] text-[#4B5563] hover:border-[var(--brand-secondary-color)] hover:bg-white",
                  ].join(" ")}
                >
                  {selected && <CheckCircle2 size={14} className="text-[var(--brand-primary-color)]" />}
                  <span>{opt.label}</span>
                </button>
              );
            })}
          </div>
        </div>

        {/* Notes (Optional) */}
        <div>
          <label className="mb-1 block text-[12px] font-medium text-[#374151]">
            {isRtl ? "ملاحظات إضافية (اختياري)" : "Additional Notes (Optional)"}
          </label>
          <textarea
            value={notes}
            onChange={(e) => setNotes(e.target.value)}
            placeholder={isRtl ? "أي استفسار أو تفاصيل أخرى ترغب بإضافتها..." : "Any other details or inquiries..."}
            rows={2}
            className={`${inputCls} h-auto resize-none py-2.5 leading-6`}
          />
        </div>

        {/* Submit Button */}
        <button
          type="submit"
          disabled={submitting || (!selectedCar && !carType.trim()) || !fullName.trim() || !phone.trim()}
          className="flex h-[52px] w-full items-center justify-center gap-2 rounded-[12px] bg-[var(--brand-primary-color)] text-[15px] font-bold text-white transition-all shadow-md hover:bg-[#032e52] active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-50"
        >
          {submitting ? (
            <span className="flex items-center gap-2">
              <span className="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
              <span>{isRtl ? "جاري إرسال الطلب..." : "Submitting Order..."}</span>
            </span>
          ) : (
            <span>{payment === "cash" ? (isRtl ? "إرسال طلب الكاش" : "Submit Cash Request") : (isRtl ? "إرسال طلب التمويل" : "Submit Financing Request")}</span>
          )}
        </button>

        <p className="flex items-center justify-center gap-1.5 text-[12px] text-[#9CA3AF]">
          <HelpCircle size={13} />
          <span>{isRtl ? "بياناتك بأمان ولن يتم استخدامها إلا للتواصل معك بخصوص هذا الطلب." : "Your information is secure and will only be used to contact you regarding this request."}</span>
        </p>
      </form>
    </div>
  );
}
