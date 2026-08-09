import Skeleton from "../Skeleton";

export default function BrandsPageSkeleton() {
    return (
        <section
            aria-busy="true"
            aria-label="Loading brands page"
            className="w-full select-none py-16"
        >
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="mb-10">
                    <Skeleton className="h-[40px] w-56 md:w-72" />
                </div>

                <div className="mb-12">
                    <Skeleton className="h-[52px] w-full max-w-md rounded-2xl" />
                </div>

                <div className="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:grid-cols-5">
                    {Array.from({ length: 10 }).map((_, index) => (
                        <div
                            key={index}
                            className="flex h-[140px] flex-col items-center justify-center rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm"
                        >
                            <Skeleton className="h-[52px] w-[52px] rounded-full" />
                            <Skeleton className="mt-4 h-4 w-20" />
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
