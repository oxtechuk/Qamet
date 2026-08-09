import { HTMLAttributes } from "react";

interface SkeletonProps extends HTMLAttributes<HTMLDivElement> {
    className?: string;
}

export default function Skeleton({ className = "", ...props }: SkeletonProps) {
    return (
        <div
            className={`animate-pulse rounded-md bg-gray-200/50 dark:bg-gray-700/30 ${className}`}
            {...props}
        />
    );
}
