import type { IPartnerCardProps } from "../../interfaces/IPartnerCardProps";

export default function PartnerCard({ name, logo }: IPartnerCardProps) {
  return (
    <div className="flex h-[126px] w-full items-center justify-center rounded-[14px] bg-white px-8 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
      <img
        src={logo}
        alt={name}
        className="max-h-[100px] max-w-[250px] object-contain"
        loading="lazy"
      />
    </div>
  );
}
