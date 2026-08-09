interface ISkeletonProps {
  className?: string;
}

export default function Skeleton({ className = "" }: ISkeletonProps) {
  return <div aria-hidden="true" className={`skeleton ${className}`} />;
}
