import Skeleton from "../Skeleton";

export default function ContactPageSkeleton() {
    return (
        <div
            aria-busy="true"
            aria-label="Loading contact page"
            className="w-full select-none"
        >
            {/* ── Contact methods ── */}
            <section className="w-full bg-[#FAFAF8] py-12 sm:py-16">
                <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
                    <Skeleton className="h-10 w-64 sm:h-[42px] sm:w-72" />

                    <div className="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3 lg:gap-7">
                        {Array.from({ length: 3 }).map((_, index) => (
                            <div
                                key={index}
                                className="flex min-h-[122px] items-center gap-5 rounded-[18px] border border-[#E2E2DE] bg-white px-6 py-5 shadow-[0_3px_10px_rgba(15,23,42,0.08)]"
                            >
                                <Skeleton className="h-[54px] w-[54px] shrink-0 rounded-[16px]" />
                                <div className="min-w-0 flex-1">
                                    <Skeleton className="h-3 w-20" />
                                    <Skeleton className="mt-1.5 h-5 w-32" />
                                    <Skeleton className="mt-1.5 h-3 w-full max-w-[220px]" />
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* ── Contact us: branch map + form ── */}
            <section className="w-full py-14">
                <div className="mx-auto grid max-w-7xl grid-cols-1 items-start gap-8 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                    {/* Branch map + departments */}
                    <div className="space-y-4">
                        <Skeleton className="h-[260px] w-full rounded-[24px]" />
                        <Skeleton className="h-[96px] w-full rounded-[16px]" />
                        <Skeleton className="h-[96px] w-full rounded-[16px]" />
                    </div>

                    {/* Form */}
                    <div className="rounded-[20px] border border-[#E5E7EB] bg-white px-6 py-8 shadow-sm">
                        <Skeleton className="h-6 w-48" />
                        <Skeleton className="mt-1.5 h-4 w-full max-w-md" />

                        <div className="mt-6 space-y-5">
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <Skeleton className="mb-1.5 h-3 w-24" />
                                    <Skeleton className="h-[52px] w-full rounded-[10px]" />
                                </div>
                                <div>
                                    <Skeleton className="mb-1.5 h-3 w-24" />
                                    <Skeleton className="h-[52px] w-full rounded-[10px]" />
                                </div>
                            </div>

                            <div>
                                <Skeleton className="mb-2 h-3 w-24" />
                                <div className="flex flex-wrap gap-2">
                                    {Array.from({ length: 4 }).map((_, index) => (
                                        <Skeleton
                                            key={index}
                                            className="h-[38px] w-28 rounded-[10px]"
                                        />
                                    ))}
                                </div>
                            </div>

                            <div>
                                <Skeleton className="mb-1.5 h-3 w-24" />
                                <Skeleton className="h-[120px] w-full rounded-[10px]" />
                            </div>

                            <Skeleton className="h-[52px] w-full rounded-[12px]" />

                            <div className="flex items-center gap-3">
                                <Skeleton className="h-px flex-1" />
                                <Skeleton className="h-3 w-16" />
                                <Skeleton className="h-px flex-1" />
                            </div>

                            <Skeleton className="h-[52px] w-full rounded-[12px]" />
                        </div>
                    </div>
                </div>
            </section>

            {/* ── FAQ ── */}
            <section className="w-full bg-[#F9F9F7] py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="h-9 w-64 md:h-[38px] md:w-80" />
                    <Skeleton className="mt-3 h-4 w-72" />

                    <div className="mt-8 space-y-3">
                        {Array.from({ length: 4 }).map((_, index) => (
                            <div
                                key={index}
                                className="rounded-[16px] border border-[#E2E2DE] bg-white p-5"
                            >
                                <Skeleton className="h-5 w-full" />
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}
