import { ChevronDown } from "lucide-react";
import { useTranslation } from "react-i18next";
import { INPUT_CLASSES } from "../../constants/calculator.constants";

interface ISelectBoxProps {
  placeholder: string;
  value: string;
  onChange: (value: string) => void;
}

export default function SelectBox({ placeholder, value, onChange }: ISelectBoxProps) {
  const { t } = useTranslation();

  return (
    <div className="relative">
      <select
        value={value}
        onChange={(event) => onChange(event.target.value)}
        className={`${INPUT_CLASSES} appearance-none pe-12`}
      >
        <option value="">{placeholder}</option>
        <option value={t("financeCalculator.cities.riyadh")}>
          {t("financeCalculator.cities.riyadh")}
        </option>
        <option value={t("financeCalculator.cities.jeddah")}>
          {t("financeCalculator.cities.jeddah")}
        </option>
        <option value={t("financeCalculator.cities.dammam")}>
          {t("financeCalculator.cities.dammam")}
        </option>
      </select>
      <ChevronDown
        size={18}
        className="pointer-events-none absolute end-4 top-1/2 -translate-y-1/2 text-[#8A8F99]"
      />
    </div>
  );
}
