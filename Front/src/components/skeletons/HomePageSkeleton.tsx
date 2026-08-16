import Skeleton from "../Skeleton";
import SectionHeaderSkeleton from "./SectionHeaderSkeleton";
import CarsGridSkeleton from "./CarsGridSkeleton";

export default function HomePageSkeleton() {
    return (
        <div
            aria-busy="true"
            aria-label="Loading home page"
            className="w-full select-none"
        >
            {/* Home Hero */}
            <section className="w-full pt-2">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="h-[300px] w-full rounded-3xl sm:h-[400px] lg:h-[520px]" />
                </div>
            </section>

            {/* Featured Cars */}
            <section className="relative w-full overflow-hidden py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <SectionHeaderSkeleton />
                    <CarsGridSkeleton />
                </div>
            </section>

            {/* Purchase Experience */}
            <section className="w-full py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="mx-auto mb-12 h-9 w-56 md:w-72" />

                    <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        {Array.from({ length: 4 }).map((_, index) => (
                            <div
                                key={index}
                                className="rounded-2xl border border-[#E7E9EF] bg-white p-6"
                            >
                                <Skeleton className="h-[52px] w-[52px] rounded-[15px]" />
                                <Skeleton className="mt-4 h-5 w-2/3" />
                                <Skeleton className="mt-3 h-4 w-full" />
                                <Skeleton className="mt-2 h-4 w-4/5" />
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Home Offers Banner */}
            <section className="w-full pb-6">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="h-[220px] w-full rounded-2xl sm:h-[300px]" />
                </div>
            </section>

            {/* Budget Cars */}
            <section className="w-full py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <Skeleton className="h-9 w-56 md:w-72" />
                            <Skeleton className="mt-3 h-4 w-full max-w-md" />
                        </div>
                        <Skeleton className="h-[44px] w-32 rounded-2xl" />
                    </div>

                    <div className="mb-9 flex flex-wrap gap-3">
                        {Array.from({ length: 4 }).map((_, index) => (
                            <Skeleton
                                key={index}
                                className="h-[40px] w-28 rounded-full"
                            />
                        ))}
                    </div>

                    <CarsGridSkeleton />
                </div>
            </section>

            {/* Brands */}
            <section className="w-full border-t border-[#E5E7EB] py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <Skeleton className="h-8 w-44" />
                        <Skeleton className="h-[46px] w-full max-w-xs rounded-2xl sm:w-64" />
                    </div>

                    <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                        {Array.from({ length: 6 }).map((_, index) => (
                            <div
                                key={index}
                                className="flex h-[140px] flex-col items-center justify-center rounded-2xl border border-[#E7E9EF] bg-white"
                            >
                                <Skeleton className="h-[52px] w-[52px] rounded-full" />
                                <Skeleton className="mt-4 h-5 w-20" />
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}
