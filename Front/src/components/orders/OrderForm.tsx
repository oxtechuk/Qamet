import { useTranslation } from "react-i18next";
import { Car, CreditCard, Banknote, Clock, User, Briefcase, HelpCircle, Check, Sparkles, ShieldCheck } from "lucide-react";
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
    "h-[50px] w-full rounded-[12px] border border-[#E2E8F0] bg-white px-4 text-[14px] font-medium text-[#0F172A] outline-none placeholder:text-[#94A3B8] focus:border-[#021F38] focus:ring-4 focus:ring-[#021F38]/10 transition-all duration-200";

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
    <div className="w-full">
      {/* Top Switcher: Cash vs Finance */}
      <div className="mb-5 rounded-[18px] bg-[#E2E8F0]/70 p-1.5 backdrop-blur-md shadow-inner">
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
              "flex h-[52px] items-center justify-center gap-2.5 rounded-[14px] text-[15px] font-black transition-all duration-200",
              payment === "cash"
                ? "bg-[#021F38] text-white shadow-md scale-[1.01]"
                : "bg-white/60 text-[#475569] hover:bg-white hover:text-[#0F172A]",
            ].join(" ")}
          >
            <Banknote size={20} className={payment === "cash" ? "text-[var(--brand-secondary-color)]" : "text-[#64748B]"} />
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
              "flex h-[52px] items-center justify-center gap-2.5 rounded-[14px] text-[15px] font-black transition-all duration-200",
              payment === "bank"
                ? "bg-[#021F38] text-white shadow-md scale-[1.01]"
                : "bg-white/60 text-[#475569] hover:bg-white hover:text-[#0F172A]",
            ].join(" ")}
          >
            <CreditCard size={20} className={payment === "bank" ? "text-[var(--brand-secondary-color)]" : "text-[#64748B]"} />
            <span>{isRtl ? "تمويل بنكي / تقسيط" : "Bank Financing / Installment"}</span>
          </button>
        </div>
      </div>

      {/* Selected Car Preview Card */}
      <div
        className={[
          "mb-5 flex min-h-[88px] items-center justify-center rounded-[16px] border-2 border-dashed transition-all",
          selectedCar
            ? "border-[#021F38]/30 bg-white shadow-sm"
            : "border-[#CBD5E1] bg-white/70",
        ].join(" ")}
      >
        {selectedCar ? (
          <div className="flex w-full items-center gap-3.5 px-4 py-3">
            <LazyImg
              src={getImageUrl(selectedCar.main_image) || APP_IMAGES.CAR_PLACEHOLDER}
              alt={selectedCar.name}
              className="h-[56px] w-[80px] rounded-[10px] object-cover border border-[#E2E8F0]"
            />
            <div className="flex-1 text-start">
              <span className="inline-block rounded-md bg-[#F1F5F9] px-2 py-0.5 text-[11px] font-bold text-[#475569]">
                {selectedCar.brand?.name || (isRtl ? "سيارة مختارة" : "Selected Car")}
              </span>
              <p className="text-[15px] font-black text-[#0F172A]">
                {selectedCar.name} {selectedCar.year}
              </p>
              <p className="text-[13px] font-extrabold text-[var(--brand-secondary-color)]">
                {selectedCar.current_price
                  ? `${selectedCar.current_price.toLocaleString()} ${t("financeCalculator.step2.riyal")}`
                  : ""}
              </p>
            </div>
          </div>
        ) : (
          <div className="flex flex-col items-center gap-1.5 py-4 text-[#94A3B8]">
            <Car size={26} strokeWidth={1.5} className="text-[#94A3B8]" />
            <p className="text-[13px] font-bold">
              {t("ordersPage.selectCarEmpty")}
            </p>
          </div>
        )}
      </div>

      {/* Main Order Form */}
      <form
        onSubmit={onSubmit}
        className="space-y-6 rounded-[20px] border border-[#E2E8F0] bg-white p-5 shadow-sm sm:p-7"
      >
        {/* Section 1: Personal Info */}
        <div>
          <div className="mb-3.5 flex items-center gap-2 text-[#0F172A]">
            <span className="flex h-6 w-6 items-center justify-center rounded-full bg-[#021F38] text-[12px] font-black text-white">
              1
            </span>
            <h3 className="text-[15px] font-black">
              {isRtl ? "البيانات الشخصية" : "Personal Information"}
            </h3>
          </div>

          <div className="grid grid-cols-1 gap-3.5 sm:grid-cols-2">
            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
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
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
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
            <div className="mt-3.5">
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
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

        {/* Section 2: Work & Income (Finance only) */}
        {payment === "bank" && (
          <div className="border-t border-[#F1F5F9] pt-5">
            <div className="mb-3.5 flex items-center gap-2 text-[#0F172A]">
              <span className="flex h-6 w-6 items-center justify-center rounded-full bg-[#021F38] text-[12px] font-black text-white">
                2
              </span>
              <h3 className="text-[15px] font-black">
                {isRtl ? "بيانات العمل والدخل" : "Employment & Income"}
              </h3>
            </div>

            <div className="grid grid-cols-1 gap-3.5 sm:grid-cols-3">
              <div>
                <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
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
                <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
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
                <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
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

        {/* Section 3: Car Details & Finance Options */}
        <div className="border-t border-[#F1F5F9] pt-5">
          <div className="mb-3.5 flex items-center gap-2 text-[#0F172A]">
            <span className="flex h-6 w-6 items-center justify-center rounded-full bg-[#021F38] text-[12px] font-black text-white">
              {payment === "cash" ? 2 : 3}
            </span>
            <h3 className="text-[15px] font-black">
              {payment === "cash" ? (isRtl ? "بيانات السيارة المطلوبة" : "Desired Car Details") : (isRtl ? "بيانات السيارة والتمويل" : "Car & Financing Details")}
            </h3>
          </div>

          <div className="space-y-4">
            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
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

            {/* Down Payment & Obligations Cards (Finance only) */}
            {payment === "bank" && (
              <div className="space-y-3 pt-1">
                {/* Has Downpayment Card */}
                <div className="rounded-[16px] border border-[#E2E8F0] bg-[#F8FAFC] p-4 transition-all duration-200">
                  <div className="flex items-center justify-between gap-3">
                    <div className="flex items-center gap-2">
                      <Sparkles size={16} className="text-[var(--brand-secondary-color)]" />
                      <span className="text-[14px] font-bold text-[#0F172A]">
                        {isRtl ? "هل لديك دفعة أولى؟" : "Do you have a down payment?"}
                      </span>
                    </div>

                    {/* Modern Pill Toggle */}
                    <div className="flex items-center rounded-[10px] bg-[#E2E8F0] p-1">
                      <button
                        type="button"
                        onClick={() => setHasDownpayment(true)}
                        className={[
                          "h-[32px] w-[54px] rounded-[8px] text-[13px] font-black transition-all duration-200",
                          hasDownpayment
                            ? "bg-[#021F38] text-white shadow-sm"
                            : "text-[#64748B] hover:text-[#0F172A]",
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
                          "h-[32px] w-[54px] rounded-[8px] text-[13px] font-black transition-all duration-200",
                          !hasDownpayment
                            ? "bg-[#64748B] text-white shadow-sm"
                            : "text-[#64748B] hover:text-[#0F172A]",
                        ].join(" ")}
                      >
                        {isRtl ? "لا" : "No"}
                      </button>
                    </div>
                  </div>

                  {hasDownpayment && (
                    <div className="mt-3 pt-3 border-t border-[#E2E8F0]/60 animate-in fade-in duration-200">
                      <label className="mb-1 block text-[12px] font-bold text-[#475569]">
                        {isRtl ? "قيمة الدفعة الأولى التقريبية (ريال)" : "Approx. Down Payment (SAR)"}
                      </label>
                      <input
                        type="number"
                        min="0"
                        value={downPayment}
                        onChange={(e) => setDownPayment(e.target.value)}
                        placeholder={isRtl ? "مثال: 20000" : "e.g. 20000"}
                        className={`${inputCls} h-[44px] text-[13px]`}
                      />
                    </div>
                  )}
                </div>

                {/* Has Obligations Card */}
                <div className="rounded-[16px] border border-[#E2E8F0] bg-[#F8FAFC] p-4 transition-all duration-200">
                  <div className="flex items-center justify-between gap-3">
                    <div className="flex items-center gap-2">
                      <CreditCard size={16} className="text-[#64748B]" />
                      <span className="text-[14px] font-bold text-[#0F172A]">
                        {isRtl ? "هل لديك التزامات أو أقساط حالية؟" : "Any existing obligations or installments?"}
                      </span>
                    </div>

                    {/* Modern Pill Toggle */}
                    <div className="flex items-center rounded-[10px] bg-[#E2E8F0] p-1">
                      <button
                        type="button"
                        onClick={() => setHasObligations(true)}
                        className={[
                          "h-[32px] w-[54px] rounded-[8px] text-[13px] font-black transition-all duration-200",
                          hasObligations
                            ? "bg-[#021F38] text-white shadow-sm"
                            : "text-[#64748B] hover:text-[#0F172A]",
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
                          "h-[32px] w-[54px] rounded-[8px] text-[13px] font-black transition-all duration-200",
                          !hasObligations
                            ? "bg-[#64748B] text-white shadow-sm"
                            : "text-[#64748B] hover:text-[#0F172A]",
                        ].join(" ")}
                      >
                        {isRtl ? "لا" : "No"}
                      </button>
                    </div>
                  </div>

                  {hasObligations && (
                    <div className="mt-3 pt-3 border-t border-[#E2E8F0]/60 animate-in fade-in duration-200">
                      <label className="mb-1 block text-[12px] font-bold text-[#475569]">
                        {isRtl ? "إجمالي الأقساط الشهرية الحالية (ريال)" : "Total Monthly Obligations (SAR)"}
                      </label>
                      <input
                        type="number"
                        min="0"
                        value={monthlyObligations}
                        onChange={(e) => setMonthlyObligations(e.target.value)}
                        placeholder={isRtl ? "مثال: 1500" : "e.g. 1500"}
                        className={`${inputCls} h-[44px] text-[13px]`}
                      />
                    </div>
                  )}
                </div>
              </div>
            )}
          </div>
        </div>

        {/* Section 4: Purchase Urgency (أهم سؤال) */}
        <div className="border-t border-[#F1F5F9] pt-5">
          <div className="mb-3 flex items-center gap-2 text-[#0F172A]">
            <Clock size={18} className="text-[var(--brand-secondary-color)]" />
            <h4 className="text-[14px] font-black">
              {isRtl ? "متى ترغب بشراء السيارة؟" : "When do you plan to purchase?"}
            </h4>
          </div>

          <div className="grid grid-cols-2 gap-2.5 sm:grid-cols-4">
            {currentUrgencyOptions.map((opt) => {
              const isSelected = purchaseUrgency === opt.value;
              return (
                <button
                  key={opt.value}
                  type="button"
                  onClick={() => setPurchaseUrgency(opt.value)}
                  className={[
                    "min-h-[50px] rounded-[12px] px-3 py-2 text-[13px] sm:text-[14px] font-black transition-all duration-200 flex items-center justify-center gap-1.5 shadow-sm text-center",
                    isSelected
                      ? "bg-[#021F38] text-[var(--brand-secondary-color)] ring-2 ring-[var(--brand-secondary-color)] shadow-md scale-[1.02]"
                      : "border border-[#E2E8F0] bg-[#F8FAFC] text-[#475569] hover:border-[#021F38]/30 hover:bg-white hover:text-[#0F172A]",
                  ].join(" ")}
                >
                  {isSelected && <Check size={16} className="text-[var(--brand-secondary-color)] shrink-0" />}
                  <span className="truncate leading-normal">{opt.label}</span>
                </button>
              );
            })}
          </div>
        </div>

        {/* Notes (Optional) */}
        <div className="border-t border-[#F1F5F9] pt-4">
          <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
            {isRtl ? "ملاحظات إضافية (اختياري)" : "Additional Notes (Optional)"}
          </label>
          <textarea
            value={notes}
            onChange={(e) => setNotes(e.target.value)}
            placeholder={isRtl ? "أي استفسار أو تفاصيل أخرى ترغب بإضافتها..." : "Any other details or inquiries..."}
            rows={2}
            className={`${inputCls} h-auto resize-none py-3 leading-relaxed`}
          />
        </div>

        {/* Submit Button */}
        <button
          type="submit"
          disabled={submitting || (!selectedCar && !carType.trim()) || !fullName.trim() || !phone.trim()}
          className="flex h-[54px] w-full items-center justify-center gap-2.5 rounded-[14px] bg-[#021F38] text-[16px] font-black text-white transition-all duration-200 shadow-lg hover:bg-[#032e52] active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-50"
        >
          {submitting ? (
            <span className="flex items-center gap-2.5">
              <span className="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
              <span>{isRtl ? "جاري إرسال الطلب..." : "Submitting Order..."}</span>
            </span>
          ) : (
            <span>{payment === "cash" ? (isRtl ? "إرسال طلب الكاش" : "Submit Cash Request") : (isRtl ? "إرسال طلب التمويل" : "Submit Financing Request")}</span>
          )}
        </button>

        <p className="flex items-center justify-center gap-1.5 text-[12px] font-medium text-[#64748B]">
          <ShieldCheck size={15} className="text-[#10B981]" />
          <span>{isRtl ? "بياناتك محمية ولن تُستخدم إلا للتواصل معك بخصوص هذا الطلب." : "Your information is secure and will only be used to contact you regarding this request."}</span>
        </p>
      </form>
    </div>
  );
}
