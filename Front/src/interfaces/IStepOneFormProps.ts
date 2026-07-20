import type { ISelectedCar } from "./ISelectedCar";
import type { IPersonalInfo } from "./IPersonalInfo";
import type { CarItem } from "../types/home.types";

export interface IStepOneFormProps {
  selectedCarId: number;
  selectedCar: ISelectedCar;
  onCarSelect: (car: CarItem) => void;
  onNext: (info: IPersonalInfo) => void;
}
