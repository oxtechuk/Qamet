import Skeleton from "../Skeleton";

export default function BlogCardSkeleton() {
    return (
        <article className="block w-full overflow-hidden rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm">
            <div className="relative h-[220px] w-full overflow-hidden">
                <Skeleton className="h-full w-full rounded-none" />
                <Skeleton className="absolute start-3 top-3 h-7 w-20 rounded-full" />
            </div>

            <div className="px-4 pb-5 pt-4">
                <div className="flex items-center gap-3">
                    <Skeleton className="h-4 w-16" />
                    <Skeleton className="h-3 w-3 rounded-full" />
                    <Skeleton className="h-4 w-20" />
                </div>

                <Skeleton className="mt-3 h-5 w-full" />
                <Skeleton className="mt-2 h-5 w-3/4" />

                <Skeleton className="mt-3 h-4 w-full" />
                <Skeleton className="mt-2 h-4 w-2/3" />

                <div className="mt-4 flex items-center justify-start gap-3 border-t border-[#F3F4F6] pt-4">
                    <Skeleton className="h-[40px] w-[40px] rounded-full" />
                    <div className="flex-1">
                        <Skeleton className="h-4 w-24" />
                        <Skeleton className="mt-1 h-3 w-16" />
                    </div>
                </div>
            </div>
        </article>
    );
}
