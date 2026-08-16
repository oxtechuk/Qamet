import Skeleton from "../Skeleton";

export default function AboutPageSkeleton() {
    return (
        <div aria-busy="true" aria-label="Loading about page" className="w-full select-none">
            {/* Intro hero */}
            <section className="w-full bg-[#EDEFF3] py-14 sm:py-16">
                <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
                    <div className="mx-auto max-w-[620px] text-center">
                        <div className="flex flex-wrap items-center justify-center gap-2">
                            <Skeleton className="h-9 w-40 sm:h-[38px] sm:w-52" />
                            <Skeleton className="h-9 w-28 sm:h-[38px] sm:w-40" />
                        </div>
                        <Skeleton className="mx-auto mt-4 h-4 w-full max-w-[560px]" />
                        <Skeleton className="mx-auto mt-2 h-4 w-3/4 max-w-[420px]" />
                    </div>
                </div>
            </section>

            {/* Core values */}
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

            {/* Why choose us */}
            <section className="w-full bg-[#F9FAFB] py-14">
                <div className="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                    <div>
                        <Skeleton className="h-9 w-64" />
                        <Skeleton className="mt-4 h-4 w-full" />
                        <Skeleton className="mt-2 h-4 w-3/4" />
                    </div>
                    <div className="space-y-4">
                        {Array.from({ length: 4 }).map((_, index) => (
                            <div
                                key={index}
                                className="flex items-start gap-4 rounded-2xl border border-[#E7E9EF] bg-white p-5"
                            >
                                <Skeleton className="h-10 w-10 shrink-0 rounded-xl" />
                                <div className="flex-1">
                                    <Skeleton className="h-5 w-1/2" />
                                    <Skeleton className="mt-2 h-4 w-full" />
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Gallery */}
            <section className="w-full py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="mx-auto mb-12 h-9 w-52" />
                    <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        {Array.from({ length: 4 }).map((_, index) => (
                            <Skeleton key={index} className="h-[220px] w-full rounded-[20px]" />
                        ))}
                    </div>
                </div>
            </section>

            {/* Testimonials */}
            <section className="w-full bg-[#F9FAFB] py-14">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="mx-auto mb-12 h-9 w-56" />
                    <div className="mx-auto max-w-2xl">
                        <div className="rounded-[24px] border border-[#E7E9EF] bg-white p-8 text-center">
                            <Skeleton className="mx-auto h-5 w-28" />
                            <Skeleton className="mx-auto mt-6 h-4 w-full" />
                            <Skeleton className="mx-auto mt-2 h-4 w-5/6" />
                            <Skeleton className="mx-auto mt-8 h-12 w-12 rounded-full" />
                            <Skeleton className="mx-auto mt-3 h-4 w-28" />
                            <Skeleton className="mx-auto mt-1 h-3 w-20" />
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}
