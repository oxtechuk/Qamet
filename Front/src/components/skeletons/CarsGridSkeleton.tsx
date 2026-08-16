import CarCardSkeleton from "./CarCardSkeleton";

interface ICarsGridSkeletonProps {
    count?: number;
    className?: string;
}

export default function CarsGridSkeleton({
    count = 4,
    className = "grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-4",
}: ICarsGridSkeletonProps) {
    return (
        <div className={`grid ${className}`}>
            {Array.from({ length: count }).map((_, index) => (
                <CarCardSkeleton key={index} />
            ))}
        </div>
    );
}
