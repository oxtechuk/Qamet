import type { IBudgetRange } from "../interfaces/IBudgetRange";

interface BudgetCarsRangeFiltersProps {
    ranges: IBudgetRange[];
    activeRange?: string;
    onRangeChange?: (value: string) => void;
}

export default function BudgetCarsRangeFilters({
    ranges,
    activeRange,
    onRangeChange,
}: BudgetCarsRangeFiltersProps) {
    return (
        <div className="mt-8 grid grid-cols-2 gap-4">
            {ranges.map((range) => {
                const isActive = range.value === activeRange;

                return (
                    <button
                        key={range.value}
                        type="button"
                        onClick={() => onRangeChange?.(range.value)}
                        className={[
                            "flex min-h-[50px] items-center justify-center",
                            "rounded-[14px] border px-4",
                            "text-[14px] font-bold transition duration-300",
                            isActive
                                ? [
                                      "border-[var(--brand-secondary-color)]",
                                      "bg-[var(--brand-secondary-color)]",
                                      "text-[var(--brand-primary-color)]",
                                      "shadow-[0_9px_24px_rgba(0,0,0,0.14)]",
                                  ].join(" ")
                                : [
                                      "border-white/45",
                                      "bg-transparent",
                                      "text-white/55",
                                      "hover:border-white/80",
                                      "hover:text-white",
                                  ].join(" "),
                        ].join(" ")}
                    >
                        {range.label}
                    </button>
                );
            })}
        </div>
    );
}
