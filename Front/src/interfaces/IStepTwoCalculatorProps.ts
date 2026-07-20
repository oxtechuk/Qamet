import type { ISelectedCar } from "./ISelectedCar";
import type { IPersonalInfo } from "./IPersonalInfo";

export interface IStepTwoCalculatorProps {
  selectedCar: ISelectedCar;
  downPaymentPercent: number;
  setDownPaymentPercent: (v: number) => void;
  term: number;
  setTerm: (v: number) => void;
  selectedBankId: number;
  setSelectedBankId: (id: number) => void;
  personalInfo: IPersonalInfo;
  carId: number;
  onBack: () => void;
}
