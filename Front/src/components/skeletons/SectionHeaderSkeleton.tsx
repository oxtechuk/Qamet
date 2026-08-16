import Skeleton from "../Skeleton";

interface ISectionHeaderSkeletonProps {
    titleClassName?: string;
    className?: string;
}

export default function SectionHeaderSkeleton({
    titleClassName = "h-9 w-48 md:w-72",
    className = "",
}: ISectionHeaderSkeletonProps) {
    return (
        <div
            className={`mb-10 flex flex-col gap-5 md:flex-row md:items-start md:justify-between ${className}`}
        >
            <Skeleton className={titleClassName} />
            <Skeleton className="h-[44px] w-32 rounded-2xl" />
        </div>
    );
}
