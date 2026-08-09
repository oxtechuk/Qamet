import { useTranslation } from "react-i18next";

interface IAllCarsSearchBarProps {
  searchValue: string;
  onSearchChange: (value: string) => void;
  onSearchSubmit: () => void;
  resultCount: number;
}

export default function AllCarsSearchBar({
  searchValue,
  onSearchChange,
  onSearchSubmit,
  resultCount,
}: IAllCarsSearchBarProps) {
  const { t, i18n } = useTranslation();

  return (
    <div className="mb-5" dir={i18n.dir()}>
      <div className="flex items-center gap-3">
        <div className="relative flex-1">
          <input
            type="text"
            value={searchValue}
            onChange={(e) => onSearchChange(e.target.value)}
            onKeyDown={(e) =>
              e.key === "Enter" && onSearchSubmit()
            }
            placeholder={t("carFinder.searchPlaceholder")}
            className="h-[48px] w-full rounded-[12px] border border-[#E2E8F0] bg-white pe-12 ps-4 text-[14px] text-[#111827] outline-none placeholder:text-[#9CA3AF] focus:border-[var(--brand-primary-color)]"
          />
          <span className="pointer-events-none absolute end-4 top-1/2 -translate-y-1/2 text-[#9CA3AF]">
            <svg
              width="18"
              height="18"
              fill="none"
              stroke="currentColor"
              strokeWidth="2"
              viewBox="0 0 24 24"
            >
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.35-4.35" />
            </svg>
          </span>
        </div>
        <button
          type="button"
          onClick={onSearchSubmit}
          className="h-[48px] shrink-0 rounded-[12px] bg-[var(--brand-secondary-color)] px-6 text-[14px] font-bold text-[var(--brand-primary-color)] transition hover:opacity-90"
        >
          {t("carFinder.searchButton")}
        </button>
      </div>
      <p className="mt-2 text-start text-[13px] font-semibold text-[#111827]">
        <span className="text-[var(--brand-secondary-color)]">{resultCount}</span>{" "}
        {t("allCarsPage.availableCars")}
      </p>
    </div>
  );
}
