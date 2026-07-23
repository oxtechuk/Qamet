import { useMemo, useState } from "react";
import { useTranslation } from "react-i18next";
import { StepOneForm, StepTwoCalculator } from "../components/calculator";
import Stepper from "../components/calculator/Stepper";
import { getImageUrl } from "../constants/app-images";
import { APP_IMAGES } from "../constants/app-images";
import type { CarItem } from "../types/home.types";
import type { ISelectedCar } from "../interfaces/ISelectedCar";
import { useSEO } from "../utils/useSEO";
import type { IPersonalInfo } from "../interfaces/IPersonalInfo";
import type { IStepperStep } from "../interfaces/IStepperProps";

export default function FinanceCalculatorPage() {
  const { i18n, t } = useTranslation();
  useSEO(t("pageTitles.financeCalculator"), t("financeCalculator.description"));
  const [step, setStep] = useState<IStepperStep>(1);
  const [selectedCarData, setSelectedCarData] = useState<CarItem | null>(null);
  const [selectedCarId, setSelectedCarId] = useState<number>(0);
  const [downPaymentPercent, setDownPaymentPercent] = useState(30);
  const [term, setTerm] = useState(60);
  const [personalInfo, setPersonalInfo] = useState<IPersonalInfo | null>(null);

  const selectedCar: ISelectedCar = useMemo(() => {
    if (!selectedCarData) {
      return { id: 0, brand: "", name: "", model: "", price: 0, tag: "", image: "" };
    }
    return {
      id: selectedCarData.id,
      brand: selectedCarData.brand?.name ?? "",
      name: selectedCarData.name,
      model: String(selectedCarData.year ?? ""),
      price: selectedCarData.current_price,
      tag: "",
      image: getImageUrl(selectedCarData.main_image) || APP_IMAGES.CAR_PLACEHOLDER,
    };
  }, [selectedCarData]);

  const handleStep1Next = (info: IPersonalInfo) => {
    setPersonalInfo(info);
    setStep(2);
  };

  return (
    <main dir={i18n.dir()} className="min-h-screen w-full bg-[#F5F4EF]">
      <div className="w-full bg-[#021F38] px-4 py-10 text-center">
        <h1 className="text-[32px] font-extrabold text-white md:text-[38px] mb-5">
          {t("financeCalculator.titleWhite")}
        </h1>
        <p className="mt-1 text-[14px] text-white/60">
          {t("financeCalculator.description")}
        </p>
        <div className="mt-6">
          <Stepper activeStep={step} />
        </div>
      </div>

      <div className="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        {step === 1 ? (
          <StepOneForm
            selectedCarId={selectedCarId}
            selectedCar={selectedCar}
            onCarSelect={(car) => {
              setSelectedCarId(car.id);
              setSelectedCarData(car);
            }}
            onNext={handleStep1Next}
          />
        ) : personalInfo ? (
          <StepTwoCalculator
            selectedCar={selectedCar}
            downPaymentPercent={downPaymentPercent}
            setDownPaymentPercent={setDownPaymentPercent}
            term={term}
            setTerm={setTerm}
            personalInfo={personalInfo}
            onBack={() => setStep(1)}
          />
        ) : null}
      </div>
    </main>
  );
}
