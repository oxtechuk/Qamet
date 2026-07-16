import type { ILoadingSpinnerProps } from "../interfaces/ILoadingSpinnerProps";

export default function LoadingSpinner({ className = "" }: ILoadingSpinnerProps) {
  return (
    <div className={`flex min-h-[400px] items-center justify-center ${className}`}>
      <div className="h-10 w-10 animate-spin rounded-full border-4 border-[var(--brand-primary-color)] border-t-transparent" />
    </div>
  );
}
