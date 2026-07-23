import { type ImgHTMLAttributes } from "react";

export default function LazyImg(props: ImgHTMLAttributes<HTMLImageElement>) {
  const { src, className, ...rest } = props;

  return (
    <img
      {...rest}
      data-src={src}
      src=""
      className={`lazyload ${className ?? ""}`}
    />
  );
}
