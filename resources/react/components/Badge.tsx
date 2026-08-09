import type { CSSProperties, ReactNode } from "react";

interface BadgeProps {
  children: ReactNode;
  className?: string;
  contentClassName?: string;
  size?: "sm" | "md";
  bgColor?: string;
}

const sizeClasses = {
  sm: {
    outer: "h-[84px] w-[84px]",
    inner: "inset-[5px]",
    content: "inset-[20px]",
  },
  md: {
    outer: "h-[92px] w-[92px]",
    inner: "inset-[6px]",
    content: "inset-[22px]",
  },
};

const scallopClipPath =
  "polygon(50% 0%, 54% 4%, 59% 1%, 63% 6%, 68% 4%, 72% 10%, 77% 8%, 80% 15%, 85% 14%, 88% 21%, 93% 22%, 94% 30%, 99% 33%, 97% 41%, 100% 46%, 96% 52%, 99% 58%, 94% 63%, 96% 70%, 90% 74%, 90% 82%, 82% 84%, 79% 91%, 72% 90%, 68% 96%, 62% 94%, 57% 99%, 50% 96%, 43% 99%, 38% 94%, 32% 96%, 28% 90%, 21% 91%, 18% 84%, 10% 82%, 10% 74%, 4% 70%, 6% 63%, 1% 58%, 4% 52%, 0% 46%, 3% 41%, 1% 33%, 6% 30%, 7% 22%, 12% 21%, 15% 14%, 20% 15%, 23% 8%, 28% 10%, 32% 4%, 37% 6%, 41% 1%, 46% 4%)";

const scallopStyle: CSSProperties = {
  clipPath: scallopClipPath,
};

export default function Badge({
  children,
  className = "",
  contentClassName = "",
  size = "sm",
  bgColor = "bg-[#AA28EB]",
}: BadgeProps) {
  return (
    <div
      className={`absolute z-20 flex items-center justify-center rotate-[12deg] ${sizeClasses[size].outer} ${className}`}
    >
      {/* White outer shape */}
      <div
        style={scallopStyle}
        className="absolute inset-0 bg-white shadow-[0_8px_20px_rgba(15,23,42,0.18)]"
      />

      {/* Purple inner shape */}
      <div
        style={scallopStyle}
        className={`absolute ${sizeClasses[size].inner} ${bgColor}`}
      />

      {/* Content with padding */}
      <div
         className={`absolute ${sizeClasses[size].content} z-10 flex flex-col items-center justify-center text-center text-[12px] font-bold leading-none text-white ${contentClassName}`}
      >
        {children}
      </div>
    </div>
  );
}
