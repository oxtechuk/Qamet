import Skeleton from "./Skeleton";
import CarCardSkeleton from "./CarCardSkeleton";

export default function HomePageSkeleton() {
    return (
        <div className="w-full space-y-12 pb-16">
            {/* 1. HERO SECTION SKELETON */}
            <section className="relative min-h-[520px] w-full overflow-hidden bg-[var(--brand-primary-color,#021F38)] sm:min-h-[580px] md:min-h-[640px]">
                {/* Background Shimmer & Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60" />

                {/* Top Header Placeholder */}
                <header className="absolute inset-x-0 top-0 z-30 px-5 pt-7 sm:px-8 md:px-10 lg:px-12">
                    <div className="relative flex items-center justify-between">
                        {/* Menu button placeholder */}
                        <Skeleton className="hidden h-[42px] w-[110px] rounded-[12px] bg-white/20 sm:block" />

                        {/* Centered Logo placeholder */}
                        <div className="absolute left-1/2 top-0 -translate-x-1/2">
                            <Skeleton className="h-[52px] w-[130px] rounded-xl bg-white/20 sm:h-[60px]" />
                        </div>
                    </div>
                </header>

                {/* Hero Content Text Placeholder */}
                <div className="absolute top-1/2 z-20 w-full -translate-y-1/2 px-5 sm:px-8 md:left-[6.5%] md:w-[45%] md:px-0">
                    <div className="space-y-4">
                        <Skeleton className="h-9 w-3/4 rounded-xl bg-white/25 sm:h-12" />
                        <Skeleton className="h-7 w-1/2 rounded-xl bg-white/20 sm:h-9" />
                        <Skeleton className="h-5 w-2/3 rounded-lg bg-white/15" />

                        {/* CTA Buttons */}
                        <div className="flex flex-wrap items-center gap-4 pt-4">
                            <Skeleton className="h-12 w-36 rounded-xl bg-[var(--brand-secondary-color,#DFC675)]/80" />
                            <Skeleton className="h-12 w-36 rounded-xl bg-white/20" />
                        </div>
                    </div>
                </div>

                {/* Bottom Car Finder Filter Bar Placeholder */}
                <div className="absolute inset-x-4 bottom-6 z-20 mx-auto max-w-6xl rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md sm:inset-x-8 sm:p-6">
                    <div className="grid grid-cols-2 gap-3 md:grid-cols-5">
                        <Skeleton className="h-11 rounded-xl bg-white/20" />
                        <Skeleton className="h-11 rounded-xl bg-white/20" />
                        <Skeleton className="h-11 rounded-xl bg-white/20" />
                        <Skeleton className="h-11 rounded-xl bg-white/20" />
                        <Skeleton className="col-span-2 h-11 rounded-xl bg-[var(--brand-secondary-color,#DFC675)]/80 md:col-span-1" />
                    </div>
                </div>
            </section>

            {/* 2. FEATURED CARS SECTION SKELETON */}
            <section className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-6">
                <div className="mb-8 flex items-center justify-between">
                    <div>
                        <Skeleton className="h-8 w-48 rounded-lg bg-gray-200/50" />
                        <Skeleton className="mt-2 h-4 w-32 rounded-md bg-gray-200/40" />
                    </div>
                    <Skeleton className="h-10 w-28 rounded-xl bg-gray-200/50" />
                </div>

                {/* 4 Car Card Skeletons */}
                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <CarCardSkeleton />
                    <CarCardSkeleton />
                    <CarCardSkeleton />
                    <CarCardSkeleton />
                </div>
            </section>

            {/* 3. PURCHASE EXPERIENCE SECTION SKELETON */}
            <section className="mx-auto max-w-[1440px] px-4 py-8 sm:px-6 lg:px-8">
                <div className="max-w-[520px] space-y-3">
                    <Skeleton className="h-9 w-3/4 rounded-xl bg-gray-200/50" />
                    <Skeleton className="h-4 w-full rounded-md bg-gray-200/40" />
                    <Skeleton className="h-4 w-5/6 rounded-md bg-gray-200/40" />
                </div>

                <div className="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {Array.from({ length: 4 }).map((_, i) => (
                        <div
                            key={i}
                            className="min-h-[175px] rounded-[16px] border border-[#D9D9D5] bg-white p-6 shadow-sm"
                        >
                            <Skeleton className="h-[52px] w-[52px] rounded-[15px] bg-gray-200/50" />
                            <Skeleton className="mt-4 h-5 w-2/3 rounded-md bg-gray-200/50" />
                            <Skeleton className="mt-3 h-4 w-full rounded-md bg-gray-200/40" />
                            <Skeleton className="mt-2 h-4 w-4/5 rounded-md bg-gray-200/40" />
                        </div>
                    ))}
                </div>
            </section>

            {/* 4. HOME OFFERS SECTION SKELETON */}
            <section className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="h-48 w-full overflow-hidden rounded-2xl sm:h-64">
                    <Skeleton className="h-full w-full rounded-2xl bg-gray-200/40" />
                </div>
            </section>

            {/* 5. BUDGET CARS SECTION SKELETON */}
            <section className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
                <div className="mb-6 space-y-2">
                    <Skeleton className="h-8 w-56 rounded-lg bg-gray-200/50" />
                    <Skeleton className="h-4 w-72 rounded-md bg-gray-200/40" />
                </div>

                {/* Filter Range Pills */}
                <div className="mb-8 flex flex-wrap gap-3">
                    <Skeleton className="h-10 w-28 rounded-full bg-gray-200/50" />
                    <Skeleton className="h-10 w-32 rounded-full bg-gray-200/50" />
                    <Skeleton className="h-10 w-28 rounded-full bg-gray-200/50" />
                    <Skeleton className="h-10 w-36 rounded-full bg-gray-200/50" />
                </div>

                {/* 4 Car Card Skeletons */}
                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <CarCardSkeleton />
                    <CarCardSkeleton />
                    <CarCardSkeleton />
                    <CarCardSkeleton />
                </div>
            </section>

            {/* 6. BRANDS SECTION SKELETON */}
            <section className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
                <div className="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <Skeleton className="h-8 w-44 rounded-lg bg-gray-200/50" />
                    <Skeleton className="h-11 w-full max-w-xs rounded-xl bg-gray-200/50 sm:w-64" />
                </div>

                {/* Brand Card Skeletons */}
                <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    {Array.from({ length: 6 }).map((_, i) => (
                        <div
                            key={i}
                            className="flex h-[150px] flex-col items-center justify-center rounded-[16px] border border-gray-100 bg-white p-4 shadow-sm"
                        >
                            <Skeleton className="h-[52px] w-[52px] rounded-full bg-gray-200/50" />
                            <Skeleton className="mt-4 h-5 w-20 rounded-md bg-gray-200/40" />
                        </div>
                    ))}
                </div>
            </section>
        </div>
    );
}
