import { useTranslation } from "react-i18next";
import { Building2, ShieldCheck, Zap, Award, Truck, Users, CheckCircle2, PhoneCall } from "lucide-react";
import { useSEO } from "../utils/useSEO";
import CorporateFinanceForm from "../components/corporate/CorporateFinanceForm";

export default function CorporateFinancePage() {
  const { i18n } = useTranslation();
  const isRtl = i18n.dir() === "rtl";

  useSEO(
    isRtl ? "تمويل الشركات وقطاع الأعمال | قمة نجد للسيارات" : "Corporate Financing & Fleet | Qemt Najd Cars",
    isRtl
      ? "حلول تمويل وشراء أساطيل السيارات للشركات والمؤسسات والجهات الحكومية بأفضل العروض التنافسية وأسرع الإجراءات."
      : "Fleet financing and purchasing solutions for corporations, enterprises and organizations with top competitive rates."
  );

  const benefits = [
    {
      icon: <Zap size={24} className="text-[var(--brand-secondary-color)]" />,
      title: isRtl ? "موافقات تمويلية سريعة" : "Fast Financing Approvals",
      desc: isRtl
        ? "إجراءات ميسرة ومعاملات سريعة بالتعاون مع كبرى البنوك وشركات التمويل في المملكة."
        : "Streamlined procedures and quick processing with leading Saudi banks and finance companies.",
    },
    {
      icon: <Award size={24} className="text-[var(--brand-secondary-color)]" />,
      title: isRtl ? "أسعار وعروض أساطيل خاصة" : "Special Fleet Pricing",
      desc: isRtl
        ? "خصومات استثنائية وعروض أسعار تنافسية تلائم حجم أسطول منشأتكم وميزانيتكم."
        : "Exclusive volume discounts and customized quotes tailored to your business scale.",
    },
    {
      icon: <Users size={24} className="text-[var(--brand-secondary-color)]" />,
      title: isRtl ? "ممثل حسابات مخصص" : "Dedicated Account Manager",
      desc: isRtl
        ? "مستشار مبيعات شركات متخصص لمتابعة طلبكم من البداية وحتى تسليم السيارات."
        : "A dedicated corporate consultant to manage your requirements from quotation to handover.",
    },
    {
      icon: <Truck size={24} className="text-[var(--brand-secondary-color)]" />,
      title: isRtl ? "تسليم سريع لكافة مناطق المملكة" : "Kingdom-wide Fast Delivery",
      desc: isRtl
        ? "إمكانية شحن وتسليم أسطول السيارات لجميع فروعكم في مختلف مدن المملكة."
        : "Reliable logistics and delivery of your vehicle fleet across all cities in Saudi Arabia.",
    },
  ];

  const requirements = [
    isRtl ? "سجل تجاري ساري المفعول" : "Valid Commercial Registration (CR)",
    isRtl ? "كشف حساب بنكي للمنشأة لآخر 6 أشهر" : "6-month company bank statements",
    isRtl ? "القوائم المالية المدققة للشركة" : "Audited financial statements",
    isRtl ? "خطاب تفويض للمسؤول بالتوقيع" : "Authorized signatory delegation letter",
  ];

  return (
    <div dir={i18n.dir()} className="w-full bg-[#FAFAF8]">
      {/* Hero Header */}
      <section className="relative flex w-full flex-col items-center justify-center bg-[#021F38] px-4 py-16 text-center shadow-lg md:py-20">
        <div className="mx-auto max-w-4xl">
          <div className="mb-4 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 backdrop-blur-sm">
            <Building2 size={16} className="text-[var(--brand-secondary-color)]" />
            <span className="text-[13px] font-bold text-white/90">
              {isRtl ? "حلول مخصصة للشركات والمنشآت" : "Dedicated B2B Fleet Solutions"}
            </span>
          </div>

          <h1 className="text-[34px] font-black leading-tight text-white sm:text-[44px] md:text-[50px]">
            <span>{isRtl ? "تمويل وتوريد أساطيل " : "Corporate Fleet Financing & "}</span>
            <span className="text-[var(--brand-secondary-color)]">
              {isRtl ? "الشركات والمؤسسات" : "Supply Solutions"}
            </span>
          </h1>

          <p className="mx-auto mt-4 max-w-2xl text-[15px] font-medium leading-relaxed text-white/70 sm:text-[16px]">
            {isRtl
              ? "نقدم في قمة نجد للسيارات باقات تمويلية وشراء نقدي متكاملة لأساطيل الشركات والجهات الحكومية والخاصة مع مرونة عالية وأفضل العروض والأسعار."
              : "Qemt Najd provides integrated financing and cash purchasing packages for corporate and governmental fleets with unmatched flexibility and competitive terms."}
          </p>
        </div>
      </section>

      {/* Main Content Area: Form & Side Info */}
      <section className="w-full px-4 py-12 sm:px-6 lg:px-8">
        <div className="mx-auto grid max-w-6xl grid-cols-1 gap-8 lg:grid-cols-12">
          {/* Main Form (7 cols) */}
          <div className="lg:col-span-7">
            <CorporateFinanceForm />
          </div>

          {/* Sidebar / Value Props (5 cols) */}
          <div className="space-y-6 lg:col-span-5">
            {/* Why Choose Us Card */}
            <div className="rounded-[22px] border border-[#E2E8F0] bg-white p-6 shadow-md">
              <h3 className="mb-4 flex items-center gap-2 text-[18px] font-black text-[#0F172A]">
                <ShieldCheck size={22} className="text-[var(--brand-secondary-color)]" />
                <span>{isRtl ? "لماذا تختار قمة نجد لمنشأتك؟" : "Why Choose Qemt Najd For Your Business?"}</span>
              </h3>

              <div className="space-y-4">
                {benefits.map((item, idx) => (
                  <div key={idx} className="flex items-start gap-3.5 rounded-[14px] bg-[#F8FAFC] p-3.5 border border-[#F1F5F9]">
                    <span className="shrink-0 mt-0.5">{item.icon}</span>
                    <div>
                      <h4 className="text-[14px] font-bold text-[#0F172A]">{item.title}</h4>
                      <p className="mt-0.5 text-[12px] font-medium text-[#64748B] leading-normal">{item.desc}</p>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* General Requirements Card */}
            <div className="rounded-[22px] border border-[#E2E8F0] bg-[#021F38] p-6 text-white shadow-lg">
              <h3 className="mb-3 text-[16px] font-black text-[var(--brand-secondary-color)]">
                {isRtl ? "المستندات العامة المطلوبة للتمويل:" : "General Corporate Requirements:"}
              </h3>
              <ul className="space-y-2.5">
                {requirements.map((req, idx) => (
                  <li key={idx} className="flex items-center gap-2.5 text-[13px] font-medium text-white/80">
                    <CheckCircle2 size={16} className="text-[var(--brand-secondary-color)] shrink-0" />
                    <span>{req}</span>
                  </li>
                ))}
              </ul>

              <div className="mt-5 border-t border-white/10 pt-4 text-center">
                <p className="text-[12px] text-white/60">
                  {isRtl ? "هل لديك استفسار مباشر بخصوص مبيعات الشركات؟" : "Have direct questions about fleet sales?"}
                </p>
                <a
                  href="tel:0500000000"
                  className="mt-2 inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-[13px] font-bold text-white transition hover:bg-white/20"
                >
                  <PhoneCall size={14} className="text-[var(--brand-secondary-color)]" />
                  <span>{isRtl ? "اتصل بفريق مبيعات الشركات" : "Call Corporate Sales Team"}</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
