import type { ReactNode } from "react";
import { APP_IMAGES } from "../constants/app-images";

export function formatPrice(price: number, riyalColor: string): ReactNode {
  return (
    <span
      className="inline-flex items-center gap-1 align-middle"
      style={{ color: riyalColor }}
    >
      <span className="align-middle">
        {price.toLocaleString("en-US")}
      </span>

      <span
        aria-label="ريال"
        className="inline-block h-[14px] w-[14px] align-middle"
        style={{
          backgroundColor: riyalColor,
          WebkitMask: `url(${APP_IMAGES.RIYAL}) center / contain no-repeat`,
          mask: `url(${APP_IMAGES.RIYAL}) center / contain no-repeat`,
        }}
      />
    </span>
  );
}