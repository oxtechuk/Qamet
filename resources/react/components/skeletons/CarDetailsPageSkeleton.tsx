import Skeleton from "../Skeleton";

export default function CarDetailsPageSkeleton() {
    return (
        <div aria-busy="true" aria-label="Loading car details" className="w-full select-none">
            {/* Hero: gallery + content */}
            <section className="w-full py-10">
                <div className="mx-auto grid max-w-7xl grid-cols-1 items-start gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                    {/* Gallery */}
                    <div className="w-full">
                        <div className="relative w-full overflow-hidden rounded-[24px] bg-[#F3F4F6]">
                            <Skeleton className="h-[320px] w-full rounded-none sm:h-[420px] lg:h-[480px]" />
                        </div>

                        <div className="mt-4 flex items-center justify-center gap-3" dir="ltr">
                            {Array.from({ length: 4 }).map((_, index) => (
                                <Skeleton
                                    key={index}
                                    className="h-[68px] w-[86px] rounded-[12px]"
                                />
                            ))}
                        </div>
                    </div>

                    {/* Content */}
                    <div className="order-1 lg:order-2">
                        <div className="rounded-[20px] border border-[#E5E7EB] bg-white px-5 py-6 shadow-sm">
                            <Skeleton className="h-7 w-3/4" />
                            <Skeleton className="mt-3 h-4 w-full" />
                            <Skeleton className="mt-2 h-4 w-2/3" />

                            <div className="my-6 border-t border-[#F3F4F6]" />

                            <Skeleton className="h-6 w-40" />
                            <Skeleton className="mt-2 h-4 w-24" />

                            <div className="mt-6 grid grid-cols-3 gap-3">
                                {Array.from({ length: 3 }).map((_, index) => (
                                    <div
                                        key={index}
                                        className="rounded-[14px] border border-[#E5E7EB] p-3"
                                    >
                                        <Skeleton className="h-4 w-16" />
                                        <Skeleton className="mt-2 h-6 w-14" />
                                    </div>
                                ))}
                            </div>

                            <Skeleton className="mt-6 h-[52px] w-full rounded-2xl" />
                        </div>
                    </div>
                </div>
            </section>

            {/* Specs */}
            <section className="w-full py-10">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="mb-6 flex flex-wrap gap-2">
                        {Array.from({ length: 4 }).map((_, index) => (
                            <Skeleton key={index} className="h-[40px] w-28 rounded-2xl" />
                        ))}
                    </div>

                    <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        {Array.from({ length: 8 }).map((_, index) => (
                            <div
                                key={index}
                                className="rounded-[16px] border border-[#E5E7EB] bg-white p-5"
                            >
                                <Skeleton className="h-5 w-5 rounded-lg" />
                                <Skeleton className="mt-4 h-4 w-20" />
                                <Skeleton className="mt-2 h-5 w-24" />
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}
