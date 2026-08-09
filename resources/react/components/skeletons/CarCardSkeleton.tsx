import Skeleton from "../Skeleton";

export default function CarCardSkeleton() {
    return (
        <article className="mx-auto w-full max-w-[336px] overflow-hidden rounded-[20px] border border-[#E5E9EF] bg-white shadow-sm">
            <div className="h-[210px] overflow-hidden">
                <Skeleton className="h-full w-full rounded-none" />
            </div>

            <div className="px-4 pb-4 pt-3">
                <Skeleton className="h-5 w-40" />

                <Skeleton className="mt-2 h-3 w-24" />

                <div className="mt-3 flex items-center gap-4 border-b border-[#EEF2F6] pb-3">
                    <Skeleton className="h-4 w-16" />
                    <Skeleton className="h-4 w-16" />
                    <Skeleton className="h-4 w-16" />
                </div>

                <div className="flex items-center justify-between pt-4">
                    <Skeleton className="h-6 w-20" />
                    <Skeleton className="h-[40px] w-[96px] rounded-[12px]" />
                </div>
            </div>
        </article>
    );
}
