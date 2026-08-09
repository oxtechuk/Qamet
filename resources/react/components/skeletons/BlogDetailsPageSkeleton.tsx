import Skeleton from "../Skeleton";
import BlogCardSkeleton from "./BlogCardSkeleton";

export default function BlogDetailsPageSkeleton() {
    return (
        <main
            aria-busy="true"
            aria-label="Loading blog article"
            className="w-full select-none"
        >
            {/* Hero */}
            <section className="w-full pt-12 pb-8">
                <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div className="mx-auto max-w-3xl text-start">
                        <Skeleton className="h-[44px] w-32 rounded-full" />
                        <Skeleton className="mt-5 h-10 w-full md:h-12" />
                        <Skeleton className="mt-2 h-10 w-3/4 md:h-12" />

                        <div className="mt-7 flex flex-wrap items-center gap-5">
                            <div className="flex items-center gap-4">
                                <Skeleton className="h-[40px] w-[40px] rounded-full" />
                                <Skeleton className="h-4 w-40" />
                            </div>
                            <Skeleton className="h-4 w-24" />
                            <Skeleton className="h-4 w-20" />
                        </div>
                    </div>
                </div>
            </section>

            {/* Cover image */}
            <section className="w-full pb-8">
                <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="h-[300px] w-full rounded-[24px] sm:h-[420px]" />
                </div>
            </section>

            {/* Article content */}
            <section className="w-full py-8">
                <div className="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
                    <div className="mx-auto max-w-3xl space-y-3">
                        {Array.from({ length: 6 }).map((_, index) => (
                            <Skeleton
                                key={index}
                                className={`h-4 w-full ${index === 5 ? "!w-2/3" : ""}`}
                            />
                        ))}
                        <Skeleton className="h-5 w-1/2 pt-2" />
                        <Skeleton className="h-4 w-full" />
                        <Skeleton className="h-4 w-3/4" />
                    </div>
                </div>
            </section>

            {/* Related articles */}
            <section className="w-full py-12">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <Skeleton className="mb-10 h-8 w-56" />
                    <div className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        {Array.from({ length: 3 }).map((_, index) => (
                            <BlogCardSkeleton key={index} />
                        ))}
                    </div>
                </div>
            </section>
        </main>
    );
}
