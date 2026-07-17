import type { IBrandCardProps } from "../interfaces/IBrandCardProps";

export default function BrandCard({ name, logo, onClick }: IBrandCardProps) {
  return (
    <div
      onClick={onClick}
      className={`flex h-[150px] w-full flex-col items-start justify-start pt-5 rounded-[16px] bg-white px-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md ${onClick ? "cursor-pointer" : ""}`}
    >
      <img src={logo} alt={name} loading="lazy" className="h-[52px] w-auto object-contain" />

      <h3 className="mt-5 text-[20px] font-bold text-[#111827]">{name}</h3>
    </div>
  );
}
