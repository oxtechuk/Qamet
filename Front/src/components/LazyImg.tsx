import { type ImgHTMLAttributes } from "react";

const PLACEHOLDER =
  "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

export default function LazyImg(props: ImgHTMLAttributes<HTMLImageElement>) {
  const { src, className, ...rest } = props;

  return (
    <img
      {...rest}
      data-src={src}
      src={PLACEHOLDER}
      className={`lazyload ${className ?? ""}`}
    />
  );
}
