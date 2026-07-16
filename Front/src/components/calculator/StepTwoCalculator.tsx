import { useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import { toast } from "react-toastify";
import {
  submitCalculatorLead,
  getBanks,
  calculateFinance,
} from "../../services/api";
import {
  DOWN_PAYMENT_OPTIONS,
  TERM_OPTIONS,
} from "../../constants/calculator.constants";
import { formatPrice } from "../../utils/format";
import Stepper from "./Stepper";
import SummaryTopCard from "./SummaryTopCard";
import SummaryRow from "./SummaryRow";
import type {
  IBankItem,
  ICalculateData,
} from "../../interfaces/ICalculatorTypes";
import type { ISelectedCar } from "../../interfaces/ISelectedCar";
import type { IPersonalInfo } from "../../interfaces/IPersonalInfo";

interface IStepTwoCalculatorProps {
  selectedCar: ISelectedCar;
  downPaymentPercent: number;
  setDownPaymentPercent: (value: number) => void;
  downPayment: number;
  term: number;
  setTerm: (value: number) => void;
  selectedBankId: number;
  setSelectedBankId: (id: number) => void;
  personalInfo: IPersonalInfo;
  carId: number;
  onBack: () => void;
}

export default function StepTwoCalculator({
  selectedCar,
  downPaymentPercent,
  setDownPaymentPercent,
  downPayment,
  term,
  setTerm,
  selectedBankId,
  setSelectedBankId,
  personalInfo,
  carId,
  onBack,
}: IStepTwoCalculatorProps) {
  const { t, i18n } = useTranslation();
  const isRTL = i18n.dir() === "rtl";
  const [banks, setBanks] = useState<IBankItem[]>([]);
  const [calcResult, setCalcResult] = useState<ICalculateData | null>(null);
  const [isSubmitting, setIsSubmitting] = useState(false);

  useEffect(() => {
    getBanks()
      .then(setBanks)
      .catch(() => toast.error(t("financeCalculator.step2.banksError")));
  }, [t]);

  useEffect(() => {
    calculateFinance({
      car_id: carId,
      down_payment_percentage: downPaymentPercent,
      period_months: term,
      bank_id: selectedBankId,
    })
      .then(setCalcResult)
      .catch(() => {});
  }, [carId, downPaymentPercent, term, selectedBankId]);

  const monthlyPayment = calcResult?.monthly_payment ?? 0;
  const financeAmount = calcResult?.loan_amount ?? 0;
  const totalFinance = calcResult?.total_payment ?? 0;
  const totalProfit = calcResult?.total_interest ?? 0;

  const handleSubmitLead = async () => {
    setIsSubmitting(true);
    try {
      await submitCalculatorLead({
        name: personalInfo.fullName,
        phone: personalInfo.phone,
        email: personalInfo.email,
        city: personalInfo.city,
        purpose: "شراء",
        salary: Number(personalInfo.salary),
        monthly_obligations: Number(personalInfo.obligations),
        car_ids: [carId],
        notes: personalInfo.message,
        preferred_bank_id: selectedBankId,
      });
      toast.success(t("financeCalculator.step2.successToast"));
    } catch {
      toast.error(t("financeCalculator.step2.errorToast"));
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div dir={i18n.dir()}>
      <div className="mb-8 flex items-center justify-between">
        <button
          type="button"
          onClick={onBack}
          className="rounded-[6px] border border-[#D5DBE3] bg-white px-5 py-2 text-[14px] font-bold text-[#5F6672] transition hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)]"
        >
          {t("financeCalculator.step2.changeData")}
        </button>

        <div className={isRTL ? "text-right" : "text-left"}>
          <p className="text-[13px] text-[#B2B8C2]">
            {t("financeCalculator.step2.welcome")}, {personalInfo.fullName}
          </p>
          <h1 className="text-[22px] font-extrabold text-[#07111F]">
            {t("financeCalculator.step2.title")}
          </h1>
        </div>
      </div>

      <div className="mb-8 flex justify-center">
        <Stepper activeStep={2} />
      </div>

      <div className="grid grid-cols-1 gap-9 lg:grid-cols-12">
        <section className="space-y-6 lg:col-span-7">
          <div className="rounded-[14px] bg-white p-6 shadow-sm">
            <div className="mb-5 flex items-center justify-between">
              <h2 className="text-[17px] font-extrabold text-[#07111F]">
                {t("financeCalculator.step2.selectedCar")}
              </h2>
              <button
                type="button"
                onClick={onBack}
                className="h-[40px] rounded-[6px] border border-[#C9CED6] bg-white px-5 text-[14px] font-bold text-[#5F6672]"
              >
                {t("financeCalculator.step2.changeCar")}
              </button>
            </div>

            <div className="flex items-center gap-5">
              <img
                src={selectedCar.image}
                alt={selectedCar.name}
                className="h-[100px] w-[135px] rounded-[12px] object-cover"
                loading="lazy"
              />
              <div>
                <p className="text-[13px] text-[#8A8F99]">
                  {selectedCar.brand}
                </p>
                <h3 className="mt-1 text-[22px] font-extrabold text-[#07111F]">
                  {selectedCar.name}
                </h3>
                <div className="mt-2 flex items-center gap-3">
                  <span className="rounded-full bg-[#EAF4FF] px-3 py-1 text-[13px] font-bold text-[var(--brand-primary-color)]">
                    {selectedCar.tag}
                  </span>
                  <strong className="text-[22px] text-[var(--brand-primary-color)]">
                    {formatPrice(selectedCar.price, "var(--brand-primary-color)")}
                  </strong>
                </div>
              </div>
            </div>
          </div>

          <div className="rounded-[14px] bg-white p-6 shadow-sm">
            <h2 className="mb-5 text-[17px] font-extrabold text-[#07111F]">
              {t("financeCalculator.step2.downPaymentTitle")}
            </h2>

            <div className="mb-4 flex items-center justify-between">
              <span className="text-[14px] text-[#6B7280]">
                {t("financeCalculator.step2.downPaymentPercent")}
              </span>
              <strong className="text-[22px] text-[#07111F]">
                {downPaymentPercent}% — {formatPrice(downPayment, "#07111F")}
              </strong>
            </div>

            <input
              type="range"
              min={10}
              max={40}
              step={10}
              value={downPaymentPercent}
              onChange={(event) =>
                setDownPaymentPercent(Number(event.target.value))
              }
              className="h-[6px] w-full cursor-pointer accent-[var(--brand-primary-color)]"
            />

            <div className="mt-5 grid grid-cols-4 gap-3">
              {DOWN_PAYMENT_OPTIONS.map((option) => (
                <button
                  key={option}
                  type="button"
                  onClick={() => setDownPaymentPercent(option)}
                  className={`h-[42px] rounded-[8px] text-[14px] font-bold transition ${
                    option === downPaymentPercent
                      ? "bg-[var(--brand-primary-color)] text-white"
                      : "bg-[#F3F6F8] text-[#5F6672]"
                  }`}
                >
                  {option}%
                </button>
              ))}
            </div>
          </div>

          <div className="rounded-[14px] bg-white p-6 shadow-sm">
            <h2 className="mb-5 text-[17px] font-extrabold text-[#07111F]">
              {t("financeCalculator.step2.termTitle")}
            </h2>

            <div className="grid grid-cols-5 gap-3">
              {TERM_OPTIONS.map((option) => (
                <button
                  key={option}
                  type="button"
                  onClick={() => setTerm(option)}
                  className={`h-[68px] rounded-[12px] border text-center transition ${
                    option === term
                      ? "border-[var(--brand-primary-color)] bg-[var(--brand-primary-color)] text-white"
                      : "border-[#D5DBE3] bg-white text-[#07111F]"
                  }`}
                >
                  <strong className="block text-[20px]">{option}</strong>
                  <span className="text-[12px]">
                    {t("financeCalculator.step2.month")}
                  </span>
                </button>
              ))}
            </div>
          </div>

          <div className="rounded-[14px] bg-white p-6 shadow-sm">
            <h2 className="mb-5 text-[17px] font-extrabold text-[#07111F]">
              {t("financeCalculator.step2.bankTitle")}
            </h2>

            <div className="space-y-3">
              {banks.map((bank) => (
                <button
                  key={bank.id}
                  type="button"
                  onClick={() => setSelectedBankId(bank.id)}
                  className={`flex w-full items-center justify-between rounded-[12px] border px-4 py-4 transition ${
                    selectedBankId === bank.id
                      ? "border-[var(--brand-primary-color)] bg-[#F4FAFF]"
                      : "border-[#E5E7EB] bg-white"
                  }`}
                >
                  <div className="flex items-center gap-4">
                    <span
                      className={`flex h-[18px] w-[18px] items-center justify-center rounded-full border ${
                        selectedBankId === bank.id
                          ? "border-[var(--brand-primary-color)]"
                          : "border-[#D5DBE3]"
                      }`}
                    >
                      {selectedBankId === bank.id && (
                        <span className="h-[9px] w-[9px] rounded-full bg-[var(--brand-primary-color)]" />
                      )}
                    </span>
                    <img
                      src={bank.image}
                      alt={bank.name}
                      className="h-[28px] w-[60px] object-contain"
                      loading="lazy"
                    />
                  </div>

                  <div className={isRTL ? "text-right" : "text-left"}>
                    <p className="font-extrabold text-[#07111F]">{bank.name}</p>
                    <p className="mt-1 text-[12px] text-[#8A8F99]">
                      {t("financeCalculator.step2.bankMeta")}
                    </p>
                  </div>

                  <div className={isRTL ? "text-left" : "text-right"}>
                    <strong className="text-[20px] text-[#16A34A]">
                      {bank.annual_rate}%
                    </strong>
                    <p className="text-[11px] text-[#8A8F99]">
                      {t("financeCalculator.step2.annualRate")}
                    </p>
                  </div>
                </button>
              ))}
            </div>
          </div>
        </section>
        <section className="lg:col-span-5">
          <div className="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <SummaryTopCard
              title={t("financeCalculator.step2.carPrice")}
              value={formatPrice(selectedCar.price, "white")}
              variant="blue"
            />
            <SummaryTopCard
              title={t("financeCalculator.step2.monthlyPayment")}
              value={<>{formatPrice(monthlyPayment, "var(--brand-secondary-color)")}/{t("financeCalculator.step2.month")}</>}
              variant="orange"
            />
          </div>

          <div className="mt-6 rounded-[14px] bg-white p-6 shadow-sm">
            <h2 className="mb-5 text-[18px] font-extrabold text-[#07111F]">
              {t("financeCalculator.step2.summaryTitle")}
            </h2>

            <SummaryRow
              label={t("financeCalculator.step2.downPayment")}
              value={formatPrice(downPayment, "#07111F")}
            />
            <SummaryRow
              label={t("financeCalculator.step2.financeAmount")}
              value={formatPrice(financeAmount, "#07111F")}
            />
            <SummaryRow
              label={t("financeCalculator.step2.totalFinance")}
              value={formatPrice(totalFinance, "#07111F")}
            />
            <SummaryRow
              label={t("financeCalculator.step2.totalProfit")}
              value={formatPrice(totalProfit, "#07111F")}
            />
            <SummaryRow
              label={t("financeCalculator.step2.financingPeriod")}
              value={`${calcResult?.period_months ?? term} ${t("financeCalculator.step2.month")}`}
            />
            <SummaryRow
              label={t("financeCalculator.step2.approvalTime")}
              value={t("financeCalculator.step2.approvalValue")}
            />

            <p className="mt-5 text-[12px] leading-6 text-[#8A8F99]">
              {t("financeCalculator.step2.disclaimer")}
            </p>
          </div>

          <button
            type="button"
            onClick={handleSubmitLead}
            disabled={isSubmitting}
            className="mt-6 h-[52px] w-full rounded-[8px] bg-[var(--brand-primary-color)] text-[16px] font-bold text-white transition hover:opacity-90 disabled:opacity-50"
          >
            {isSubmitting
              ? t("financeCalculator.step2.submitting")
              : t("financeCalculator.step2.submitLead")}
          </button>

          <button
            type="button"
            className="mt-4 h-[52px] w-full rounded-[8px] border border-[var(--brand-primary-color)] text-[16px] font-bold text-[var(--brand-primary-color)] transition hover:bg-[var(--brand-primary-color)] hover:text-white"
          >
            {t("financeCalculator.step2.talkToAdvisor")}
          </button>
        </section>
      </div>
    </div>
  );
}
