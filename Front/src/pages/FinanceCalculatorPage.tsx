import { useMemo, useState } from "react";
import { useTranslation } from "react-i18next";
import { StepOneForm, StepTwoCalculator } from "../components/calculator";
import { getImageUrl } from "../constants/app-images";
import { APP_IMAGES } from "../constants/app-images";
import type { CarItem } from "../types/home.types";
import type { ISelectedCar } from "../interfaces/ISelectedCar";
import { useSEO } from "../utils/useSEO";
import type { IPersonalInfo } from "../interfaces/IPersonalInfo";

type Step = 1 | 2;

export default function FinanceCalculatorPage() {
  const { i18n, t } = useTranslation();
  useSEO(t("pageTitles.financeCalculator"), t("financeCalculator.description"));
  const [step, setStep] = useState<Step>(1);
  const [selectedCarData, setSelectedCarData] = useState<CarItem | null>(null);
  const [selectedCarId, setSelectedCarId] = useState<number>(0);
  const [downPaymentPercent, setDownPaymentPercent] = useState(30);
  const [term, setTerm] = useState(60);
  const [selectedBankId, setSelectedBankId] = useState(2);
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
      tag: selectedCarData.is_featured ? "مميز" : "",
      image: getImageUrl(selectedCarData.main_image) || APP_IMAGES.CAR_PLACEHOLDER,
    };
  }, [selectedCarData]);

  const downPayment = useMemo(
    () => Math.round((selectedCar.price * downPaymentPercent) / 100),
    [selectedCar.price, downPaymentPercent],
  );

  const handleStep1Next = (info: IPersonalInfo) => {
    setPersonalInfo(info);
    setStep(2);
  };

  return (
    <main dir={i18n.dir()} className="min-h-screen w-full py-14">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
            downPayment={downPayment}
            term={term}
            setTerm={setTerm}
            selectedBankId={selectedBankId}
            setSelectedBankId={setSelectedBankId}
            personalInfo={personalInfo}
            carId={selectedCarId}
            onBack={() => setStep(1)}
          />
        ) : null}
      </div>
    </main>
  );
}
