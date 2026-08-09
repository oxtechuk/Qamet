import type { IBrandCardProps } from "../interfaces/IBrandCardProps";
import LazyImg from "./LazyImg";

export default function BrandCard({ name, logo, onClick }: IBrandCardProps) {
  return (
    <div
      onClick={onClick}
      className={`flex h-[150px] w-full flex-col items-center justify-center rounded-[16px] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md ${onClick ? "cursor-pointer" : ""}`}
    >
      <LazyImg src={logo} alt={name} className="h-[52px] w-auto object-contain" />

      <h3 className="mt-5 text-[20px] font-bold text-[#111827]">{name}</h3>
    </div>
  );
}
