import { useState } from "react";
import { useTranslation } from "react-i18next";
import {
  BarChart3,
  Bolt,
  Calculator,
  Search,
  Target,
  X,
} from "lucide-react";
import { toast } from "react-toastify";
import { getImageUrl } from "../../constants/app-images";
import { APP_IMAGES } from "../../constants/app-images";
import { INPUT_CLASSES } from "../../constants/calculator.constants";
import { useCarSearch } from "../../hooks/useCarSearch";
import { formatPrice } from "../../utils/format";
import Stepper from "./Stepper";
import FormField from "./FormField";
import SelectBox from "./SelectBox";
import InfoBox from "./InfoBox";
import type { CarItem } from "../../types/home.types";
import type { ISelectedCar } from "../../interfaces/ISelectedCar";
import type { IPersonalInfo } from "../../interfaces/IPersonalInfo";

interface IStepOneFormProps {
  selectedCarId: number;
  selectedCar: ISelectedCar;
  onCarSelect: (car: CarItem) => void;
  onNext: (info: IPersonalInfo) => void;
}

export default function StepOneForm({
  selectedCarId,
  selectedCar,
  onCarSelect,
  onNext,
}: IStepOneFormProps) {
  const { t, i18n } = useTranslation();
  const isRTL = i18n.dir() === "rtl";
  const [fullName, setFullName] = useState("");
  const [phone, setPhone] = useState("");
  const [email, setEmail] = useState("");
  const [city, setCity] = useState("");
  const [salary, setSalary] = useState("");
  const [obligations, setObligations] = useState("");
  const [message, setMessage] = useState("");
  const [showSearch, setShowSearch] = useState(false);
  const { searchQuery, setSearchQuery, searchResults, setSearchResults, searching } =
    useCarSearch(showSearch);

  const infoBoxes = [
    {
      icon: <Bolt size={22} />,
      title: t("financeCalculator.infoBoxes.0.title"),
      description: t("financeCalculator.infoBoxes.0.description"),
    },
    {
      icon: <BarChart3 size={22} />,
      title: t("financeCalculator.infoBoxes.1.title"),
      description: t("financeCalculator.infoBoxes.1.description"),
    },
    {
      icon: <Target size={22} />,
      title: t("financeCalculator.infoBoxes.2.title"),
      description: t("financeCalculator.infoBoxes.2.description"),
    },
  ];

  const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    if (!selectedCarId) {
      toast.error(t("financeCalculator.validation.selectCar"));
      return;
    }
    if (!fullName || !phone || !email || !city || !salary || !obligations) {
      toast.error(t("financeCalculator.validation.fillRequired"));
      return;
    }
    onNext({ fullName, phone, email, city, salary, obligations, message });
  };

  return (
    <div
      dir={i18n.dir()}
      className="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:items-start"
    >
      <aside className="lg:col-span-4">
        <div
          className={`mx-auto max-w-md text-center ${
            isRTL ? "lg:text-right" : "lg:text-left"
          }`}
        >
          <span className="inline-flex rounded-full border border-[var(--brand-primary-color)]/30 bg-[#EAF4FF] px-5 py-2 text-[14px] font-bold text-[var(--brand-primary-color)]">
            {t("financeCalculator.badge")}
          </span>

          <h1 className="mt-8 text-[42px] font-extrabold leading-[1.35] text-[#07111F] md:text-[56px]">
            {t("financeCalculator.titleWhite")}
            <span className="block text-[var(--brand-primary-color)]">
              {t("financeCalculator.titleOrange")}
            </span>
          </h1>

          <p className="mt-6 text-[17px] leading-9 text-[#5F6672]">
            {t("financeCalculator.description")}
          </p>

          <div className="mt-10 space-y-4">
            {infoBoxes.map((box, idx) => (
              <InfoBox key={idx} {...box} />
            ))}
          </div>
        </div>
      </aside>

      <section className="lg:col-span-8">
        <form
          onSubmit={handleSubmit}
          className="rounded-[18px] bg-white px-6 py-8 shadow-sm md:px-10"
        >
          <Stepper activeStep={1} />

          <div className="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">
            <FormField label={t("financeCalculator.step1.fullName")} required>
              <input
                className={INPUT_CLASSES}
                placeholder={t("financeCalculator.step1.fullNamePlaceholder")}
                type="text"
                value={fullName}
                onChange={(e) => setFullName(e.target.value)}
              />
            </FormField>

            <FormField label={t("financeCalculator.step1.phone")} required>
              <input
                className={`${INPUT_CLASSES} text-left`}
                placeholder={t("financeCalculator.step1.phonePlaceholder")}
                type="tel"
                dir="ltr"
                value={phone}
                onChange={(e) => setPhone(e.target.value)}
              />
            </FormField>

            <FormField label={t("financeCalculator.step1.email")} required>
              <input
                className={`${INPUT_CLASSES} text-left`}
                placeholder={t("financeCalculator.step1.emailPlaceholder")}
                type="email"
                dir="ltr"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </FormField>

            <FormField label={t("financeCalculator.step1.city")} required>
              <SelectBox
                placeholder=""
                value={city}
                onChange={setCity}
              />
            </FormField>

            <FormField label={t("financeCalculator.step1.salary")} required>
              <input
                className={INPUT_CLASSES}
                placeholder={t("financeCalculator.step1.salaryPlaceholder")}
                type="number"
                value={salary}
                onChange={(e) => setSalary(e.target.value)}
              />
            </FormField>

            <FormField label={t("financeCalculator.step1.obligations")} required>
              <input
                className={INPUT_CLASSES}
                placeholder={t("financeCalculator.step1.obligationsPlaceholder")}
                type="number"
                value={obligations}
                onChange={(e) => setObligations(e.target.value)}
              />
            </FormField>
          </div>

          <div className="mt-7">
            <p className="mb-4 text-[15px] font-extrabold text-[#07111F]">
              {t("financeCalculator.step1.carLabel")}
            </p>

            {showSearch ? (
              <div>
                <div className="relative">
                  <input
                    type="text"
                    placeholder={t("financeCalculator.step1.searchPlaceholder")}
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    className={`${INPUT_CLASSES} ps-12`}
                    autoFocus
                  />
                  {searching ? (
                    <div className="pointer-events-none absolute start-4 top-1/2 -translate-y-1/2">
                      <div className="h-4 w-4 animate-spin rounded-full border-2 border-[#D5DBE3] border-t-[var(--brand-primary-color)]" />
                    </div>
                  ) : (
                    <Search
                      size={18}
                      className="pointer-events-none absolute start-4 top-1/2 -translate-y-1/2 text-[#8A8F99]"
                    />
                  )}
                  <button
                    type="button"
                    onClick={() => {
                      setShowSearch(false);
                      setSearchQuery("");
                      setSearchResults([]);
                    }}
                    className="absolute end-3 top-1/2 -translate-y-1/2 text-[#8A8F99] hover:text-[#5F6672]"
                  >
                    <X size={18} />
                  </button>
                </div>
                {searchResults.length > 0 && (
                  <div className="mt-2 max-h-[240px] overflow-y-auto rounded-[12px] border border-[#D5DBE3] bg-white shadow-lg">
                    {searchResults.map((car) => (
                      <button
                        key={car.id}
                        type="button"
                        onClick={() => {
                          onCarSelect(car);
                          setShowSearch(false);
                          setSearchQuery("");
                          setSearchResults([]);
                        }}
                        className="flex w-full items-center gap-4 px-4 py-3 text-right transition hover:bg-[#F7F9FB] border-b border-[#E5E7EB] last:border-b-0"
                      >
                        <img
                          src={
                            getImageUrl(car.main_image) ||
                            APP_IMAGES.CAR_PLACEHOLDER
                          }
                          alt={car.name}
                          className="h-[48px] w-[48px] rounded-[8px] object-cover"
                          loading="lazy"
                        />
                        <div>
                          <p className="text-[13px] text-[#8A8F99]">
                            {car.brand?.name || ""}
                          </p>
                          <p className="text-[14px] font-extrabold text-[#07111F]">
                            {car.name} {car.year}
                          </p>
                          <p className="text-[12px] font-bold text-[var(--brand-primary-color)]">
                            {formatPrice(car.current_price, "var(--brand-primary-color)")}
                          </p>
                        </div>
                      </button>
                    ))}
                  </div>
                )}
                {!searching && searchResults.length === 0 && (
                  <p className="mt-2 text-[13px] text-[#8A8F99]">
                    {t("financeCalculator.step1.noResults")}
                  </p>
                )}
              </div>
            ) : selectedCarId > 0 ? (
              <div className="flex items-center gap-4 rounded-[12px] border border-[#8ABEFF] bg-[#E8F2FF] px-4 py-3">
                <img
                  src={
                    selectedCar.image || APP_IMAGES.CAR_PLACEHOLDER
                  }
                  alt={selectedCar.name}
                  className="h-[52px] w-[52px] rounded-[8px] object-cover"
                  loading="lazy"
                />
                <div className="flex-1">
                  <p className="text-[13px] text-[#8A8F99]">
                    {selectedCar.brand}
                  </p>
                  <p className="text-[14px] font-extrabold text-[#07111F]">
                    {selectedCar.name}
                  </p>
                  <p className="text-[12px] font-bold text-[var(--brand-primary-color)]">
                    {selectedCar.price
                      ? formatPrice(selectedCar.price, "var(--brand-primary-color)")
                      : ""}
                  </p>
                </div>
                <button
                  type="button"
                  onClick={() => setShowSearch(true)}
                  className="rounded-[6px] border border-[var(--brand-primary-color)] px-4 py-1 text-[13px] font-bold text-[var(--brand-primary-color)] transition hover:bg-[var(--brand-primary-color)] hover:text-white"
                >
                  {t("financeCalculator.step1.changeButton")}
                </button>
              </div>
            ) : (
              <button
                type="button"
                onClick={() => setShowSearch(true)}
                className="flex h-[56px] w-full items-center justify-center gap-2 rounded-[12px] border border-dashed border-[#D5DBE3] bg-[#F7F9FB] text-[15px] font-extrabold text-[#8A8F99] transition hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)]"
              >
                <Search size={20} />
                {t("financeCalculator.step1.selectCar")}
              </button>
            )}
          </div>

          <div className="mt-9">
            <FormField label={t("financeCalculator.step1.messageLabel")}>
              <textarea
                value={message}
                maxLength={500}
                onChange={(event) => setMessage(event.target.value)}
                placeholder={t("financeCalculator.step1.messagePlaceholder")}
                className={`${INPUT_CLASSES} min-h-[150px] resize-none py-5 leading-7`}
              />
            </FormField>

            <div className={`mt-2 text-[13px] text-[#8A8F99] ${isRTL ? "text-left" : "text-right"}`}>
              {message.length} / 500{" "}
              {t("financeCalculator.step1.charCount")}
            </div>
          </div>

          <button
            type="submit"
            className="mt-6 flex h-[56px] w-full items-center justify-center gap-2 rounded-[8px] bg-[#9CA0A6] text-[17px] font-bold text-white transition hover:bg-[var(--brand-primary-color)]"
          >
            <Calculator size={20} />
            {t("financeCalculator.step1.submitButton")}
          </button>

          <p className="mt-5 text-center text-[13px] text-[#B2B8C2]">
            {t("financeCalculator.step1.privacyNotice")}
          </p>
        </form>
      </section>
    </div>
  );
}
