import { type ImgHTMLAttributes, useState, useEffect } from "react";
import { APP_IMAGES } from "../constants/app-images";

export default function LazyImg({
  src,
  alt,
  className,
  onError,
  ...rest
}: ImgHTMLAttributes<HTMLImageElement>) {
  const [imgSrc, setImgSrc] = useState<string | undefined>(src);
  const [hasError, setHasError] = useState(false);

  useEffect(() => {
    setImgSrc(src);
    setHasError(false);
  }, [src]);

  const handleError = (e: React.SyntheticEvent<HTMLImageElement, Event>) => {
    if (!hasError) {
      setHasError(true);
      setImgSrc(APP_IMAGES.CAR_PLACEHOLDER);
    }
    onError?.(e);
  };

  return (
    <img
      {...rest}
      src={imgSrc || APP_IMAGES.CAR_PLACEHOLDER}
      alt={alt ?? ""}
      loading="lazy"
      decoding="async"
      onError={handleError}
      className={className}
    />
  );
}
