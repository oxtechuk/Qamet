import Skeleton from "../Skeleton";
import CarsGridSkeleton from "./CarsGridSkeleton";

export default function AllCarsPageSkeleton() {
    return (
        <div aria-busy="true" aria-label="Loading cars page" className="w-full select-none">
            {/* Hero slides */}
            <section className="w-full px-[15px] py-5">
                <Skeleton className="h-[280px] w-full rounded-2xl sm:h-[360px]" />
            </section>

            {/* Mobile filter trigger */}
            <div className="mx-auto max-w-7xl px-4 pb-4 pt-2 sm:px-6 lg:hidden">
                <Skeleton className="h-[52px] w-full rounded-2xl" />
            </div>

            {/* Content */}
            <section className="mx-auto flex max-w-7xl items-start gap-6 px-4 py-6 sm:px-6 lg:px-8">
                {/* Desktop sidebar */}
                <div className="hidden w-64 shrink-0 lg:block">
                    <div className="space-y-6 rounded-[20px] border border-[#E5E7EB] bg-white p-5">
                        {Array.from({ length: 5 }).map((_, index) => (
                            <div key={index}>
                                <Skeleton className="h-4 w-24" />
                                <Skeleton className="mt-3 h-[42px] w-full rounded-[12px]" />
                            </div>
                        ))}
                        <Skeleton className="h-[44px] w-full rounded-2xl" />
                    </div>
                </div>

                {/* Main content */}
                <div className="min-w-0 flex-1">
                    <div className="mb-8 rounded-[20px] border border-[#E5E7EB] bg-white p-5">
                        <Skeleton className="h-[46px] w-full rounded-2xl" />
                        <Skeleton className="mt-3 h-3 w-32" />
                    </div>

                    <CarsGridSkeleton count={9} className="grid-cols-1 gap-7 sm:grid-cols-2 lg:grid-cols-3" />

                    <div className="mt-12 flex items-center justify-center gap-2.5">
                        {Array.from({ length: 5 }).map((_, index) => (
                            <Skeleton key={index} className="h-11 w-11 rounded-2xl" />
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}
