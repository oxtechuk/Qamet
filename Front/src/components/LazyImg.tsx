import { type ImgHTMLAttributes, useRef, useState, useEffect } from "react";

const PLACEHOLDER =
  "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

export default function LazyImg(props: ImgHTMLAttributes<HTMLImageElement>) {
  const { src, className, style, onLoad, ...rest } = props;
  const imgRef = useRef<HTMLImageElement>(null);
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    const el = imgRef.current;
    if (!el) return;

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          const img = el;
          img.src = src as string;
          observer.unobserve(img);
        }
      },
      { rootMargin: "200px" }
    );

    observer.observe(el);
    return () => observer.disconnect();
  }, [src]);

  return (
    <img
      {...rest}
      ref={imgRef}
      src={PLACEHOLDER}
      onLoad={(e) => {
        setLoaded(true);
        onLoad?.(e);
      }}
      className={className}
      style={{
        ...style,
        clipPath: loaded ? "inset(0 0 0 0)" : "inset(0 0 100% 0)",
        transition: "clip-path 0.6s cubic-bezier(0.4, 0, 0.2, 1)",
      }}
    />
  );
}
