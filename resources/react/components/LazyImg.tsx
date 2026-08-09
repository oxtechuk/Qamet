import type { ImgHTMLAttributes } from "react";

export default function LazyImg(props: ImgHTMLAttributes<HTMLImageElement>) {
  const { className, style, loading = "lazy", ...rest } = props;

  return (
    <img
      {...rest}
      loading={loading}
      decoding="async"
      className={`${className ?? ""} skeleton`}
      style={style}
    />
  );
}
