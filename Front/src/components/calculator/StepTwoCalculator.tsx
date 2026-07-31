import { useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import { toast } from "react-toastify";
import { submitCalculatorLead, calculateFinance } from "../../services/api";
import { TERM_OPTIONS } from "../../constants/calculator.constants";
import { useLanguageStore } from "../../store/language.store";
import type { ICalculateData } from "../../interfaces/ICalculatorTypes";
import type { IStepTwoCalculatorProps } from "../../interfaces/IStepTwoCalculatorProps";

const SLIDER_STYLE = `
  .calc-slider {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 6px;
    border-radius: 9999px;
    outline: none;
    cursor: pointer;
  }
  .calc-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--brand-secondary-color);
    border: 3px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    cursor: pointer;
  }
`;

function getSliderBg(value: number, min: number, max: number) {
    const pct = ((value - min) / (max - min)) * 100;
    return `linear-gradient(to right, var(--brand-secondary-color) ${pct}%, #D1D5DB ${pct}%)`;
}

export default function StepTwoCalculator({
    selectedCar,
    downPaymentPercent,
    setDownPaymentPercent,
    term,
    setTerm,
    personalInfo,
    onBack,
}: IStepTwoCalculatorProps) {
    const { t } = useTranslation();
    const direction = useLanguageStore((s) => s.direction);
    const [calcResult, setCalcResult] = useState<ICalculateData | null>(null);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const [carPrice, setCarPrice] = useState(selectedCar.price || 370000);
    const CAR_MIN = 50000;
    const CAR_MAX = 1000000;
    const DP_MIN = 10;
    const DP_MAX = 40;
    const downPayment = Math.round((carPrice * downPaymentPercent) / 100);

    useEffect(() => {
        calculateFinance({
            car_price: carPrice,
            down_payment_percentage: downPaymentPercent,
            period_months: term,
        })
            .then(setCalcResult)
            .catch(() => {});
    }, [carPrice, downPaymentPercent, term]);

    const monthlyPayment = calcResult?.monthly_payment ?? 0;
    const totalFinance = calcResult?.total_payment ?? 0;
    const financeAmount = calcResult?.loan_amount ?? 0;

    const handleSubmit = async () => {
        setIsSubmitting(true);
        try {
            await submitCalculatorLead({
                name: personalInfo.fullName,
                phone: personalInfo.phone,
            });
            toast.success(t("financeCalculator.step2.successToast"));
        } catch {
            toast.error(t("financeCalculator.step2.errorToast"));
        } finally {
            setIsSubmitting(false);
        }
    };

    const riyal = t("financeCalculator.step2.riyal");

    return (
        <div dir={direction} className="space-y-4">
            <style>{SLIDER_STYLE}</style>

            <div className="rounded-[20px] border border-[#E5E7EB] bg-white px-6 py-6 shadow-sm">
                <h2 className="mb-5 text-start text-[18px] font-extrabold text-[#111827]">
                    {t("financeCalculator.step2.financeDetails")}
                </h2>

                <div className="mb-6">
                    <div className="mb-2 flex items-center justify-between text-[13px]">
                        <span className="text-[#9CA3AF]">
                            {t("financeCalculator.step2.carPrice")}
                        </span>
                        <span className="font-bold text-[#111827]">
                            {carPrice.toLocaleString()} {riyal}
                        </span>
                    </div>
                    <div dir="ltr">
                        <input
                            type="range"
                            min={CAR_MIN}
                            max={CAR_MAX}
                            step={5000}
                            value={carPrice}
                            onChange={(e) =>
                                setCarPrice(Number(e.target.value))
                            }
                            className="calc-slider"
                            style={{
                                background: getSliderBg(
                                    carPrice,
                                    CAR_MIN,
                                    CAR_MAX,
                                ),
                            }}
                        />
                    </div>
                </div>

                <div className="mb-6">
                    <div className="mb-2 flex items-center justify-between text-[13px]">
                        <span className="text-[#9CA3AF]">
                            {t("financeCalculator.step2.downPayment")} (
                            {downPaymentPercent}%)
                        </span>
                        <span className="font-bold text-[#111827]">
                            {downPayment.toLocaleString()} {riyal}
                        </span>
                    </div>
                    <div dir="ltr">
                        <input
                            type="range"
                            min={DP_MIN}
                            max={DP_MAX}
                            step={1}
                            value={downPaymentPercent}
                            onChange={(e) =>
                                setDownPaymentPercent(Number(e.target.value))
                            }
                            className="calc-slider"
                            style={{
                                background: getSliderBg(
                                    downPaymentPercent,
                                    DP_MIN,
                                    DP_MAX,
                                ),
                            }}
                        />
                    </div>
                </div>

                <div>
                    <p className="mb-3 text-start text-[13px] text-[#9CA3AF]">
                        {t("financeCalculator.step2.financeTerm")}
                    </p>
                    <div className="flex flex-wrap justify-start gap-2">
                        {TERM_OPTIONS.map((opt) => (
                            <button
                                key={opt}
                                type="button"
                                onClick={() => setTerm(opt)}
                                className={[
                                    "h-[38px] rounded-full px-4 text-[13px] font-semibold transition",
                                    opt === term
                                        ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]"
                                        : "border border-[#E5E7EB] bg-white text-[#374151] hover:border-[var(--brand-secondary-color)]",
                                ].join(" ")}
                            >
                                {opt} {t("financeCalculator.step2.month")}
                            </button>
                        ))}
                    </div>
                </div>
            </div>

            <div className="rounded-[20px] bg-[#021F38] px-6 py-6 text-white">
                <p className="mb-4 text-start text-[12px] text-white/50">
                    {t("financeCalculator.step2.summaryTitle")}
                </p>

                <div className="mb-5 grid grid-cols-2 divide-x divide-x-reverse divide-white/10">
                    <div className="ps-4 text-center">
                        <p className="text-[12px] text-white/50">
                            {t("financeCalculator.step2.totalFinance")}
                        </p>
                        <p className="mt-1 text-[26px] font-extrabold text-white">
                            {totalFinance > 0
                                ? `${totalFinance.toLocaleString()} ${riyal}`
                                : "—"}
                        </p>
                    </div>
                    <div className="pe-4 text-center">
                        <p className="text-[12px] text-white/50">
                            {t("financeCalculator.step2.monthlyPayment")}
                        </p>
                        <p className="mt-1 text-[26px] font-extrabold ">
                            {monthlyPayment > 0
                                ? `${monthlyPayment.toLocaleString()} `
                                : "—"}
                            {monthlyPayment > 0 && (
                                <span className="text-[14px] font-semibold text-white/60">
                                    {riyal}
                                </span>
                            )}
                        </p>
                    </div>
                </div>

                <div className="mb-5 space-y-2 border-t border-white/10 pt-4">
                    <div className="flex justify-between text-[13px]">
                        <span className="text-white/60">
                            {t("financeCalculator.step2.financeAmount")}
                        </span>
                        <span>
                            {financeAmount > 0
                                ? `${financeAmount.toLocaleString()} ${riyal}`
                                : "—"}
                        </span>
                    </div>
                    <div className="flex justify-between text-[13px]">
                        <span className="text-white/60">
                            {t("financeCalculator.step2.totalInterest")}
                        </span>
                        <span>
                            {calcResult?.total_interest
                                ? `${calcResult.total_interest.toLocaleString()} ${riyal}`
                                : "—"}
                        </span>
                    </div>
                    <div className="flex justify-between text-[13px]">
                        <span className="text-white/60">
                            {t("financeCalculator.step2.annualRate")}
                        </span>
                        <span>
                            {calcResult?.annual_rate
                                ? `${calcResult.annual_rate}%`
                                : "—"}
                        </span>
                    </div>
                </div>

                <button
                    type="button"
                    onClick={handleSubmit}
                    disabled={isSubmitting}
                    className="flex h-[52px] w-full items-center justify-center rounded-full bg-[var(--brand-secondary-color)] text-[15px] !font-bold text-[var(--brand-primary-color)] transition hover:opacity-90 disabled:opacity-50"
                >
                    {isSubmitting
                        ? t("financeCalculator.step2.submitting")
                        : t("financeCalculator.step2.submitLead")}
                </button>

                <button
                    type="button"
                    onClick={onBack}
                    className="mt-3 flex h-[40px] w-full items-center justify-center text-[13px] text-white/50 transition hover:text-white"
                >
                    {t("financeCalculator.step2.changeData")}
                </button>
            </div>
        </div>
    );
}
