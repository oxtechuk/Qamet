interface LocationInfoProps {
  icon: React.ReactNode;
  label: string;
  value: string;
  href?: string;
}

export default function LocationInfo({ icon, label, value, href }: LocationInfoProps) {
  const content = (
    <p className="text-[17px] font-bold leading-7 text-[#07111F]">{value}</p>
  );

  return (
    <div className="flex flex-col items-center gap-2 text-center md:text-start">
      <div className="flex items-center justify-center gap-3">
        <div className="flex h-[38px] w-[38px] shrink-0 items-center justify-center rounded-full text-[var(--brand-secondary-color)]">
          {icon}
        </div>
        <p className="text-[14px] text-[#4B5563]">{label}</p>
      </div>
      {href ? (
        <a
          href={href}
          target="_blank"
          rel="noopener noreferrer"
          className="transition hover:text-[var(--brand-primary-color)]"
        >
          {content}
        </a>
      ) : (
        content
      )}
    </div>
  );
}
