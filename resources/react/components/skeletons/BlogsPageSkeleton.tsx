import Skeleton from "../Skeleton";
import BlogCardSkeleton from "./BlogCardSkeleton";

export default function BlogsPageSkeleton() {
    return (
        <div
            aria-busy="true"
            aria-label="Loading blog page"
            className="w-full select-none"
        >
            {/* ── Hero ── */}
            <section className="w-full bg-[#EDEFF3] py-5 sm:py-7 lg:py-8">
                <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
                    <div className="relative min-h-[285px] w-full overflow-hidden rounded-[18px] bg-[#E2E6EC] sm:min-h-[360px] lg:min-h-[430px]">
                        <div className="flex min-h-[285px] flex-col justify-between px-5 py-5 sm:min-h-[260px] sm:px-8 sm:py-7 lg:min-h-[330px] lg:px-12 lg:py-10">
                            {/* Badge */}
                            <Skeleton className="h-[30px] w-24 rounded-full" />

                            {/* Details */}
                            <div className="max-w-[900px] self-start text-start">
                                <Skeleton className="mb-3 h-3 w-28 rounded-full" />
                                <Skeleton className="h-[28px] w-full max-w-[700px] sm:h-[38px] lg:h-[44px]" />
                                <Skeleton className="mt-2 h-[28px] w-3/4 max-w-[520px] sm:h-[38px] lg:h-[44px]" />
                                <Skeleton className="mt-4 h-4 w-full max-w-[760px]" />
                                <Skeleton className="mt-2 h-4 w-2/3 max-w-[600px]" />

                                <div className="mt-5 flex flex-wrap items-center gap-x-5 gap-y-3">
                                    <Skeleton className="h-4 w-28" />
                                    <Skeleton className="h-4 w-20" />
                                    <Skeleton className="h-4 w-24" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* ── Category pills ── */}
                    <div className="mt-7 flex flex-wrap items-start justify-start gap-3">
                        {Array.from({ length: 5 }).map((_, index) => (
                            <Skeleton key={index} className="h-[40px] w-24 rounded-full" />
                        ))}
                    </div>
                </div>
            </section>

            {/* ── Latest articles ── */}
            <section className="w-full py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-x-10 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
                        {Array.from({ length: 6 }).map((_, index) => (
                            <BlogCardSkeleton key={index} />
                        ))}
                    </div>

                    {/* Load more */}
                    <div className="mt-12 flex justify-center">
                        <Skeleton className="h-[42px] w-52 rounded-full" />
                    </div>
                </div>
            </section>
        </div>
    );
}
