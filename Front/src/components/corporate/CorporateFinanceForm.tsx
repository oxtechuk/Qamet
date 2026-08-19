import { useState } from "react";
import { useTranslation } from "react-i18next";
import { Building2, Banknote, CreditCard, FileText, ShieldCheck } from "lucide-react";
import { toast } from "react-toastify";
import { submitBooking } from "../../services/api";
import { trackLead } from "../../utils/analytics";

interface ICorporateFinanceFormProps {
  onSuccess?: () => void;
}

export default function CorporateFinanceForm({ onSuccess }: ICorporateFinanceFormProps) {
  const { i18n } = useTranslation();
  const isRtl = i18n.dir() === "rtl";

  const [companyName, setCompanyName] = useState("");
  const [clientName, setClientName] = useState("");
  const [clientEmail, setClientEmail] = useState("");
  const [clientPhone, setClientPhone] = useState("");
  const [carType, setCarType] = useState("");
  const [carCount, setCarCount] = useState("1");
  const [paymentMethod, setPaymentMethod] = useState<"cash" | "bank">("bank");
  const [contactDate, setContactDate] = useState("");
  const [contactTime, setContactTime] = useState("morning");
  const [notes, setNotes] = useState("");
  const [submitting, setSubmitting] = useState(false);

  const inputCls =
    "h-[50px] w-full rounded-[12px] border border-[#E2E8F0] bg-white px-4 text-[14px] font-medium text-[#0F172A] outline-none placeholder:text-[#94A3B8] focus:border-[#021F38] focus:ring-4 focus:ring-[#021F38]/10 transition-all duration-200";

  const timeOptions = [
    { value: "morning", label: isRtl ? "صباحاً (9:00 ص - 12:00 م)" : "Morning (9:00 AM - 12:00 PM)" },
    { value: "afternoon", label: isRtl ? "ظهراً (12:00 م - 4:00 م)" : "Afternoon (12:00 PM - 4:00 PM)" },
    { value: "evening", label: isRtl ? "مساءً (4:00 م - 9:00 م)" : "Evening (4:00 PM - 9:00 PM)" },
  ];

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (!companyName.trim() || !clientName.trim() || !clientPhone.trim() || !carType.trim()) {
      toast.error(isRtl ? "يرجى تعبئة جميع الحقول الإلزامية (*)" : "Please fill in all required fields (*)");
      return;
    }

    setSubmitting(true);
    try {
      const timeLabel = timeOptions.find((t) => t.value === contactTime)?.label || contactTime;

      await submitBooking({
        car_id: null,
        booking_type: "corporate",
        payment_method: paymentMethod,
        company_name: companyName.trim(),
        client_name: clientName.trim(),
        client_email: clientEmail.trim() || null,
        client_phone: clientPhone.trim(),
        car_type: carType.trim(),
        car_count: parseInt(carCount, 10) || 1,
        preferred_contact_date: contactDate.trim() || null,
        preferred_contact_time: timeLabel,
        notes: notes.trim() || null,
      });

      trackLead({
        formName: "corporate_order",
        carName: `${carType.trim()} (${carCount} vehicles)`,
        orderType: "corporate",
        name: clientName.trim(),
        phone: clientPhone.trim(),
        email: clientEmail.trim(),
      });

      toast.success(
        isRtl
          ? "تم استلام طلب تمويل الشركات بنجاح! سيتواصل معكم ممثل حسابات الشركات في الموعد المفضل."
          : "Your corporate request has been submitted! A corporate account manager will contact you at your preferred time."
      );

      // Reset form
      setCompanyName("");
      setClientName("");
      setClientEmail("");
      setClientPhone("");
      setCarType("");
      setCarCount("1");
      setContactDate("");
      setNotes("");

      if (onSuccess) {
        onSuccess();
      }
    } catch {
      toast.error(
        isRtl
          ? "حدث خطأ أثناء إرسال الطلب، يرجى المحاولة مرة أخرى."
          : "An error occurred while submitting. Please try again."
      );
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <div className="w-full">
      <form
        onSubmit={handleSubmit}
        className="space-y-6 rounded-[22px] border border-[#E2E8F0] bg-white p-6 shadow-xl sm:p-8"
      >
        {/* Form Header */}
        <div className="border-b border-[#F1F5F9] pb-4">
          <div className="flex items-center gap-2.5">
            <span className="flex h-9 w-9 items-center justify-center rounded-xl bg-[#021F38] text-[var(--brand-secondary-color)] shadow-sm">
              <Building2 size={20} />
            </span>
            <div>
              <h2 className="text-[20px] font-black text-[#0F172A]">
                {isRtl ? "طلب عروض أسعار وتمويل للشركات" : "Corporate Fleet & Financing Request"}
              </h2>
              <p className="text-[13px] font-medium text-[#64748B]">
                {isRtl
                  ? "املأ النموذج أدناه وسيقوم فريق مبيعات الشركات بتجهيز عرض سعر مخصص لمنشأتكم."
                  : "Fill out the form below and our corporate fleet team will prepare a custom quotation for your enterprise."}
              </p>
            </div>
          </div>
        </div>

        {/* Section 1: Company & Representative Details */}
        <div>
          <div className="mb-3.5 flex items-center gap-2 text-[#0F172A]">
            <span className="flex h-6 w-6 items-center justify-center rounded-full bg-[#021F38] text-[12px] font-black text-white">
              1
            </span>
            <h3 className="text-[15px] font-black">
              {isRtl ? "بيانات المنشأة والمسؤول" : "Enterprise & Representative Details"}
            </h3>
          </div>

          <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "اسم الشركة / المؤسسة" : "Company / Enterprise Name"} <span className="text-red-500">*</span>
              </label>
              <div className="relative">
                <input
                  type="text"
                  value={companyName}
                  onChange={(e) => setCompanyName(e.target.value)}
                  placeholder={isRtl ? "مثال: شركة قمة نجد للتجارة" : "e.g. Acme Corporation"}
                  className={inputCls}
                  required
                />
              </div>
            </div>

            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "اسم الشخص المسؤول" : "Contact Person Name"} <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                value={clientName}
                onChange={(e) => setClientName(e.target.value)}
                placeholder={isRtl ? "الاسم الكامل للمسؤول" : "Full name of representative"}
                className={inputCls}
                required
              />
            </div>

            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "البريد الإلكتروني للعمل" : "Corporate Email"} <span className="text-red-500">*</span>
              </label>
              <input
                type="email"
                value={clientEmail}
                onChange={(e) => setClientEmail(e.target.value)}
                placeholder="info@company.com"
                className={`${inputCls} text-left`}
                dir="ltr"
                required
              />
            </div>

            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "رقم الهاتف / الجوال" : "Phone / Mobile Number"} <span className="text-red-500">*</span>
              </label>
              <input
                type="tel"
                value={clientPhone}
                onChange={(e) => setClientPhone(e.target.value)}
                placeholder="05xxxxxxxx"
                className={`${inputCls} text-left`}
                dir="ltr"
                required
              />
            </div>
          </div>
        </div>

        {/* Section 2: Fleet & Vehicle Specifications */}
        <div className="border-t border-[#F1F5F9] pt-5">
          <div className="mb-3.5 flex items-center gap-2 text-[#0F172A]">
            <span className="flex h-6 w-6 items-center justify-center rounded-full bg-[#021F38] text-[12px] font-black text-white">
              2
            </span>
            <h3 className="text-[15px] font-black">
              {isRtl ? "بيانات الأسطول والسيارات المطلوبة" : "Fleet & Vehicle Specifications"}
            </h3>
          </div>

          <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div className="sm:col-span-2">
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "السيارة / الموديل / الفئة المطلوبة" : "Desired Vehicle Model / Fleet Type"} <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                value={carType}
                onChange={(e) => setCarType(e.target.value)}
                placeholder={isRtl ? "مثال: 5 سيارات تويوتا كامري + 3 باصات هايس" : "e.g. 5 Toyota Camry + 3 Hiace Vans"}
                className={inputCls}
                required
              />
            </div>

            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "عدد السيارات الإجمالي" : "Total Vehicles Quantity"} <span className="text-red-500">*</span>
              </label>
              <input
                type="number"
                min="1"
                max="500"
                value={carCount}
                onChange={(e) => setCarCount(e.target.value)}
                className={inputCls}
                required
              />
            </div>
          </div>

          {/* Payment Method Switcher */}
          <div className="mt-4">
            <label className="mb-2 block text-[13px] font-bold text-[#334155]">
              {isRtl ? "طريقة الدفع والتمويل المفضلة" : "Preferred Payment & Financing Method"} <span className="text-red-500">*</span>
            </label>
            <div className="grid grid-cols-2 gap-3">
              <button
                type="button"
                onClick={() => setPaymentMethod("bank")}
                className={[
                  "flex h-[52px] items-center justify-center gap-2 rounded-[14px] text-[14px] font-black transition-all duration-200 border",
                  paymentMethod === "bank"
                    ? "border-[var(--brand-secondary-color)] bg-[#021F38] text-[var(--brand-secondary-color)] shadow-md ring-2 ring-[var(--brand-secondary-color)]"
                    : "border-[#E2E8F0] bg-[#F8FAFC] text-[#475569] hover:bg-white hover:text-[#0F172A]",
                ].join(" ")}
              >
                <CreditCard size={18} />
                <span>{isRtl ? "تمويل وتأجير شركات" : "Corporate Financing / Lease"}</span>
              </button>

              <button
                type="button"
                onClick={() => setPaymentMethod("cash")}
                className={[
                  "flex h-[52px] items-center justify-center gap-2 rounded-[14px] text-[14px] font-black transition-all duration-200 border",
                  paymentMethod === "cash"
                    ? "border-[var(--brand-secondary-color)] bg-[#021F38] text-[var(--brand-secondary-color)] shadow-md ring-2 ring-[var(--brand-secondary-color)]"
                    : "border-[#E2E8F0] bg-[#F8FAFC] text-[#475569] hover:bg-white hover:text-[#0F172A]",
                ].join(" ")}
              >
                <Banknote size={18} />
                <span>{isRtl ? "شراء نقدي (كاش)" : "Cash Purchase"}</span>
              </button>
            </div>
          </div>
        </div>

        {/* Section 3: Preferred Contact Schedule */}
        <div className="border-t border-[#F1F5F9] pt-5">
          <div className="mb-3.5 flex items-center gap-2 text-[#0F172A]">
            <span className="flex h-6 w-6 items-center justify-center rounded-full bg-[#021F38] text-[12px] font-black text-white">
              3
            </span>
            <h3 className="text-[15px] font-black">
              {isRtl ? "التاريخ والوقت المفضل للتواصل" : "Preferred Contact Date & Time"}
            </h3>
          </div>

          <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "التاريخ المفضل" : "Preferred Date"}
              </label>
              <input
                type="date"
                value={contactDate}
                onChange={(e) => setContactDate(e.target.value)}
                className={inputCls}
              />
            </div>

            <div>
              <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
                {isRtl ? "الفترة الزمنية المناسبة" : "Preferred Time Slot"}
              </label>
              <select
                value={contactTime}
                onChange={(e) => setContactTime(e.target.value)}
                className={inputCls}
              >
                {timeOptions.map((opt) => (
                  <option key={opt.value} value={opt.value}>
                    {opt.label}
                  </option>
                ))}
              </select>
            </div>
          </div>
        </div>

        {/* Section 4: Notes */}
        <div className="border-t border-[#F1F5F9] pt-5">
          <label className="mb-1.5 block text-[13px] font-bold text-[#334155]">
            {isRtl ? "ملاحظات أو متطلبات خاصة (اختياري)" : "Additional Notes or Fleet Requirements (Optional)"}
          </label>
          <textarea
            value={notes}
            onChange={(e) => setNotes(e.target.value)}
            placeholder={isRtl ? "أي مواصفات، تفاصيل تسليم، أو شروط دفع ترغب بإضافتها..." : "Any fleet specifications, delivery terms, or details..."}
            rows={3}
            className={`${inputCls} h-auto resize-none py-3 leading-relaxed`}
          />
        </div>

        {/* Submit Button */}
        <button
          type="submit"
          disabled={submitting || !companyName.trim() || !clientName.trim() || !clientPhone.trim() || !carType.trim()}
          className="flex h-[56px] w-full items-center justify-center gap-2.5 rounded-[14px] bg-[#021F38] text-[16px] font-black text-white transition-all duration-200 shadow-xl hover:bg-[#032e52] active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-50"
        >
          {submitting ? (
            <span className="flex items-center gap-2.5">
              <span className="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
              <span>{isRtl ? "جاري إرسال الطلب..." : "Submitting Request..."}</span>
            </span>
          ) : (
            <span className="flex items-center gap-2">
              <FileText size={18} className="text-[var(--brand-secondary-color)]" />
              <span>{isRtl ? "إرسال طلب عروض أسعار الشركات" : "Submit Corporate Fleet Request"}</span>
            </span>
          )}
        </button>

        <p className="flex items-center justify-center gap-1.5 text-[12px] font-medium text-[#64748B]">
          <ShieldCheck size={15} className="text-[#10B981]" />
          <span>
            {isRtl
              ? "سيتم التعامل مع بيانات منشأتكم بكل سرية وتقديم أفضل عروض أسعار تنافسية في المملكة."
              : "Your corporate data is handled with full confidentiality to provide the best fleet offers."}
          </span>
        </p>
      </form>
    </div>
  );
}
