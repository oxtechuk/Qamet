import Skeleton from "./Skeleton";

export default function CarCardSkeleton() {
    return (
        <article className="relative mx-auto flex h-full w-full max-w-[336px] flex-col overflow-hidden rounded-[20px] border border-[#E5E9EF] bg-white shadow-sm">
            {/* Image Placeholder */}
            <div className="relative h-[210px] w-full bg-gray-50">
                <Skeleton className="h-full w-full rounded-none bg-gray-200/40" />
                {/* Badge Skeleton */}
                <div className="absolute top-3 left-3">
                    <Skeleton className="h-7 w-20 rounded-full bg-gray-200/60" />
                </div>
                {/* Compare Button Skeleton */}
                <div className="absolute bottom-3 right-3">
                    <Skeleton className="h-[42px] w-[42px] rounded-[12px] bg-gray-200/60" />
                </div>
            </div>

            {/* Info Container */}
            <div className="flex flex-1 flex-col px-4 pb-4 pt-3">
                {/* Title */}
                <Skeleton className="h-6 w-3/4 rounded-md bg-gray-200/50" />

                {/* Subtitle / Year */}
                <Skeleton className="mt-2 h-4 w-1/3 rounded-md bg-gray-200/40" />

                {/* Specs row */}
                <div className="mt-4 flex items-center justify-start gap-4 border-b border-[#EEF2F6] pb-3">
                    <Skeleton className="h-4 w-16 rounded-md bg-gray-200/40" />
                    <Skeleton className="h-4 w-16 rounded-md bg-gray-200/40" />
                    <Skeleton className="h-4 w-16 rounded-md bg-gray-200/40" />
                </div>

                {/* Price and Action Row */}
                <div className="mt-auto flex items-center justify-between pt-4">
                    <div className="space-y-1.5">
                        <Skeleton className="h-6 w-24 rounded-md bg-gray-200/50" />
                        <Skeleton className="h-3 w-20 rounded-md bg-gray-200/40" />
                    </div>
                    <Skeleton className="h-[40px] w-[96px] rounded-[12px] bg-gray-200/60" />
                </div>
            </div>
        </article>
    );
}
