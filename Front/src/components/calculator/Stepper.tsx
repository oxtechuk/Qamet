import { useTranslation } from "react-i18next";
import { Check } from "lucide-react";
import type { IStepCircleProps, IStepperProps } from "../../interfaces/IStepperProps";

function StepCircle({ number, label, active, done }: IStepCircleProps) {
  return (
    <div className="flex items-center gap-2">
      <span className={[
        "flex h-[34px] w-[34px] items-center justify-center rounded-full text-[14px] font-extrabold transition",
        done ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]" :
        active ? "bg-[var(--brand-secondary-color)] text-[var(--brand-primary-color)]" :
        "bg-white/20 text-white",
      ].join(" ")}>
        {done ? <Check size={16} strokeWidth={3} /> : number}
      </span>
      <span className="text-[13px] font-semibold text-white/90">{label}</span>
    </div>
  );
}

export default function Stepper({ activeStep }: IStepperProps) {
  const { t } = useTranslation();
  return (
    <div className="flex items-center justify-center gap-4">
      <StepCircle number={1} label={t("financeCalculator.step1.stepperLabel")} active={activeStep === 1} done={activeStep > 1} />
      <div className="h-px w-[60px] bg-white/30" />
      <StepCircle number={2} label={t("financeCalculator.step2.stepperLabel")} active={activeStep === 2} />
    </div>
  );
}
