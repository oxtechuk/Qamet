import { useState, useRef, useEffect, useMemo } from "react";
import { useTranslation } from "react-i18next";
import { ChevronDown, Search } from "lucide-react";
import type { ISelectOption, ISelectProps } from "../interfaces/ISelectProps";

export type { ISelectOption as SelectOption };

export default function Select(props: ISelectProps) {
  const { searchable, ...rest } = props;
  if (!searchable) {
    return <NativeSelect {...rest} />;
  }

  return <SearchableSelect {...rest} />;
}

/* ── Native version ── */

function NativeSelect({
  placeholder,
  value,
  onChange,
  options,
  icon,
  className,
  chevronClassName,
}: ISelectProps) {
  return (
    <div className="relative">
      {icon && (
        <span className="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2">
          {icon}
        </span>
      )}

      <select
        value={value}
        onChange={(e) => onChange(e.target.value)}
        className={`w-full appearance-none outline-none transition ${icon ? "px-11" : "px-4"} ${className ?? ""}`}
      >
        {placeholder && (
          <option value="" disabled>
            {placeholder}
          </option>
        )}

        {options.map((option) => (
          <option key={option.value} value={option.value}>
            {option.label}
          </option>
        ))}
      </select>

      <ChevronDown
        size={18}
        className={`pointer-events-none absolute top-1/2 -translate-y-1/2 ${chevronClassName ?? "left-4"}`}
        style={{ color: icon ? "#7A8AA0" : "inherit" }}
      />
    </div>
  );
}

/* ── Searchable version ── */

function SearchableSelect({
  placeholder,
  value,
  onChange,
  options,
  icon,
  className,
  chevronClassName,
}: ISelectProps) {
  const { t, i18n } = useTranslation();
  const isRTL = i18n.dir() === "rtl";
  const [open, setOpen] = useState(false);
  const [query, setQuery] = useState("");
  const [dropdownStyle, setDropdownStyle] = useState<React.CSSProperties>({});
  const [dropdownAbove, setDropdownAbove] = useState(false);
  const containerRef = useRef<HTMLDivElement>(null);
  const buttonRef = useRef<HTMLButtonElement>(null);
  const inputRef = useRef<HTMLInputElement>(null);

  const selectedLabel =
    options.find((o) => o.value === value)?.label ?? "";

  const filtered = useMemo(
    () =>
      query
        ? options.filter((o) =>
            o.label.toLowerCase().includes(query.toLowerCase()),
          )
        : options,
    [options, query],
  );

  useEffect(() => {
    if (!open) return;
    setQuery("");
    const updatePosition = () => {
      if (buttonRef.current) {
        const rect = buttonRef.current.getBoundingClientRect();
        const spaceBelow = window.innerHeight - rect.bottom;
        const spaceAbove = rect.top;
        const dropdownHeight = 260;
        const placeAbove = spaceBelow < dropdownHeight && spaceAbove > spaceBelow;

        setDropdownAbove(placeAbove);

        setDropdownStyle({
          position: "fixed",
          top: placeAbove ? rect.top - 4 : rect.bottom + 4,
          left: rect.left,
          width: rect.width,
          zIndex: 200,
        });
      }
    };

    updatePosition();
    window.addEventListener("scroll", updatePosition, true);
    window.addEventListener("resize", updatePosition);

    setTimeout(() => inputRef.current?.focus(), 0);

    return () => {
      window.removeEventListener("scroll", updatePosition, true);
      window.removeEventListener("resize", updatePosition);
    };
  }, [open]);

  useEffect(() => {
    if (!open) return;
    const handler = (e: MouseEvent) => {
      if (
        containerRef.current &&
        !containerRef.current.contains(e.target as Node)
      ) {
        setOpen(false);
      }
    };
    document.addEventListener("mousedown", handler);
    return () => document.removeEventListener("mousedown", handler);
  }, [open]);

  const handleSelect = (val: string) => {
    onChange(val);
    setOpen(false);
  };

  return (
    <div ref={containerRef} className="relative">
      {icon && (
        <span className={`pointer-events-none absolute top-1/2 -translate-y-1/2 z-10 ${isRTL ? "left-4" : "right-4"}`}>
          {icon}
        </span>
      )}

      <button
        ref={buttonRef}
        type="button"
        onClick={() => setOpen((p) => !p)}
        className={`w-full text-start outline-none transition ${icon ? "px-11" : "px-4"} ${className ?? ""}`}
      >
        {value && selectedLabel ? (
          <span>{selectedLabel}</span>
        ) : (
          <span className="text-gray-400">{placeholder ?? ""}</span>
        )}
      </button>

      <ChevronDown
        size={18}
        className={`pointer-events-none absolute top-1/2 -translate-y-1/2 ${chevronClassName ?? (isRTL ? "right-4" : "left-4")}`}
        style={{ color: icon ? "#7A8AA0" : "inherit" }}
      />

      {open && (
        <div style={dropdownStyle} className={`rounded-[8px] border border-[#D7E3F5] bg-white shadow-lg ${dropdownAbove ? "mb-1" : "mt-1"}`}>
          <div className="relative border-b border-[#D7E3F5]">
            <Search
              size={15}
              className={`pointer-events-none absolute top-1/2 -translate-y-1/2 text-gray-400 ${isRTL ? "left-3" : "right-3"}`}
            />
            <input
              ref={inputRef}
              type="text"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder={t("select.search")}
              className={`w-full bg-transparent px-4 py-2.5 text-sm text-[#111827] outline-none placeholder:text-gray-400 ${isRTL ? "pl-9" : "pr-9"}`}
            />
          </div>

          <div className="max-h-48 overflow-y-auto">
            {filtered.length === 0 ? (
              <div className="px-4 py-3 text-sm text-gray-400">
                {t("select.noResults")}
              </div>
            ) : (
              filtered.map((option) => (
                <button
                  key={option.value}
                  type="button"
                  onClick={() => handleSelect(option.value)}
                  className={`w-full px-4 py-2.5 text-start text-sm transition hover:bg-[#F0F4FF] ${
                    option.value === value
                      ? "font-bold text-[var(--brand-primary-color)]"
                      : "text-[#111827]"
                  }`}
                >
                  {option.label}
                </button>
              ))
            )}
          </div>
        </div>
      )}
    </div>
  );
}
