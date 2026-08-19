import { useState, useEffect } from "react";
import { useSearchParams } from "react-router-dom";
import { useTranslation } from "react-i18next";
import { toast } from "react-toastify";
import { useCarSearch } from "../hooks/useCarSearch";
import { submitBooking } from "../services/api";
import { getCarBySlug, searchCars } from "../services/api/cars.service";
import { useSEO } from "../utils/useSEO";
import { CarSelector, OrderForm, TrustBadges } from "../components/orders";

export default function OrdersPage() {
    const { i18n, t } = useTranslation();
    const isRtl = i18n.dir() === "rtl";
    const [searchParams] = useSearchParams();
    const carIdParam = searchParams.get("car") || searchParams.get("car_id");
    const carSlugParam = searchParams.get("slug") || searchParams.get("car_slug");

    useSEO(
        t("pageTitles.orders"),
        t("ordersPage.heroDescription"),
    );

    const [selectedCar, setSelectedCar] = useState<import("../types/home.types").CarItem | null>(null);
    const [searchOpen] = useState(true);
    const { searchQuery, setSearchQuery, searchResults, searching } =
        useCarSearch(searchOpen);

    // Auto-select car from URL parameters (e.g. /orders?car=123 or /orders?slug=bmw-x3)
    useEffect(() => {
        if (selectedCar) return;

        if (carSlugParam) {
            getCarBySlug(carSlugParam)
                .then((carDetails) => {
                    if (carDetails) {
                        setSelectedCar({
                            id: carDetails.id,
                            name: carDetails.name,
                            year: carDetails.year,
                            current_price: carDetails.current_price,
                            cash_price: carDetails.cash_price,
                            main_image: carDetails.main_image,
                            brand: carDetails.brand ? { name: carDetails.brand.name } : undefined,
                        } as any);
                    }
                })
                .catch(() => {});
        } else if (carIdParam) {
            searchCars(carIdParam)
                .then((results) => {
                    const match = results.find((c) => String(c.id) === String(carIdParam)) || results[0];
                    if (match) {
                        setSelectedCar(match);
                    }
                })
                .catch(() => {});
        }
    }, [carIdParam, carSlugParam, selectedCar]);

    // Form state
    const [fullName, setFullName] = useState("");
    const [phone, setPhone] = useState("");
    const [carType, setCarType] = useState("");
    const [payment, setPayment] = useState<"cash" | "bank">("cash");
    const [purchaseUrgency, setPurchaseUrgency] = useState("today");
    const [notes, setNotes] = useState("");

    // Finance specific state
    const [age, setAge] = useState("");
    const [workSector, setWorkSector] = useState("private");
    const [salary, setSalary] = useState("");
    const [serviceDuration, setServiceDuration] = useState("");
    const [hasDownpayment, setHasDownpayment] = useState(false);
    const [downPayment, setDownPayment] = useState("");
    const [hasObligations, setHasObligations] = useState(false);
    const [monthlyObligations, setMonthlyObligations] = useState("");

    const [submitting, setSubmitting] = useState(false);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        if (!fullName.trim() || !phone.trim()) {
            toast.error(isRtl ? "يرجى كتابة الاسم ورقم الجوال" : "Please enter your name and phone number");
            return;
        }
        if (!selectedCar && !carType.trim()) {
            toast.error(isRtl ? "يرجى اختيار سيارة أو تحديد الفئة المطلوبة" : "Please select a car or specify desired model");
            return;
        }

        setSubmitting(true);
        try {
            await submitBooking({
                car_id: selectedCar?.id ?? null,
                payment_method: payment,
                client_name: fullName.trim(),
                client_phone: phone.trim(),
                car_type: carType.trim() || (selectedCar ? `${selectedCar.name} ${selectedCar.year ?? ""}`.trim() : null),
                purchase_urgency: purchaseUrgency || null,
                notes: notes.trim() || null,
                // Finance fields
                age: payment === "bank" && age ? parseInt(age, 10) : null,
                work_sector: payment === "bank" ? workSector : null,
                salary: payment === "bank" && salary ? parseInt(salary, 10) : null,
                service_duration: payment === "bank" && serviceDuration ? serviceDuration.trim() : null,
                has_downpayment: payment === "bank" ? hasDownpayment : false,
                down_payment: payment === "bank" && hasDownpayment && downPayment ? parseInt(downPayment, 10) : null,
                has_obligations: payment === "bank" ? hasObligations : false,
                monthly_obligations: payment === "bank" && hasObligations && monthlyObligations ? parseInt(monthlyObligations, 10) : null,
            });

            toast.success(isRtl ? "تم إرسال طلبك بنجاح! سيتواصل معك مندوب المبيعات قريباً." : "Your request was submitted successfully! A representative will contact you soon.");

            // Reset form
            setFullName("");
            setPhone("");
            setCarType("");
            setNotes("");
            setAge("");
            setSalary("");
            setServiceDuration("");
            setHasDownpayment(false);
            setDownPayment("");
            setHasObligations(false);
            setMonthlyObligations("");
            setSelectedCar(null);
        } catch {
            toast.error(isRtl ? "حدث خطأ أثناء إرسال الطلب، يرجى المحاولة مرة أخرى." : "An error occurred while submitting. Please try again.");
        } finally {
            setSubmitting(false);
        }
    };

    return (
        <>
            <section
                dir={i18n.dir()}
                className="flex w-full flex-col items-center justify-center bg-[#021F38] px-4 py-14 text-center"
            >
                <h1 className="text-[36px] font-extrabold leading-snug md:text-[44px]">
                    <span className="text-white">{t("ordersPage.heroTitle1")} </span>
                    <span className="text-[var(--brand-secondary-color)]">
                        {t("ordersPage.heroTitle2")}
                    </span>
                </h1>
                <p className="mt-3 max-w-xl text-[15px] text-white/60">
                    {t("ordersPage.heroDescription")}
                </p>
            </section>

            <section
                dir={i18n.dir()}
                className="w-full bg-[#F5F4EF] px-4 py-12 sm:px-6 lg:px-8"
            >
                <div className="mx-auto grid max-w-5xl grid-cols-1 gap-8 lg:grid-cols-2">
                    <CarSelector
                        searchQuery={searchQuery}
                        setSearchQuery={setSearchQuery}
                        searchResults={searchResults}
                        searching={searching}
                        selectedCar={selectedCar}
                        onSelectCar={setSelectedCar}
                    />

                    <OrderForm
                        fullName={fullName}
                        setFullName={setFullName}
                        phone={phone}
                        setPhone={setPhone}
                        carType={carType}
                        setCarType={setCarType}
                        payment={payment}
                        setPayment={setPayment}
                        purchaseUrgency={purchaseUrgency}
                        setPurchaseUrgency={setPurchaseUrgency}
                        notes={notes}
                        setNotes={setNotes}
                        age={age}
                        setAge={setAge}
                        workSector={workSector}
                        setWorkSector={setWorkSector}
                        salary={salary}
                        setSalary={setSalary}
                        serviceDuration={serviceDuration}
                        setServiceDuration={setServiceDuration}
                        hasDownpayment={hasDownpayment}
                        setHasDownpayment={setHasDownpayment}
                        downPayment={downPayment}
                        setDownPayment={setDownPayment}
                        hasObligations={hasObligations}
                        setHasObligations={setHasObligations}
                        monthlyObligations={monthlyObligations}
                        setMonthlyObligations={setMonthlyObligations}
                        selectedCar={selectedCar}
                        submitting={submitting}
                        onSubmit={handleSubmit}
                    />
                </div>

                <TrustBadges />
            </section>
        </>
    );
}
