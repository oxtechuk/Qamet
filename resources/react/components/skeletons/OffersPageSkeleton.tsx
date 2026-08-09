import Skeleton from "../Skeleton";
import OfferListCardSkeleton from "./OfferListCardSkeleton";

export default function OffersPageSkeleton() {
    return (
        <div aria-busy="true" aria-label="Loading offers page" className="w-full select-none">
            {/* Hero */}
            <section className="w-full py-10 md:py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="relative w-full overflow-hidden rounded-[24px] bg-[#0B1736] sm:rounded-[32px]">
                        <Skeleton className="absolute inset-0 h-full w-full rounded-none" />

                        <div className="relative z-10 flex w-full flex-col items-center justify-between gap-8 px-6 py-10 text-center sm:px-10 sm:py-14 md:flex-row md:text-start">
                            <div className="flex max-w-xl flex-col items-center md:items-start">
                                <Skeleton className="h-6 w-24 rounded-full" />
                                <Skeleton className="mt-4 h-9 w-72 sm:w-96" />
                                <Skeleton className="mt-3 h-4 w-full max-w-md" />

                                <div className="mt-7 flex items-center gap-4">
                                    <Skeleton className="h-[52px] w-40 rounded-2xl" />
                                    <Skeleton className="h-[52px] w-40 rounded-2xl" />
                                </div>
                            </div>

                            <div className="flex shrink-0 flex-col items-center">
                                <Skeleton className="h-4 w-32" />
                                <div className="mt-3 flex items-center gap-2.5" dir="ltr">
                                    {Array.from({ length: 4 }).map((_, index) => (
                                        <Skeleton key={index} className="h-14 w-14 rounded-2xl sm:h-16 sm:w-16" />
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Grid */}
            <section className="w-full py-10">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-2 lg:grid-cols-3">
                        {Array.from({ length: 6 }).map((_, index) => (
                            <OfferListCardSkeleton key={index} />
                        ))}
                    </div>

                    <div className="mt-12 flex items-center justify-center gap-2">
                        {Array.from({ length: 5 }).map((_, index) => (
                            <Skeleton key={index} className="h-[46px] w-[46px] rounded-[12px]" />
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}
