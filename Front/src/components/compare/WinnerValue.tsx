import { Check } from "lucide-react";
import type { IWinnerValueProps } from "../../interfaces/IWinnerValueProps";

export default function WinnerValue({
  value,
  isWinner,
}: IWinnerValueProps) {
  return (
    <div
      className={`flex h-full items-center justify-center gap-2 font-bold ${isWinner ? "text-[#087A3B]" : "text-[#111827]"}`}
    >
      {isWinner && (
        <span className="flex h-6 w-6 items-center justify-center rounded-full bg-[#00C853] text-white">
          <Check size={15} strokeWidth={3} />
        </span>
      )}
      <span>{value}</span>
    </div>
  );
}
