import Skeleton from "../Skeleton";

export default function OfferListCardSkeleton() {
    return (
        <article className="overflow-hidden rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm">
            <div className="relative h-[210px] w-full overflow-hidden">
                <Skeleton className="h-full w-full rounded-none" />
                <Skeleton className="absolute start-3 top-3 h-7 w-20 rounded-full" />
                <Skeleton className="absolute bottom-3 end-3 h-7 w-28 rounded-full" />
            </div>

            <div className="px-4 pb-4 pt-4">
                <Skeleton className="h-5 w-3/4" />
                <Skeleton className="mt-3 h-4 w-full" />
                <Skeleton className="mt-2 h-4 w-2/3" />

                <div className="my-3 border-t border-[#F0F2F5]" />

                <div className="flex items-center justify-between gap-3">
                    <div className="flex-1">
                        <Skeleton className="h-3 w-20" />
                        <Skeleton className="mt-1.5 h-6 w-28" />
                    </div>
                    <Skeleton className="h-[44px] w-[100px] rounded-[16px]" />
                </div>
            </div>
        </article>
    );
}
