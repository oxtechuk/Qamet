import { useTranslation } from "react-i18next";
import { CheckCircle } from "lucide-react";

type Step = 1 | 2;

function StepCircle({
  number,
  label,
  active,
  done,
}: {
  number: number;
  label: string;
  active?: boolean;
  done?: boolean;
}) {
  return (
    <div className="flex items-center gap-2">
      <span
        className={`flex h-[34px] w-[34px] items-center justify-center rounded-full text-[14px] font-extrabold ${
          active || done
            ? "bg-[#06111E] text-white"
            : "bg-[#D9DCE1] text-[#5F6672]"
        }`}
      >
        {done ? <CheckCircle size={18} /> : number}
      </span>
      <span className="text-[13px] font-bold text-[#07111F]">{label}</span>
    </div>
  );
}

export default function Stepper({ activeStep }: { activeStep: Step }) {
  const { t } = useTranslation();

  return (
    <div className="mx-auto flex max-w-[360px] items-center justify-center gap-4">
      <StepCircle
        number={1}
        label={t("financeCalculator.step1.stepperLabel")}
        active={activeStep === 1}
        done={activeStep > 1}
      />
      <span className="h-px w-[70px] bg-[#D5DBE3]" />
      <StepCircle
        number={2}
        label={t("financeCalculator.step2.stepperLabel")}
        active={activeStep === 2}
      />
    </div>
  );
}
